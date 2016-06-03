<?php

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\MlbScout;


/**
 * api for the schedule class
 *
 * @author Eliot Ostling <it.treugott@gmail.com>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/mlbscout.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$scheduleId = filter_input(INPUT_GET, "scheduleId", FILTER_VALIDATE_INT);
	$scheduleTeamId = filter_input(INPUT_GET, "scheduleTeamId", FILTER_VALIDATE_INT);
	$scheduleLocation = filter_input(INPUT_GET, "scheduleLocation", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$scheduleStartingPosition = filter_input(INPUT_GET, "scheduleStartingPosition", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$scheduleTime = filter_input(INPUT_GET, "scheduleTime ", FILTER_VALIDATE_INT);
	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new \InvalidArgumentException("id cannot be empty or negative", 405));
	}


	// handle GET request - if id is present, that tweet is returned, otherwise all tweets are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific schedule or all schedules and update reply
		if(empty($scheduleLocation) === false) {
			$schedule = MlbScout\Schedule::getScheduleByScheduleLocation($pdo, $scheduleLocation)->toArray();
			if($schedule !== null) {
				$reply->data = $schedule;
			}
		} else if(empty($scheduleStartingPosition) === false) {
			$schedule = MlbScout\Schedule::getScheduleByScheduleStartingPosition($pdo, $scheduleStartingPosition)->toArray();
			if($schedule !== null) {
				$reply->data = $schedule;
			}
		} else if(empty($id) === false) {
			$schedule = MlbScout\Schedule::getScheduleByScheduleId($pdo, $id);
			if($schedule !== null) {
				$reply->data = $schedule;
			}
		} else {
			$schedule = MlbScout\Schedule::getAllSchedules($pdo)->toArray();
			if($schedule !== null) {
				$reply->data = $schedule;
			}
		}

	} elseif($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure schedule location is available
		if(empty($requestObject->scheduleLocation) === true) {
			throw(new \InvalidArgumentException ("No location for the schedule.", 405));
		}


		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the schedule to update
			$schedule = MlbScout\Schedule::getScheduleByScheduleId($pdo, $id);
			if($schedule === null) {
				throw(new \RuntimeException("schedule does not exist", 404));
			}

			if(empty($requestObject->scheduleLocation) !== true) {
				$schedule->setScheduleLocation($requestObject->scheduleLocation);
			}
			if(empty($requestObject->scheduleStartingPosition) !== true) {
				$schedule->setScheduleStartingPosition($requestObject->scheduleStartingPosition);
			}

			$schedule->update($pdo);
			// update reply
			$reply->message = "Location updated OK";

		} else if($method === "POST") {

			//  make sure schedule team Id is available
			if(empty($requestObject->scheduleTeamId) === true) {
				throw(new \InvalidArgumentException ("No schedule team ID.", 405));
			}

			// create new schedule and insert into the database
			$schedule = new MlbScout\Schedule(null, $requestObject->scheduleTeamId, $requestObject->scheduleLocation, $requestObject->scheduleStartingPosition, $requestObject->scheduleTime);
			$schedule->insert($pdo);
			// update reply
			$reply->message = "schedule created OK";
		}
	} else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the Schedule to be deleted
		$schedule = MlbScout\Schedule::getScheduleByScheduleId($pdo, $id);
		if($schedule === null) {
			throw(new \RuntimeException("schedule does not exist", 404));
		}
		// delete schedule
		$schedule->delete($pdo);
		// update reply
		$reply->message = "Schedule deleted OK";
	} else {
		throw (new \InvalidArgumentException("Invalid HTTP method request"));
	}
	// update reply with exception information
} catch
(Exception $exception) {
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