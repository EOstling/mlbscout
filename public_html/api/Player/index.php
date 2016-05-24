<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\MlbScout;


/**
 * api for the Player class
 *
 * @author Lucas Laudick <llaudick@cnm.edu>
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/mlbscout-mysql/player.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cant be negative or empty", 405));
	}


	// handle GET request - if id is present, that tweet is returned, otherwise all tweets are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific tweet or all tweets and update reply
		if(empty($id) === false) {
			$tweet = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
			if($player !== null) {
				$reply->data = $tweet;
			}
		}  else {
			$players = MlbScout\Player::getAllPlayers($pdo);
			if($players !== null) {
				$reply->data = $players;
			}
		}
	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure tweet content is available
		if(empty($requestObject->playerBatting) === true) {
			throw(new \InvalidArgumentException ("No batting preference for player.", 405));
		}


		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the tweet to update
			$player = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
			if($player === null) {
				throw(new RuntimeException("Tweet does not exist", 404));
			}

			// put the new tweet content into the tweet and update
			$tweet->setPlayerBatting($requestObject->tweetContent);
			$tweet->update($pdo);

			// update reply
			$reply->message = "Player was updated OK";

		} else if($method === "POST") {

			//  make sure profileId is available
			if(empty($requestObject->userId) === true) {
				throw(new \InvalidArgumentException ("No User ID.", 405));
			}

			// create new tweet and insert into the database
			$player = new MlbScout\Player(null, $requestObject->userId, $requestObject->PlayerBatting, null);
			$player->insert($pdo);

			// update reply
			$reply->message = "Player was created OK";
		}

	} else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the Tweet to be deleted
		$player = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
		if($player === null) {
			throw(new RuntimeException("Player does not exist", 404));
		}

		// delete tweet
		$player->delete($pdo);

		// update reply
		$reply->message = "Player was deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
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