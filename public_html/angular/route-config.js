// configure our routes
app.config(function($routeProvider, $locationProvider) {
	$routeProvider

	// route for the home page
		.when('/', {
			controller  : 'user-login',
			templateUrl : 'angular/template/userLogin.php'
		})

		// route for the about page
		.when('/about', {
			controller  : 'aboutController',
			templateUrl : 'angular/templates/about.php'
		})

		// route for the sign up page
		.when('/sign-up', {
			controller  : 'signupController',
			templateUrl : 'angular/templates/sign-up.php'
		})

		// otherwise redirect to home
		.otherwise({
			redirectTo: "/"
		});

	//use the HTML5 History API
	$locationProvider.html5Mode(true);
});