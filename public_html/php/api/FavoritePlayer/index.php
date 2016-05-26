<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/mlbscout-mysql/encrypted-config.php");

use Edu\Cnm\MlbScout\FavoritePlayer;

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
}