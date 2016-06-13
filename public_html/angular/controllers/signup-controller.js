app.controller('signupController', [function($scope) {

	$scope.createSignup = function(Signup, validated) {
		if(validated === true) {
			SignupService.create(signup)
				.then(function(result) {
					$scope.displayStatus(result.data);
				});
		}
	};
}]);