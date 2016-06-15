//app.controller('scheduleController', ["$routeParams", "$scope", "ScheduleService", function($routeParams, $scope, ScheduleService) {
//	$scope.schedule = null;
//
//	$scope.getSchedule = function() {
//		ScheduleService.fetch($routeParams.id)
//			.then(function(result){
//				if(result.data.status === 200) {
//					$scope.schedule = result.data.data;
//				}
//			});
//	};
//
//	if($scope.schedule === null) {
//		$scope.getSchedule();
//	}
//}]);