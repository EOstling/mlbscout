<?php

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\MlbScout;

/**
 * api for the schedule class
 * @author Lucas Laudick <llaudick@cnm.edu>;Jared Padilla <jaredpadilla16@gmail.com>; Eliot Ostling <it.treugott@gmail.com>
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
	$favoritePlayerPlayerId = filter_input(INPUT_GET, "favoritePlayerPlayerId", FILTER_VALIDATE_INT);
	$favoritePlayerUserId = filter_input(INPUT_GET, "favoritePlayerUserId", FILTER_VALIDATE_INT);
	//make sure the id is valid for methods that require it
	if(($method === "DELETE") && ((empty($favoritePlayerPlayerId) === true || $favoritePlayerPlayerId <= 0) || (empty($favoritePlayerUserId) === true || $favoritePlayerUserId <= 0))) {
		throw(new \InvalidArgumentException("id cannot be empty or negative", 405));
	}
	// handle GET request - if id is present, that tweet is returned, otherwise all tweets are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		if(empty($_SESSION["user"]) === true) {
			throw(new RuntimeException("This might be appropriate but then again if you think about it, the reason you are getting this message is because you were inappropriate. Good for you", 401));
		}
		if(empty($favoritePlayerPlayerId) === false && empty($favoritePlayerUserId) === false) {
			$favoritePlayer = MlbScout\FavoritePlayer::getFavoritePlayerByFavoritePlayerPlayerIdAndFavoritePlayerUserId($pdo, $favoritePlayerPlayerId, $favoritePlayerUserId);
			if($favoritePlayer !== null) {
				$reply->data = $favoritePlayer;
			} else if(empty($favoritePlayerPlayerId) === false) {
				$favoriteImage = MlbScout\FavoritePlayer::getFavoritePlayerByFavoritePlayerPlayerId($pdo, $favoritePlayerPlayerId);
				$reply->data = $favoritePlayer;
			} else if(empty($favoritePlayerUserId) === false) {
				$favoriteImage = MlbScout\FavoritePlayer::getFavoritePlayerByFavoritePlayerUserId($pdo, $favoritePlayerUserId);
				$reply->data = $favoritePlayerUserId;
			}
			//	}
			//In the favorite Player Class this doesn't exist!
//else {
//			$favoritePlayer = MlbScout\FavoritePlayer::getAllFavoritePlayers($pdo);
//			if($favoritePlayer !== null){
//				$reply->data = $favoritePlayer;
//			}
		} else {
			// here you return all favorite players for the user in the $_SESSION
			$userFavoritePrisoners = MlbScout\FavoritePlayer::getFavoritePlayerByFavoritePlayerUserId($pdo, $_SESSION["user"]->getUserId());
			$finalPrisoners = [];
			foreach( $userFavoritePrisoners as $prisoner){
				$finalPrisoners[]= MlbScout\Player::getPlayerByPlayerId($pdo, $prisoner->getFavoritePlayerPlayerId());
			}

			$reply->data = $finalPrisoners;

		}

	} else if($method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure is available
		if(empty($requestObject->favoritePlayerPlayerId) === true) {
			throw(new \InvalidArgumentException ("No Favorite Player Exists. So there.", 405));
		}
		if(empty($_SESSION["user"]) === true) {
			throw(new RuntimeException("Cannot favorite gulag prisoner without logging in.", 401));
		}

		$favoritePlayer = new MlbScout\FavoritePlayer($requestObject->favoritePlayerPlayerId, $_SESSION["user"]->getUserId());
		$favoritePlayer->insert($pdo);

		// update reply

		$reply->message = "FavoritePlayer created OK";

	} else if($method === "DELETE") {
		verifyXsrf();
		// retrieve the Favorite Player to be deleted
		$favoritePlayer = MlbScout\FavoritePlayer::getFavoritePlayerByFavoritePlayerPlayerIdAndFavoritePlayerUserId($pdo, $favoritePlayerPlayerId, $favoritePlayerUserId);
		if($favoritePlayer === null) {
			throw(new \RuntimeException("DNE: Does not exist", 404));
		}
		// delete FavoritePlayer
		$favoritePlayer->delete($pdo);
		// update reply
		$reply->message = "Favorite Player deleted OK";
	} else {
		throw (new \InvalidArgumentException("Invalid HTTP method request"));
	}
} catch
(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
	//wat
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);
