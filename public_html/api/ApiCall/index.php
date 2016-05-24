<?php

require_once "autoloader";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/mlbscout-mysql/encrypted-config.php");

use Edu\Cnm\MlbScout;


/**
 * api for the player class
 *
 * @author Eliot Ostling  <it.treugott@gmai.com>
 **/

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTVIVE) {
	session_start();
}

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/mlbscout-mysql/ApiClass.ini");

	// determine which http method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER['HTTP_X_HTTP_METHOD'] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);

	// Test ApiCall
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new \InvalidArgumentException("id cant be negative or empty", 405));
	}
	// handle GET request - if id is present, that player is returned, otherwise all players are returned
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie("/");


		// get a specific player or all players and update reply
		if(empty($id) === false) {
			$ApiCall = MlbScout\ApiCall::getApiCallByApiCallId($pdo, $id);
			if($ApiCall !== null) {
				$reply->data = $ApiCall;
			}
		} else {
			$ApiCall =MlbScout\ApiCall::getApiCallByApiCallUserId($pdo, $id)
			if($ApiCall !== null) {
				$reply->data = $ApiCall;
			}
		}

	} else if($method === "PUT" || $method === "POST") {

	verifyXsrf();
	$requestContent = file_get_contents("php://input");
	$requestObject = json_decode($requestContent);

	// make sure player Batting is available
	if(empty($requestObject->playerBatting) === true) {
		throw(new \InvalidArgumentException ("no batting preference for the player", 405));
	}
}