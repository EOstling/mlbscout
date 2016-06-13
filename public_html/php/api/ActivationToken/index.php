<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
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
		$userActivationToken = $_GET["id"];
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
		//Use code from Gulag.ru
		$swiftMessage = Swift_Message::newInstance();
		$swiftMessage->setFrom([$email => $name]);
		$recipients = [$email => "Welcome to Gulag Betches"];
		$swiftMessage->setTo($recipients);
		$swiftMessage->setSubject($subject);
		$swiftMessage->setBody($message, "text/html");
		$swiftMessage->addPart(html_entity_decode($message), "text/plain");




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