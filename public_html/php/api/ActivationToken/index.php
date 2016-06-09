<?php
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
		$userActivationToken = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($userActivationToken)) {
			throw(new \RangeException ("No ActivationToken Code"));
		}
		$user = User::getUserByUserEmail($pdo, $userEmail );//HERE TOO
		if(empty($user)) {
			throw(new \InvalidArgumentException ("no user for activation token")); //THIS IS DYLAN QUESTION>>>>>SI
		}
		$user->getUserByUserEmail(null);
		$user->update($pdo);
	} else {
		throw(new \Exception("Invalid HTTP method"));
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
	header("Content-type: application/json");
	echo json_encode($reply);
} catch(\TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
	$reply->trace = $typeError->getTraceAsString();
	header("Content-type: application/json");
	echo json_encode($reply);
}