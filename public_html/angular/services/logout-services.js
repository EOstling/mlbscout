app.service("logoutService", function($http) {
	this.LOGOUT_ENDPOINT = "php/api/Logout/";

	this.logout = function() {
		return ($http.get(this.LOGOUT_ENDPOINT));
	}
});