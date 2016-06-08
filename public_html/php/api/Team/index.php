<?php
use Edu\Cnm\MlbScout;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
/**
 * api for the Player class
 *
 * @author Francisco Garcia based on code by Derek Mauldin
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
	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize method
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$teamName = filter_input(INPUT_GET, "teamName", FILTER_SANITIZE_STRING);
	$teamType = filter_input(INPUT_GET, "teamType", FILTER_SANITIZE_STRING);

	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle Get request - if id is present, that team is returned, otherwise all teams are returned
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		// get a specific team or all teams and update reply
		if(empty($id) === false) {
			$team = MlbScout\Team::getTeamByTeamId($pdo, $id);
			if($team !== null) {
				$reply->data = $team;
			}
		} else {
			$teams = MlbScout\Team::getAllTeams($pdo)->toArray();
			if($teams !== null) {
				$reply->data = $teams;
			}
		}
	} else if($method === "PUT" || $method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// make sure team name is available
		if(empty($requestObject->teamName) === true) {
			throw(new \InvalidArgumentException ("No Name for Team", 405));
		}

		// make sure team type is available
		if(empty($requestObject->teamType) === true) {
			throw(new \InvalidArgumentException ("No Type for Team", 405));
		}

		// perform the actual put or post
		if($method === "PUT") {
			// retrieve the team to update
			$team = MlbScout\Team::getTeamByTeamId($pdo, $id);
			if($team === null) {
				throw(new RuntimeException("Team does not exist, 404"));
			}

			// put the new team name into the team and update
			$team->setTeamName($requestObject->teamName);
			$team->update($pdo);

			// put the new team type into the team and update
			$team->setTeamType($requestObject->teamType);
			$team->update($pdo);

			// update reply
			$reply->message = "Team updated OK";
		} else if($method === "POST") {

						// create new team and insert into the database
			$team = new MlbScout\Team(null, $requestObject->teamType, $requestObject->teamName);
			$team->insert($pdo);

			// update reply
			$reply->message = "Team created OK";
		}

		} else if($method === "DELETE") {
			verifyXsrf();

			// retrieve the Team to be deleted
			$team = MlbScout\Team::getTeamByTeamId($pdo, $id);
			if($team === null) {
				throw (new RangeException("Team does not exist", 404));
			}

			// delete team
		$team->delete($pdo);

			// update reply
			$reply->message = "Team deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}

}		// update reply with exception information
catch(Exception $exception) {
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
