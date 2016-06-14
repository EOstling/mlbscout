app.constant("TEAM_ENDPOINT", "php/api/service/");
app.service("TeamService", function($http, TEAM_ENDPOINT) {
	function getUrl() {
		return(TEAM_ENDPOINT);
	}

	function getUrlForId(teamId) {
		return(getUrl() + teamId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(teamId) {
		return($http.get(getUrlForId(teamId)));
	};

	this.create = function(team) {
		return($http.post(getUrl(), team));
	};

	this.update = function(teamId, team) {
		return($http.put(getUrlForId(teamId), team));
	};

	this.destroy = function(teamId) {
		return($http.delete(getUrlForId(teamId)));
	};
});