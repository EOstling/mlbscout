app.controller("LogoutController", ["$scope", "LogoutService", "$window", function($scope, LogoutService, $window){

	$scope.logout = function() {
		LogoutService.logout();
		$window.location.assign("public_html/template/userLogin.php")
	}
}]);