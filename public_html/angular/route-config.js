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
			controller  : 'aboutUsController',
			templateUrl : 'angular/templates/aboutUs.php'
		})

		// route for the sign up page
		.when('/signUp', {
			controller  : 'signUpController',
			templateUrl : 'angular/templates/signUp.php'
		})

		// route for the player profile page
		.when('/playerProfile', {
			controller  : 'playerProfileController',
			templateUrl : 'angular/templates/playerProfile.php'
		})

		// route for the search page
		.when('/search', {
			controller  : 'searchController',
			templateUrl : 'angular/templates/search.php'
		})

		// route for the search results page
		.when('/searchResults', {
			controller  : 'searchResultsController',
			templateUrl : 'angular/templates/searchResults.php'
		})

		// route for the contact us page
		.when('/contactUs', {
			controller  : 'contactUsController',
			templateUrl : 'angular/templates/contactUs.php'
		})

		// otherwise redirect to home
		.otherwise({
			redirectTo: "/"
		});

	//use the HTML5 History API
	$locationProvider.html5Mode(true);
});