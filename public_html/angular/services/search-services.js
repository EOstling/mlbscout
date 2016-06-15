app.constant("SEARCH_ENDPOINT", "php/api/search/");
app.service("SearchService", function($http, SEARCH_ENDPOINT) {
	function getUrl() {
		return (SEARCH_ENDPOINT);
	}

	function getUrlForId(searchId) {
		return (getUrl() + searchId);
	}

	this.all = function() {
		console.log("tsting 2 spel gud");
		return ($http.get(getUrl()));
	};

	this.fetch = function(searchId) {
		return ($http.get(getUrlForId(searchId)));
	};

	this.create = function(search) {
		return ($http.post(getUrl(), search));
	};

	this.update = function(searchId, search) {
		return ($http.put(getUrlForId(searchId), search));
	};

	this.destroy = function(searchId) {
		return ($http.delete(getUrlForId(searchId)));
	};
});