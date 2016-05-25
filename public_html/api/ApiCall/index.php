<?php

require_once "autoloader";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/mlbscout-mysql/encrypted-config.php");

use Edu\Cnm\MlbScout;


/**
 * api for the player class
 * @author Eliot Ostling  <it.treugott@gmai.com>
 **/

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTVIVE) {
	session_start();
}
//stdClass() boilerplate?
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the encrypted mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/mlbscout-mysql/ApiClass.ini");

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
		// set XSRF cookie
		setXsrfCookie("/");


		// get a specific ApiCallId and update reply
		if(empty($id) === false) {
			$ApiCall = MlbScout\ApiCall::getApiCallByApiCallId($pdo, $id);
			if($ApiCall !== null) {
				$reply->data = $ApiCall;
			}
		}
	}
}
