app.controller('playerController', ["$routeParams", "$scope", "FavoritePlayerService", "PlayerService", "ScheduleService", function($routeParams, $scope, FavoritePlayerService, PlayerService, ScheduleService) {
	$scope.player = null;
	$scope.alerts = [];
	$scope.getPlayer = function() {
		PlayerService.fetch($routeParams.id)
			.then(function(result){
				if(result.data.status === 200) {
					$scope.player = result.data.data;
				}
			});
	};

	$scope.favoritePlayer = function() {
		var postPlayer = {favoritePlayerPlayerId: $scope.player.playerId};
		FavoritePlayerService.create(postPlayer)
			.then(function(result) {
				$scope.alerts[0] = {type: "success", msg: result.data.message};
			});
	};
	$scope.schedule = null;

	$scope.getSchedule = function() {
		ScheduleService.fetch($routeParams.id)
			.then(function(result){
				if(result.data.status === 200) {
					$scope.schedule = result.data.data;
				}
			});
	};

	if($scope.schedule === null) {
		$scope.getSchedule();
	}

	if($scope.player === null) {
		$scope.getPlayer();
	}
}]);