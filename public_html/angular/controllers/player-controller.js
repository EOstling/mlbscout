app.controller('playerController', ["$routeParams", "$scope", "PlayerService", function($routeParams, $scope, PlayerService) {
	$scope.player = null;

	$scope.getPlayer = function() {
		PlayerService.fetch($routeParams.id)
			.then(function(result){
				if(result.data.status === 200) {
					$scope.player = result.data.data;
				}
			});
	};

	if($scope.player === null) {
		$scope.getPlayer();
	}
}]);