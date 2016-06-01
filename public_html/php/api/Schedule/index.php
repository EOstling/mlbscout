<?php

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/mlbscout-mysql/encrypted-config.php");

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
	$pdo = connectToEncryptedMySQL("/etc/apache2/mlbscout-mysql/schedule.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$scheduleId = filter_input(INPUT_GET, "scheduleId", FILTER_VALIDATE_INT);
	$scheduleTeamId = filter_input(INPUT_GET, "scheduleTeamId", FILTER_VALIDATE_INT);
	$scheduleLocation = filter_input(INPUT_GET, "scheduleLocation", FILTER_VALIDATE_INT);
	$scheduleStartingPosition = filter_input(INPUT_GET, "scheduleStartingPosition", FILTER_VALIDATE_INT);
	$scheduleTime = filter_input(INPUT_GET, "scheduleTime ", FILTER_VALIDATE_INT);
	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new \InvalidArgumentException("id cannot be empty or negative", 405));
	}


	// handle GET request - if id is present, that tweet is returned, otherwise all tweets are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific schedule or all scheduless and update reply
		if(empty($id) === false) {
			$player = MlbScout\Schedule::getScheduleByScheduleLocation($pdo, $id);
			if($schedule !== null) {
				$reply->data = $schedule;
			}
		}
		else if(empty($scheduleStartingPosition) === false) {
			$schedule = MlbScout\Schedule::getScheduleByScheduleStartingPosition($pdo, $scheduleStartingPosition);
			if($schedule !== null) {
				$reply->data = $schedule;
			}
		}
		else if(empty($scheduleByScheduleId)===false){
			$schedule = MlbScout\Schedule::getScheduleByScheduleId($pdo, $scheduleId);
			if($schedule !== null ){
				$reply->data = $schedule;
			}
		}
		else if(empty($scheduleAll)==false){
			$schedule = MlbScout\Schedule::getAllSchedules($pdo);
			if($schedule !== null){
				$reply->data = $schedule;
			}
		}

		//
	} else if($method === "PUT" || $method === "POST") {

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

			// put the new schedule location into the schedule and update
			$schedule->setScheduleLocation($requestObject->scheduleLocation);
			$schedule->update($pdo);

			// update reply
			$reply->message = "schedule updated OK";

			if(empty($requestObject->scheduleLocation) !== true) {
				// retrieve the Location to update
				$schedule = MlbScout\Schedule::getScheduleByScheduleLocation($pdo ,$scheduleLocation);
				if($schedule === null) {
					throw(new RuntimeException("Location Doesn't exits", 404));
				}
				// put the new Location into the Schedule and update
				$player->setScheduleLocation($requestObject->scheduleLocation);
				$player->update($pdo);
				// update reply
				$reply->message = "Location updated OK";


				//Starting Position
				if(empty($requestObject->scheduleStartingPosition) !== true) {
					// retrieve the player to update
					$player = MlbScout\Schedule::getScheduleByScheduleStartingPosition($pdo, $id);
					if($player === null) {
						throw(new RuntimeException("player does not exist", 404));
					}
					// put the new Starting position into the Schedule and update
					$player->setScheduleStartingPosition($requestObject->scheduleStartingPosition);
					$player->update($pdo);
					// update reply
					$reply->message = "Position updated OK";










		} else if($method === "POST") {

			//  make sure schedule team Id is available
			if(empty($requestObject->scheduleTeamId) === true) {
				throw(new \InvalidArgumentException ("No schedule team ID.", 405));
			}

			// create new schedule and insert into the database
			$schedule = new MlbScout\Schedule(null, $requestObject->scheduleTeamId, $requestObject->scheduleLocation, null);
			$schedule->insert($pdo);

			// update reply
			$reply->message = "schedule created OK";
		}
	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure schedule starting position is available
		if(empty($requestObject->scheduleStartingPosition) === true) {
			throw(new \InvalidArgumentException ("No Starting position for the schedule.", 405));
		}


		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the schedule to update
			$schedule = MlbScout\Schedule::getScheduleByScheduleId($pdo, $id);
			if($schedule === null) {
				throw(new \RuntimeException("schedule does not exist", 404));
			}

			// put the new schedule location into the schedule and update
			$schedule->setScheduleStartingPosition($requestObject->scheduleStartingPosition);
			$schedule->update($pdo);

			// update reply
			$reply->message = "schedule updated OK";

		} else if($method === "POST") {

			//  make sure schedule team Id is available
			if(empty($requestObject->scheduleTeamId) === true) {
				throw(new \InvalidArgumentException ("No schedule team ID.", 405));
			}

			// create new schedule and insert into the database
			$schedule = new MlbScout\Schedule(null, $requestObject->scheduleTeamId, $requestObject->scheduleStartingPosition, null);
			$schedule->insert($pdo);

			// update reply
			$reply->message = "schedule created OK";
		}
	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure schedule location is available
		if(empty($requestObject->scheduleTime) === true) {
			throw(new \InvalidArgumentException ("No time for the schedule.", 405));
		}


		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the schedule to update
			$schedule = MlbScout\Schedule::getScheduleByScheduleId($pdo, $id);
			if($schedule === null) {
				throw(new \RuntimeException("schedule does not exist", 404));
			}

			// put the new schedule location into the schedule and update
			$schedule->setScheduleTime($requestObject->scheduleTime);
			$schedule->update($pdo);

			// update reply
			$reply->message = "schedule updated OK";

		} else if($method === "POST") {

			//  make sure schedule team Id is available
			if(empty($requestObject->scheduleTeamId) === true) {
				throw(new \InvalidArgumentException ("No schedule team ID.", 405));
			}

			// create new schedule and insert into the database
			$schedule = new MlbScout\Schedule(null, $requestObject->scheduleTeamId, $requestObject->scheduleTime, null);
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