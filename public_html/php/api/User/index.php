<?php
use Edu\Cnm\MlbScout;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
/**
 * api for the User Class
 *
 * @author Jared Padilla
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
	// determine which HTTP was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	// sanitize input
	$id = filter_input(INPUT_GET, "Id", FILTER_VALIDATE_INT);
	$userId = filter_input(INPUT_GET, "userId", FILTER_VALIDATE_INT);
	$userAccessLevelId = filter_input(INPUT_GET, "userAccessLevelId", FILTER_VALIDATE_INT);
	$userActivationToken = filter_input(INPUT_GET, "userActivationToken", FILTER_SANITIZE_STRING);
	$userEmail = filter_input(INPUT_GET, "userEmail", FILTER_SANITIZE_STRING);
	$userFirstName = filter_input(INPUT_GET, "userFirstName", FILTER_SANITIZE_STRING);
	$userHash = filter_input(INPUT_GET, "userHash", FILTER_SANITIZE_STRING);
	$userLastName = filter_input(INPUT_GET, "userLastName", FILTER_SANITIZE_STRING);
	$userPhoneNumber = filter_input(INPUT_GET, "userPhoneNumber", FILTER_VALIDATE_INT);
	$userSalt = filter_input(INPUT_GET, "userSalt", FILTER )

}


