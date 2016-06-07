<?php
require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";
use Edu\Cnm\MlbScout;{user:};
/**
 * api for signing in
 *
 * @author Eliot Robert Ostling <it.treugott@gmail.com>
 **/
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare default error message
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/mlbscout.ini");
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if($method === "GET") {
		//set xsrf cookie
		setXsrfCookie();
	}

	//perform the actual POST
	else if($method === "POST") {
		verifyXsrf();
		// convert JSON to an object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//check that username and password fields have been filled, and sanitize
		if(empty($requestObject->userName) === true) {
			throw(new \InvalidArgumentException("Give me username", 405));
		} else {
			$userName = filter_var($requestObject->userName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		}
		if (empty($requestObject->userPassword) === true) {
			throw(new \InvalidArgumentException ("Give me cryptic password", 405));
		} else {
			$password = filter_var($requestObject->userPassword, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		}
		//create the user
		$user = user::getUserByUserUsername($pdo, $userName);
		if(empty($user)) {
			throw (new \InvalidArgumentException("Both are incorrect", 401));
		}

		//if they have an activation token, the account is not activated yet
		if($user->getUserActivationToken() !== null) {
			throw(new \InvalidArgumentException("YunoSignupforAccount", 401));
		}
		//get the hash
		$hash =  hash_pbkdf2("sha512", $password, $user->getUserSalt(), 262144);
		//check the hash against inputted data-- no match, throw exception
		if($hash !== $user->getUserHash()) {
			throw(new \InvalidArgumentException("Tough Day? Try again", 401));
		}
		$_SESSION["user"] = $user;
		if ($user->getUserId() !== null) {
			$_SESSION["user"] = MlbScout\User::getUserByUserId($pdo, $user->getUserId());
		}
		$reply->message = "Whooop there it is!";
	} else {
		throw (new \InvalidArgumentException("Invalid HTTP method request"));
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
// encode and return reply to front end caller
echo json_encode($reply);