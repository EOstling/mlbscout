<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/mlbscout-mysql/encrypted-config.php");

use Edu\Cnm\MlbScout;

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
	$pdo = connectToEncryptedMySQL("/etc/apache2/mlbscout-mysql/favoritePlayer.ini");

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	// make sure the id is valid for the methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request - if id is present, that favoritePlayer is returned, otherwise all favoritePlayers are returned
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		// get a specific favorite player or all favoritePLayers and update reply
		if(empty($id) === false) {
			$favoritePlayer = MlbScout\FavoritePlayer::getFavoritePlayerByFavoritePlayerPlayerId($pdo, $id);
			if($favoritePlayer !== null) {
				$reply->data = $favoritePlayer;
			}
		} else {
			$favoritePlayers = MlbScout\FavoritePlayer::getAllFavoritePlayers($pdo);
			if($favoritePlayers !== null) {
				$reply->data = $favoritePlayers;
			}
		}
	} else if($method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// make sure favoritePlayer content is available
		if(empty($requestObject->favoritePlayerContent) === true) {
			throw(new \InvalidArgumentException ("No content for FavoritePlayer", 405));
		}

	//perform the actual post
	if($method === "POST") {

		// make sure favoritePlayerId is available
		if(empty($requestObject->favoritePlayerId) == true) {
			throw(new \InvalidArgumentException ("No FavoritePlayer Id, 405"));
		}

		// create new favoritePlayer and insert into the database
		$favoritePlayer = new MlbScout\FavoritePlayer(null, $requestObject->favoritePlayerId, $requestObject->userId, $requestObject->playerId, null);
		$favoritePlayer->insert($pdo);
	}
	} else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the FavoritePlayer to be deleted
		$favoritePlayer = MlbScout\FavoritePlayer::getFavoritePlayerByFavoritePlayerPlayerId($pdo, $id);
		if($favoritePlayer === null) {
			throw(new RangeException("FavoritePlayer does not exist", 404));
		}

		// delete favoritePlayer
		$favoritePlayer->delete($pdo);

		// update reply
		$reply->message = "FavoritePlayer deleted OK";
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

header("Content-typer: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to fron end caller
echo json_encode($reply);