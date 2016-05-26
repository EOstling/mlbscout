<?php

require_once dirname(__DIR__, 2) ."/classes/autoload.php";
require_once dirname(__DIR__, 2) ."/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\MlbScout;


/**
 * api for the player class
 * @author Eliot Ostling  <it.treugott@gmai.com>
 **/

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//stdClass() boilerplate?
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the encrypted mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/mlbscout.ini");

	// determine which http method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER['HTTP_X_HTTP_METHOD'] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);

	// Test ApiCall
	if(($method === "POST" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new \InvalidArgumentException("You don't have these capabilities but nice try", 405));
	}
	// handle GET request - if id is present, that ApiCall is returned
	if($method === "GET") {
		// set XSRF Cookie
		setXsrfCookie("/");

		// get a specific ApiCallId and update reply
		if(empty($id) === false) {
			$apiCall = MlbScout\ApiCall::getApiCallByApiCallId($pdo, $id);
			if($apiCall !== null) {
				$reply->data = $apiCall;
			}
		} else {
			$apiCall= MlbScout\ApiCall::getAllApiCall($pdo);
			if($apiCall !== null) {
				$reply->data = $apiCall;
			}
		}

	}
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

// encoded and return reply to front end caller
echo json_encode($reply);


