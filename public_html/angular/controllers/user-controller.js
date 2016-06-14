app.controller('userController', ["$scope","$window",function($scope) {

	$scope.getUser = function() {
		UserService.all()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.user = result.data.data;
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

}]);