app.service("LogoutService", function($http) {
	this.LOGOUT_ENDPOINT = "public_html/php/Logout/index.php";

	this.logout = function() {
		return ($http.get(this.LOGOUT_ENDPOINT));
	}
});