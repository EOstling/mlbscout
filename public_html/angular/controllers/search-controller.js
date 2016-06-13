app.controller('searchController', [function($scope) {

	$scope.getSearchs = function() {
		SearchService.all()
			.then(function(result) {
				$scope.searchs = result.data.data;
			});
	};
	$scope.setEditedSearch = function(search) {
		$window.scrollTo(0, 0);
		$scope.editedSearch = angular.copy(search);
		$scope.isEditing = true;
	};
}]);