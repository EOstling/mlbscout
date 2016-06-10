app.constant("ACCESSLEVEL_ENDPOINT", "api/accessLevel/");
app.service("AccessLevelService", function($http, ACCESSLEVEL_ENDPOINT) {
	function getUrl() {
		return(ACCESSLEVEL_ENDPOINT);
	}

	function getUrlForId(accessLevelId) {
		return(getUrl() + accessLevelId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(accessLevelId) {
		return($http.get(getUrlForId(accessLevelId)));
	};

	this.create = function(accessLevel) {
		return($http.post(getUrl(), accessLevel));
	};

	this.update = function(accessLevelId, accessLevel) {
		return($http.put(getUrlForId(accessLevelId), accessLevel));
	};

	this.destroy = function(accessLevelId) {
		return($http.delete(getUrlForId(accessLevelId)));
	};
});