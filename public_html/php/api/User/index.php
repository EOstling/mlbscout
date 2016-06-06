<?php
use Edu\Cnm\MlbScout;

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
/**
 * api for the User Class
 *
 * @author Jared Padilla
 **/
// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/mlbscout.ini");
	// determine which HTTP was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$userAccessLevelId = filter_input(INPUT_GET, "userAccessLevelId", FILTER_VALIDATE_INT);
	$userActivationToken = filter_input(INPUT_GET, "userActivationToken", FILTER_SANITIZE_STRING);
	$userEmail = filter_input(INPUT_GET, "userEmail", FILTER_SANITIZE_STRING);
	$userFirstName = filter_input(INPUT_GET, "userFirstName", FILTER_SANITIZE_STRING);
	$userHash = filter_input(INPUT_GET, "userHash", FILTER_SANITIZE_STRING);
	$userLastName = filter_input(INPUT_GET, "userLastName", FILTER_SANITIZE_STRING);
	$userPhoneNumber = filter_input(INPUT_GET, "userPhoneNumber", FILTER_VALIDATE_INT);
	$userSalt = filter_input(INPUT_GET, "userSalt", FILTER_SANITIZE_STRING);
	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new \InvalidArgumentException("id cannot be empty or negative", 405));
	}
	// handle GET request - if id is present, that player is returned
	if ($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();
		// get a specific user and  reply
		if (empty ($id) === false) {
			$user = MlbScout\User::getUserByUserId($pdo, $Id);
			if($user !== null) {
				$reply->data = $user;
			}
		} // get user by email and update reply
		else if (empty($userEmail) === false) {
			$user = MlbScout\User::getUserByUserEmail($pdo, $userEmail);
			if($user !== null) {
				$reply->data = $user;
			}
		} else {
			$users = MlbScout\User::getAllUsers($pdo)->toArray();
			if($users !== null) {
				$reply->data = $users;
			}
		}
	} else if($method === "PUT" || $method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		// make sure user email is available
		if(empty($requestObject->userEmail) === true) {
			throw(new \InvalidArgumentException("No email for User.", 405));
		}
		if(empty($requestObject->userFirstName) === true) {
			throw(new \InvalidArgumentException("No first name for User, Y U No Have First Name?", 405));
		}
		if(empty($requestObject->userLastName) === true) {
			throw(new \InvalidArgumentException("No last name for User.", 405));
		}
		if(empty($requestObject->userPhoneNumber) === true) {
			throw(new \InvalidArgumentException("No phone number for User.", 405));
		}
		// perform the actual put or post
		if($method === "PUT") {
			// retrieve the user to update
			$user = MlbScout\User::getUserByUserId($pdo, $id);
			if($user === null) {
				throw(new \RuntimeException("User does not exist.",404));
			}
			// put the user content into the user and update it
			$user->setUserEmail($requestObject->userEmail);
			$user->setUserFirstName($requestObject->userFirstName);
			$user->setUserLastName($requestObject->userLastName);
			$user->setUserPhoneNumber($requestObject->userPhoneNumber);
			// require a password. Hash the password and set it.
			if(($requestObject->userPassword) !== null) {
				$hash = hash_pbkdf2("sha512", $requestObject->userPassword, $user->getUserSalt(), 40196, 128);
				$user->setUserHash($hash);
			}
			if(empty($requestObject->userPassword) === true) {
				throw(new \PDOException("Password is required"));
			}
			if($user->getUserId() === false && ($requestObject->userPassword !==null))
				$user->update($pdo);
			// update reply
			$reply->message = "User Updated!";
		} else if($method === "POST") {
			// make sure the access level id is available
			if (empty($requestObject->userAccessLevelId) === true) {
				throw (new \InvalidArgumentException ("NO ACCESS LEVLEL ID.", 405));
			}
			// Hash the password and set it
			$password = bin2hex(openssl_random_pseudo_bytes(32));
			$salt = bin2hex(random_bytes(32));
			$hash = hash_pbkdf2("sha512", $password, $salt, 40196, 128);
			$userActivationToken = bin2hex(random_bytes(16));
			// make sure accessLevelId is available
			if(empty($requestObject->userAccessLevelId) === true) {
				throw(new \InvalidArgumentException ("No Access Level ID.", 405));
			}
			// create new User and insert it into the database
			$user = new MlbScout\User(null, $requestObject->userAccessLevelId, $userActivationToken, $requestObject->userEmail, $requestObject->userFirstName, $hash, $requestObject->userLastName, $requestObject->userPhoneNumber, $salt, null);
			$user->insert($pdo);
			// update reply
			$reply->message = "User Created!";
			// create swift message to send email confirmation
			$swiftMessage = \Swift_Message::newInstance();
			// Attach sender to the message
			$swiftMessage->setFrom(["RealTimeScout@gmail.com"]);
			/**
			 * attach the recipients to the message
			 **/
			$recipients = [$requestObject->userEmail];
			$swiftMessage -> setTo($recipients);
			// attach the subject line to the message
			$swiftMessage->setSubject("Please confirm your RealTimeScout account");
			/**
			 * attach the message to the email
			 **/
			// activation link to confirm account
			$basePath = $_SERVER["SCRIPT_NAME"];
			for($i = 0; $i < 3; $i++) {
				$lastSlash = strrpos($basePath, "/");
				$basePath = substr($basePath, 0, $lastSlash);
			}
			$urlglue = $basePath . "/controllers/emailConfirmation?emailActivation=" . $user->getUserEmail();
			$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
			$message = <<< EOF
			<h1> You're now registered for Real Time Scout!<h1>
			<p>Visit the following URL to set a new password and complete the registration process: </p>
			<a href="$confirmLink">$confirmLink</a>
EOF;
			$swiftMessage->setBody($message, "TEXT/HTML");
			$swiftMessage->addPart(html_entity_decode(filter_var($message, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES)), "TEXT/PLAIN");
			/**
			 * send the Email via SMTP 
			 **/
			$smtp = Swift_SmtpTransport::newInstance("localhost", 25);
			$mailer = Swift_Mailer::newInstance($smtp);
			$numSent = $mailer->send($swiftMessage, $failedRecipients);
			/**
			 * the send method returns the number of recipients that accepted the Email
			 **/
			if($numSent !== count($recipients)) {
				throw(new \RuntimeException("Unable to send email", 404));
			}
		} 
	} else if($method === "DELETE") {
		verifyXsrf();
		// retrieve the User to be deleted 
		$user = MlbScout\User::getUserByUserId($pdo, $id);
		if($user === null) {
			throw(new \RuntimeException("User does not exist", 404));
		}
		// delete user
		$user->delete($pdo);
		// update reply
		$reply->message = "User Deleted!";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP method request"));
	}
	// update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);