<?php
/**
 * Get the relative path.
 * @see https://raw.githubusercontent.com/kingscreations/farm-to-you/master/php/lib/_header.php FarmToYou Header
 **/

// include the appropriate number of dirname() functions
// on line 8 to correctly resolve your directory's path
require_once(dirname(__DIR__, 2) . "/root-path.php");
$CURRENT_DEPTH = substr_count($CURRENT_DIR, "/");
$ROOT_DEPTH = substr_count($ROOT_PATH, "/");
$DEPTH_DIFFERENCE = $CURRENT_DEPTH - $ROOT_DEPTH;
$PREFIX = str_repeat("../", $DEPTH_DIFFERENCE);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link data-require="bootstrap-css@3.3.6" data-semver="3.3.6" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" />
		<link rel="stylesheet" href="<?php echo $PREFIX; ?> css/style.css" type="text/css" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.3/ui-bootstrap-tpls.min.js"></script>
		<script type="text/javascript" src="angular/app.js"></script>
		<script type="text/javascript" src="angular/bootstrap-breakpoint.js"></script>
		<script type="text/javascript" src="angular/nav-controller.js"></script>
	</head>