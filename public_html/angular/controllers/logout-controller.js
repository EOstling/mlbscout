app.controller("LogoutController", ["$scope", "logoutService", "$window", function($scope, logoutService, $window){

	$scope.logout = function() {
		LogoutService.logout();
		$window.location.assign("public_html/template/userLogin.php")
	}
}]);