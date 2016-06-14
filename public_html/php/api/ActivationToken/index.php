<?php
require_once(dirname(__DIR__, 4) . "/vendor/autoload.php");
require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\MlbScout\User;
/**
 * @author Eliot Robert Ostling <it.treugott@gmail.com>
 */
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare a empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
//Grab MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/mlbscout.ini");
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] :$_SERVER["REQUEST_METHOD"];
	if($method === "GET") {
//set Xsrf cookie
		setXsrfCookie("/");
		$userActivationToken = $_GET["ActivationToken"];
		if(empty($userActivationToken) === true|| ctype_xdigit($userActivationToken) === false) {
			throw(new \RangeException ("No ActivationToken Code"));
		}
		$user = User::getUserByUserActivationToken($pdo, $userActivationToken);
		if(empty($user)) {
			throw(new \InvalidArgumentException ("no user for activation token"));
		}
		$user->setUserActivationToken(null);
		$user->update($pdo);
		$reply->message = "Thank gulag! User is activated!";

		$message = <<< EOF
<h1>Welcome to Gulag!</h1>
<p>Mr Lucas welcomes you to Gulag, for the tiny amount of time you survive.</p>
EOF;

		//Use code from Gulag.ru
		$swiftMessage = Swift_Message::newInstance();
		$swiftMessage->setFrom(["gulag@bootcamp-coders.cnm.edu" => "Mr Lucas, Gulag Guard"]);
		$recipients = [$user->getUserEmail() => $user->getUserFirstName() . " " . $user->getUserLastName()];
		$swiftMessage->setTo($recipients);
		$swiftMessage->setSubject("Welcome to Gulag");
		$swiftMessage->setBody($message, "text/html");
		$swiftMessage->addPart(html_entity_decode($message), "text/plain");

		$smtp = Swift_SmtpTransport::newInstance("localhost", 25);
		$mailer = Swift_Mailer::newInstance($smtp);
		$numSent = $mailer->send($swiftMessage, $failedRecipients);
		if($numSent !== count($recipients)) {
			// the $failedRecipients parameter passed in the send() method now contains contains an array of the Emails that failed
			throw(new RuntimeException("unable to send email"));
		}
	} else {
		throw(new \Exception("Invalid HTTP method"));
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(\TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
echo json_encode($reply);