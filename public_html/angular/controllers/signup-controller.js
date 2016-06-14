app.controller('signupController', [function($scope) {

	$scope.createSignup = function(signup, validated) {
		if(validated === true) {
			signupService.create(user)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						$scope.sampleForm = {firstName: null, Lastname: null, phoneNumber: null, email: null, password: null};
						$scope.signUp.$setPristine();
						$scope.signUp.$setUntouched();
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};
}]);