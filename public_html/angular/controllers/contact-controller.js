app.controller('contactController', ["MailerService", "$scope", function(MailerService, $scope) {

	$scope.sendEmail = function(formData, validated) {
		if(validated === true) {
			MailerService.sendEmail(formData)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						$scope.formData = {email: null, fullName: null  , message: null, subject:null};
						$scope.contactForm.$setPristine();
						$scope.contactForm.$setUntouched();
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};
}]);