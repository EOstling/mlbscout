<?php
use Edu\Cnm\MlbScout;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
/**
 * api for the FavoritePlayer class
 *
 * @author Francisco Garcia <fgarcia132@cnm.edu>
 */

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

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$favoritePlayerUserId = filter_input(INPUT_GET, "favoritePlayerUserId", FILTER_VALIDATE_INT);
	$favoritePlayerPlayerId = filter_input(INPUT_GET, "favoritePlayerPlayerId", FILTER_VALIDATE_INT);

	// make sure the id is valid for the methods that require it
	if(($method === "DELETE") && (empty($id) === true || $id < 0)) {
		throw(new \InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request - if id is present, that favoritePlayer is returned, otherwise all favoritePlayers are returned
	if($method === "GET") {
		// set xsrf cookie
		setXsrfCookie();

		// get a specific favorite player and update reply
		if(empty($id) === false) {
			$favoritePlayer = MlbScout\FavoritePlayer::getFavoritePlayerByFavoritePlayerPlayerId($pdo, $id);
			if($favoritePlayer !== null) {
				$reply->data = $favoritePlayer;
			}
		}
	} else if($method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// make sure favoritePlayer Player Id is available
		if(empty($requestObject->favoritePlayerPlayerId) === true) {
			throw(new \InvalidArgumentException ("No content for FavoritePlayer", 405));
		}

		// make sure favoritePlayer User Id is available
		if(empty($requestObject->favoritePlayerUserId) === true) {
			throw(new \InvalidArgumentException ("No User Id for FavoritePlayer"));
		}


		//perform the actual post
		// add if statement user session exists
		if(session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}



			if($method === "POST") {

				// make sure favoritePlayerPlayerId is available
				if(empty($requestObject->favoritePlayerPlayerId) == true) {
					throw(new \InvalidArgumentException ("No FavoritePlayer Id, 405"));
				}

				// make sure favoritePlayerUserId is available
				if(empty($requestObject->favoritePlayerUserId) == true) {
					throw(new \InvalidArgumentException ("No FavoritePlayerUserId, 405"));
				}
			}

			// create new favoritePlayer and insert into the database
			$favoritePlayer = new MlbScout\FavoritePlayer(null, $requestObject->favoritePlayerId, $requestObject->userId, $requestObject->playerId, null);
			$favoritePlayer->insert($pdo);

			// update reply
			$reply->message = "FavoritePlayer created OK";
		}
	 else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the FavoritePlayer to be deleted
		$favoritePlayer = MlbScout\FavoritePlayer::getFavoritePlayerByFavoritePlayerPlayerIdAndFavoritePlayerUserId($pdo, $id, $_SESSION["user"]->getUserId());
		if($favoritePlayer === null) {
			throw(new \RangeException("FavoritePlayer does not exist", 404));
		}

		// delete favoritePlayer
		$favoritePlayer->delete($pdo);

		// update reply
		$reply->message = "FavoritePlayer deleted OK";
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

// encode and return reply to from end caller
echo json_encode($reply);