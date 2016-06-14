app.controller('searchController', ["$scope",function($scope) {

	$scope.getSearch = function() {
		SearchService.all()
			.then(function(result) {
				$scope.search = result.data.data;
			});
	};
	$scope.setEditedSearch = function(search) {
		$window.scrollTo(0, 0);
		$scope.editedSearch = angular.copy(search);
		$scope.isEditing = true;
	};
}]);