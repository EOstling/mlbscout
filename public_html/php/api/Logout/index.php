
<?php
require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\MlbScout;
/**
 * api for signout
 *
 * @author Eliot Robert Ostling <it.treugott@gmail.com>
 **/
//POST is another possibility but were using "GET"
if($method === "GET"){
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	$_SESSION = []''
}
?>