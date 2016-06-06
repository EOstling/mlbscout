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
	$favoritePlayerId = filter_input(INPUT_GET, "favoritePlayerId", FILTER_VALIDATE_INT);
	$userId = filter_input(INPUT_GET, "userId", FILTER_VALIDATE_INT);
//	$favoritePlayerUserId = filter_input(INPUT_GET, "favoritePlayerUserId", FILTER_VALIDATE_INT);
//	$favoritePlayerPlayerId = filter_input(INPUT_GET, "favoritePlayerPlayerId", FILTER_VALIDATE_INT);

	// make sure the id is valid for the methods that require it
	if(($method === "DELETE") && (empty($userId) === true || $userId < 0)) {
		throw(new \InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request - if id is present, that favoritePlayer is returned, otherwise all favoritePlayers are returned
	if($method === "GET") {
		// set xsrf cookie
		setXsrfCookie();

		// get a specific favorite player and update reply
		if(empty($userId) === false) {
			$favoritePlayer = MlbScout\FavoritePlayer::getFavoritePlayerByFavoritePlayerUserId($pdo, $userId);
			if($favoritePlayer !== null) {
				$reply->data = $favoritePlayer;
			}
		}
	} else if($method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure favoritePlayer Player Id is available
		if(empty($requestObject->favoritePlayerId) === true) {
			throw(new \InvalidArgumentException ("No FavoritePlayerPlayerId", 405));
		}

		// make sure User Id is available
		if(empty($requestObject->userId) === true) {
			throw(new \InvalidArgumentException ("No User", 402));
		}

		// perform the actual post
		if($method === "POST") {
			// retrieve the favoritePlayer to update
			$favoritePlayer = MlbScout\FavoritePlayer::getFavoritePlayerByFavoritePlayerUserId($pdo, $favoritePlayerId);
			if($favoritePlayer === null) {
				throw(new RuntimeException("FavoritePlayer does not exist, 404"));
			}


			//perform the actual post
			// add if statement user session exists
//		if(session_status() !== PHP_SESSION_ACTIVE) {
//			session_start();
//		}


//			if($method === "POST") {

			// make sure favoritePlayerPlayerId is available
//				if(empty($requestObject->favoritePlayerPlayerId) == true) {
//					throw(new \InvalidArgumentException ("No FavoritePlayer Id, 405"));
//				}

			// make sure favoritePlayerUserId is available
//				if(empty($requestObject->favoritePlayerUserId) == true) {
//					throw(new \InvalidArgumentException ("No FavoritePlayerUserId, 405"));
//				}


			// create new favoritePlayer and insert into the database
			$favoritePlayer = new MlbScout\FavoritePlayer($requestObject->favoritePlayerId, $requestObject->userId);
			$favoritePlayer->insert($pdo);

			// update reply
			$reply->message = "FavoritePlayer created OK";
		}
	} else if($method === "DELETE") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);


		// make sure favoritePlayer User Id is available
		//if(empty($requestObject->userId) === true) {
		// throw(new \InvalidArgumentException ("FavoritePlayer", 405));
		//}


		// make sure favoritePlayer Player Id is available
		if(empty($requestObject->favoritePlayerId) === true) {
			//throw(new \InvalidArgumentException ("No content for FavoritePlayer", 405));
		}

		// retrieve the FavoritePlayer to be deleted
		$favoritePlayer = MlbScout\FavoritePlayer::getFavoritePlayerByFavoritePlayerPlayerIdAndFavoritePlayerUserId($pdo, ($requestObject->favoritePlayerId), ($requestObject->userId));
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

}   // update reply with exception information
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

// encode and return reply to from end caller
echo json_encode($reply);