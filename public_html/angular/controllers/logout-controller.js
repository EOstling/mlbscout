app.controller("logoutController", ["$scope", "logoutService", "$window", function($scope, logoutService, $window){

	$scope.logout = function() {
		logoutService.logout();
		$window.location.href="userLogin/"
	}
}]);