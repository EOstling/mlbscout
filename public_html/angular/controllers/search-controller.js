app.controller('searchController', ["$scope", "SearchService", "PlayerService", function($scope, SearchService, PlayerService) {
	$scope.players = [];

	$scope.getSearch = function(searchTerm, valid) {
		console.log("testing");
		SearchService.all()
			.then(function(result) {
				console.log(result);
				$scope.players = result.data.data;
			});
	};

	$scope.getPlayerByPlayerFirstName = function(playerFirstName) {
		console.log("in getPlayerByFirstName-Controller");
		console.log(playerFirstName);
		PlayerService.fetchPlayerByFirstName(playerFirstName)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.players = result.data.data;
					// console.log("good status");
					// console.log(result.data.message);
					// console.log(result.data.data);
					// console.log($scope.beerData);
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
		console.log("in getPlayerByLastName-Controller");
		console.log(playerLastName);
		PlayerService.fetchPlayerByLastName(playerLastName)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.players = result.data.data;
					// console.log("good status");
					// console.log(result.data.message);
					// console.log(result.data.data);
					// console.log($scope.beerData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
					// console.log("bad status");
					// console.log(result.data.status);
					// console.log(result.data.data);
					// console.log(result.data.message);
				}
			})
	};

	$scope.setEditedSearch = function(search) {
		$window.scrollTo(0, 0);
		$scope.editedSearch = angular.copy(search);
		$scope.isEditing = true;
	};
}]);