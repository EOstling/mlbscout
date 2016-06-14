app.constant("FAVORITEPLAYER_ENDPOINT", "php/api/favoritePlayer/");
app.service("FavoritePlayerService", function($http, FAVORITEPLAYER_ENDPOINT) {
	function getUrl() {
		return(FavoritePlayer_ENDPOINT);
	}

	function getUrlForId(favoritePlayerId) {
		return(getUrl() + favoritePlayerId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(favoritePlayerId) {
		return($http.get(getUrlForId(favoritePlayerId)));
	};

	this.create = function(favoritePlayer) {
		return($http.post(getUrl(), favoritePlayer));
	};

	this.update = function(favoritePlayerId, favoritePlayer) {
		return($http.put(getUrlForId(favoritePlayerId), favoritePlayer));
	};

	this.destroy = function(favoritePlayerId) {
		return($http.delete(getUrlForId(favoritePlayerId)));
	};
});