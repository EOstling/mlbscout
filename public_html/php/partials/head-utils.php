//Session start goes here-->
<!DOCTYPE html>
<html lang="en" ng-app="MlbScout">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- set base for relative links - to enable pretty URLs -->
		<base href="<?php echo dirname($_SERVER["PHP_SELF"]) . "/";?>">


		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" />
		<!-- Font Awesome -->
		<link type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo $PREFIX; ?> css/style.css" type="text/css" />

		<!--Angular JS Libraries-->
		<?php $ANGULAR_VERSION = "1.5.5";?>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular-messages.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular-route.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.3/ui-bootstrap-tpls.min.js"></script>

		<!-- Angular app files -->
		<script type="text/javascript" src="angular/app.js"></script>
		<script type="text/javascript" src="angular/route-config.js"></script>
		<script type="text/javascript" src="angular/bootstrap-breakpoint.js"></script>
		<script type="text/javascript" src="angular/controllers/user-login-controller.js"></script>
		<script type="text/javascript" src="angular/controllers/nav-controller.js"></script>
		<script type="text/javascript" src="angular/controllers/about-us-controller.js"></script>
		<script type="text/javascript" src="angular/controllers/sign-up-controller.js"></script>
		<script type="text/javascript" src="angular/controllers/player-profile-controller.js"></script>
		<script type="text/javascript" src="angular/controllers/search-controller.js"></script>
		<script type="text/javascript" src="angular/controllers/search-results-controller.js"></script>
		<script type="text/javascript" src="angular/controllers/contact-us-controller.js"></script>
	</head>