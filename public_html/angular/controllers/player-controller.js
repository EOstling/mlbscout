app.controller('playerController', ["$routeParams", "$scope", "FavoritePlayerService", "PlayerService", function($routeParams, $scope, FavoritePlayerService, PlayerService) {
	$scope.player = null;

	$scope.getPlayer = function() {
		PlayerService.fetch($routeParams.id)
			.then(function(result){
				if(result.data.status === 200) {
					$scope.player = result.data.data;
				}
			});
	};
//This is intended to be able to favorite a player; only when logged in.
	$scope.favoritePlayer = function() {
		var postPlayer = {favoritePlayerPlayerId: $scope.player.playerId};
		FavoritePlayerService.create(postPlayer)
			.then(function(result) {
				$scope.alerts[0] = {type: "success", msg: result.data.message};
			});
	};
	//This intends to be able to get a specific favorite player by its ID and populate it in our favorite player column.
	$scope.favoritePlayer = function(){
		FavoritePlayerService.fetch(favoritePlayerUserId)
			.then(function(result){
				//..
			});
	};

	if($scope.player === null) {
		$scope.getPlayer();
	}
}]);