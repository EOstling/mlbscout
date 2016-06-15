app.controller('playerController', ["$routeParams", "$scope", "FavoritePlayerService", "PlayerService", function($routeParams, $scope, FavoritePlayerService, PlayerService) {
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

	if($scope.player === null) {
		$scope.getPlayer();
	}
}]);