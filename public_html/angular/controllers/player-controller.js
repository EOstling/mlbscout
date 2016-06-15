app.controller('playerController', ["$routeParams", "$scope","FavoritePlayerService", "PlayerService", "$window", function($routeParams, $scope ,FavoritePlayerService, PlayerService, $window) {
	$scope.player = null;
	$scope.user =[];
	$scope.favoritePlayer = null;
	$scope.alerts = [];


	$scope.getPlayer = function() {
		PlayerService.fetch($routeParams.id)
			.then(function(result){
				if(result.data.status === 200) {
					$scope.player = result.data.data;
					console.log(result.data);
				}
			});
	};

//This is intended to be able to favorite a player; only when logged in.
	$scope.favoritePlayer = function() {
		var postPlayer = {favoritePlayerPlayerId: $scope.player.playerId};
		FavoritePlayerService.create(postPlayer)
					.then(function(result) {
						console.log(result);
						$scope.alerts[0] = {type: "success", msg: result.data.message};
			});
	};


	$scope.loadFavoritePlayers = function () {
		console.log("inside load favorite players");
		FavoritePlayerService.all()
			.then(function(result) {
				$scope.favoritePlayer = result.data.data;
				console.log(result);
				$scope.alerts[0] = {type: "success", msg: result.data.message};
			});
	};




	////This intends to be able to get a specific favorite player by its ID and populate it in our favorite player column.
	//$scope.user = function(){
	//	UserService.fetch()
	//		.then(function(result) {
	//			if(result.data.status === 200) {
	//				$scope.user = result.data.data;
	//				console.log("floofy");
	//				console.log(result.data);
	//
	//			}
	//		});
	//		FavoritePlayerService.fetch(favoritePlayerUserId)
	//			.then(function(result){
	//				$scope.favoritePlayer = result.data.data;
	//				console.log("fuzzy");
	//				console.log(result.data);
	//			//..
	//		});
	//};

	if($scope.player === null) {
		$scope.getPlayer();
	}

	if($scope.favoritePlayer === null) {
		$scope.favoritePlayer();
	}

}]);