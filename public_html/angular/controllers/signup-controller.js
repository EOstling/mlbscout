app.controller('signupController', "$scope",[function($scope) {

	$scope.createSignup = function(signup, validated) {
		if(validated === true) {
			signupService.create(formData)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						$scope.formData = {firstName: null, Lastname: null, phoneNumber: null, email: null, password: null};
						$scope.sampleForm.$setPristine();
						$scope.sampleForm.$setUntouched();
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};
}]);