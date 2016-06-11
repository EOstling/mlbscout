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
		<link rel="stylesheet" href="css/style.css" type="text/css" />

		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>

		<!-- jQuery Form, Additional Methods, Validate -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.min.js"></script>

		<!-- Google reCAPTCHA -->
		<!--<script src='https://www.google.com/recaptcha/api.js'></script>

		<!-- Your JavaScript Form Validator -->
		<!-- <script src="js/form-validate.js"></script>

		<!--Angular JS Libraries-->
		<?php $ANGULAR_VERSION = "1.5.6";?>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular-messages.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular-route.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.3/ui-bootstrap-tpls.min.js"></script>

		<!-- Angular app files -->
		<script type="text/javascript" src="angular/app.js"></script>
		<script type="text/javascript" src="angular/route-config.js"></script>

		<!-- services -->
		<script type="text/javascript" src="angular/services/accesslevel-services.js"></script>
		<script type="text/javascript" src="angular/services/apicall-services.js"></script>
		<script type="text/javascript" src="angular/services/favoriteplayer-services.js"></script>
		<script type="text/javascript" src="angular/services/mailer-services.js"></script>
		<script type="text/javascript" src="angular/services/player-services.js"></script>
		<script type="text/javascript" src="angular/services/schedule-services.js"></script>
		<script type="text/javascript" src="angular/services/team-services.js"></script>
		<script type="text/javascript" src="angular/services/user-services.js"></script>


		<!-- controllers -->
		<script type="text/javascript" src="angular/directives/bootstrap-breakpoint.js"></script>
		<script type="text/javascript" src="angular/controllers/about-controller.js"></script>
		<script type="text/javascript" src="angular/controllers/contact-controller.js"></script>
		<script type="text/javascript" src="angular/controllers/nav-controller.js"></script>
		<script type="text/javascript" src="angular/controllers/player-controller.js"></script>
		<script type="text/javascript" src="angular/controllers/results-controller.js"></script>
		<script type="text/javascript" src="angular/controllers/search-controller.js"></script>
		<script type="text/javascript" src="angular/controllers/signup-controller.js"></script>
		<script type="text/javascript" src="angular/controllers/user-controller.js"></script>
	</head>