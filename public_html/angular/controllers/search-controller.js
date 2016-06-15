app.controller('searchController', ["$scope", "$location", "SearchService", "PlayerService", function($scope, $location, SearchService, PlayerService) {
	$scope.players = [];
	$scope.formData = {};

	$scope.getSearch = function(formData, valid) {
		$scope.players = [];
		$scope.getPlayerByPlayerFirstName(formData.search);
		$scope.getPlayerByPlayerLastName(formData.search);
		$scope.removePlayerDuplicates();
		console.log($scope.players);
	};

	$scope.removePlayerDuplicates = function() {
		$scope.players = $scope.players.filter(function(item, pos) {
			return $scope.players.indexOf(item) == pos;
		});
	};

	$scope.getPlayerByPlayerFirstName = function(playerFirstName) {
		//console.log("in getPlayerByFirstName-Controller");
		//console.log(playerFirstName);
		PlayerService.fetchPlayerByPlayerFirstName(playerFirstName)
			.then(function(result) {
				//console.log(result);
				if(result.data.status === 200) {
					if (result.data.data !== null) {
						console.log(result.data.data);
						$scope.players = $scope.players.concat(result.data.data);
					}
					// console.log("good status");
					// console.log(result.data.message);
					// console.log(result.data.data);
					// console.log($scope.players);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
					// console.log("bad status");
					// console.log(result.data.status);
					// console.log(result.data.data);
					// console.log(result.data.message);
				}
			})
	};

	$scope.getPlayerByPlayerLastName = function(playerLastName) {
		//console.log("in getPlayerByLastName-Controller");
		//console.log(playerLastName);
		PlayerService.fetchPlayerByPlayerLastName(playerLastName)
			.then(function(result) {
				if(result.data.status === 200) {
					if (result.data.data !== null) {
						console.log(result.data.data);
						$scope.players = $scope.players.concat(result.data.data);
					}
					// console.log("good status");
					// console.log(result.data.message);
					// console.log(result.data.data);
					// console.log($scope.players);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
					// console.log("bad status");
					// console.log(result.data.status);
					// console.log(result.data.data);
					// console.log(result.data.message);
				}
			})
	};

	$scope.goToPlayer = function(playerId) {
		$location.path("player-profile/" + playerId);
	};

	$scope.setEditedSearch = function(search) {
		$window.scrollTo(0, 0);
		$scope.editedSearch = angular.copy(search);
		$scope.isEditing = true;
	};
}]);