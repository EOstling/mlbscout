app.controller("NavController", [ "$scope","$window","logoutService", function($scope,$window,logoutService) {
	$scope.breakpoint = null;
	$scope.navCollapsed = null;

	$scope.logout = function() {
		logoutService.logout();
		$window.location.href="userLogin/"
	};
	// collapse the navbar if the screen is changed to a extra small screen
	$scope.$watch("breakpoint", function() {
		$scope.navCollapsed = ($scope.breakpoint === "xs");
	});
}]);