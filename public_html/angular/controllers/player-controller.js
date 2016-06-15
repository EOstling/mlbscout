app.controller('playerController', ["$routeParams", "$scope", "UserService","FavoritePlayerService", "PlayerService", function($routeParams, $scope, UserService ,FavoritePlayerService, PlayerService) {
	$scope.player = null;
	$scope.user =[];

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
	$scope.user = function(){
		UserService.fetch()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.user = result.data.data;
					console.log("floofy");
					console.log(result.data);

				}
			});
			FavoritePlayerService.fetch(favoritePlayerUserId)
				.then(function(result){
					$scope.favoritePlayer = result.data.data;
					console.log("fuzzy");
					console.log(result.data);
				//..
			});
	};

	if($scope.player === null) {
		$scope.getPlayer();
	}

	if($scope.user === null) {
		$scope.user();
	}
}]);