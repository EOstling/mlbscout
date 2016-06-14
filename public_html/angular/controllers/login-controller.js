app.controller('LoginController', ["$scope", "LoginService", function($scope, LoginService) {

	$scope.createLogin = function(formData, validated) {
		if(validated === true) {
			LoginService.login(formData)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						$window.location.href = "search/"
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};
}]);