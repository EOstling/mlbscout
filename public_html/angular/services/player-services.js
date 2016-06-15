app.constant("PLAYER_ENDPOINT", "php/api/Player/");
app.service("PlayerService", function($http, PLAYER_ENDPOINT) {
	function getUrl() {
		return(PLAYER_ENDPOINT);
	}

	function getUrlForId(playerId) {
		return(getUrl() + playerId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(playerId) {
		return($http.get(getUrlForId(playerId)));
	};

	this.fetchPlayerByPlayerFirstName = function(firstName) {
		return($http.get(getUrl() + "?playerFirstName=" + firstName));
	};

	this.fetchPlayerByPlayerLastName = function(lastName) {
		return($http.get(getUrl() + "?playerLastName=" + lastName));
	};

	this.create = function(player) {
		return($http.post(getUrl(), player));
	};

	this.update = function(playerId, player) {
		return($http.put(getUrlForId(playerId), player));
	};

	this.destroy = function(playerId) {
		return($http.delete(getUrlForId(playerId)));
	};
});