app.controller('userController', ["$routeParams","$scope","$window", "UserService",function($routeParams, $scope, $window, UserService) {

	$scope.user = null;
	$scope.alerts = [];

	$scope.getUser = function() {
		UserService.fetch($routeParams.id)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.user = result.data.data;
					console.log(result.data);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};


	$scope.updateUser = function(user, validated) {
		if(validated === true) {
			UserService.update(signup.userId, user)
				.then(function(result) {
					$scope.displayStatus(result.data);
					$scope.cancelEditing();
					$scope.getUser();
				});
		}
	};

	$scope.setEditedUser = function(user) {
		$window.scrollTo(0, 0);
		$scope.editedUser = angular.copy(user);
		$scope.isEditing = true;
	};

	$scope.cancelEditing = function() {
		$scope.editedUser = null;
		$scope.isEditing = false;
	};

	if ($scope.user === null) {
		$scope.getUser();
	}

}]);