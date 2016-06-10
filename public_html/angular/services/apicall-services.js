app.constant("APICALL_ENDPOINT", "api/apiCall/");
app.service("ApiCallService", function($http, APICALL_ENDPOINT) {
	function getUrl() {
		return(APICALL_ENDPOINT);
	}

	function getUrlForId(apiCallId) {
		return(getUrl() + apiCallId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(apiCallId) {
		return($http.get(getUrlForId(apiCallId)));
	};

	this.create = function(apiCall) {
		return($http.post(getUrl(), apiCall));
	};

	this.update = function(apiCallId, apiCall) {
		return($http.put(getUrlForId(apiCallId), apiCall));
	};

	this.destroy = function(apiCallId) {
		return($http.delete(getUrlForId(apiCallId)));
	};
});