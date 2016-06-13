app.controller('userController', ["$scope", "$window",function($scope) {

	$scope.getUser = function() {
		UserService.all()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.misquotes = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};
}]);