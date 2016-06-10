app.constant("USER_ENDPOINT", "api/user/");
app.service("UserService", function($http, USER_ENDPOINT) {
	function getUrl() {
		return(USER_ENDPOINT);
	}

	function getUrlForId(userId) {
		return(getUrl() + userId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(userId) {
		return($http.get(getUrlForId(userId)));
	};

	this.create = function(user) {
		return($http.post(getUrl(), user));
	};

	this.update = function(userId, user) {
		return($http.put(getUrlForId(userId), user));
	};

	this.destroy = function(userId) {
		return($http.delete(getUrlForId(userId)));
	};
});