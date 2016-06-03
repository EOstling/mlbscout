<?php

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\MlbScout;

/**
 * api for the User class
 *
 * @author Jared Padilla <jaredpadilla16@gmail.com>
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

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new \InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request - if id is present, that access level is returned, otherwise all access levels are returned
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		// get a specific access level or all access levels and update reply
		if(empty($id) === false) {
			$accessLevel = MlbScout\AccessLevel::getAccessLevelByAccessLevelId($pdo, $id);
			if($accessLevel !== null) {
				$reply->data = $accessLevel;
			}
		} else {
			$accessLevels = MlbScout\AccessLevel::getAllAccessLevels($pdo);
			if($accessLevels !== null) {
				$reply->data = $accessLevels;
			}
		}
	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// make sure access level name is available
		if(empty($requestObject->accessLevelName) === true) {
			throw(new \InvalidArgumentException("No Access Level Name.", 405));
		}
		// perform the actual put or post
		if($method === "PUT") {
			// retrieve the access level to update
			$accessLevel = MlbScout\AccessLevel::getAccessLevelByAccessLevelId($pdo, $id);
			if($accessLevel === null) {
				throw(new \RuntimeException("Access Level does not exist", 404));
			}
			//put the new access level name into the access level and update
			$accessLevel->setAccessLevelName($requestObject->accessLevelName);
			$accessLevel->update($pdo);

			// update reply
			$reply->message = "Access Level Updated!";
		} else if($method === "POST") {
			// make sure access level id is available
			if(empty($requestObject->accessLevelId) === true) {
				throw(new \InvalidArgumentException("No Access Level id.",405));
			}
			// create new access level and insert into the database
			$accessLevel = new MlbScout\AccessLevel(null, $requestObject->accessLevelName, null);
			$accessLevel->insert($pdo);
			// update reply
			$reply->message ="Access Level Created!";

		}

	} else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the Access Level to be deleted
		$accessLevel = MlbScout\AccessLevel::getAccessLevelByAccessLevelId($pdo, $id);
		if($accessLevel === null) {
			throw(new \RuntimeException("Access Level does not exist!!!!",404));
		}

		// delete access level
		$accessLevel->delete($pdo);

		// update reply
		$reply->message = "ACCESS LEVEL DELETED, NO MORE CONTENT FOR YOU!";
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