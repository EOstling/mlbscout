app.controller('LoginController', ["$scope", "$window","LoginService", function($scope, $window, LoginService) {
	$scope.alerts = [];

	$scope.login = function(formData, validated) {
		console.log("inside logincontroller login");
		console.log(formData);
		if(validated === true) {
			LoginService.login(formData)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						console.log("good status");
						$window.location.href = "search/"
					} else {
						console.log("bad status");
						console.log(result.data);
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};
}]);