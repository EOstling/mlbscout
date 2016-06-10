app.constant("SCHEDULE_ENDPOINT", "api/schedule/");
app.service("ScheduleService", function($http, SCHEDULE_ENDPOINT) {
	function getUrl() {
		return(SCHEDULE_ENDPOINT);
	}

	function getUrlForId(scheduleId) {
		return(getUrl() + scheduleId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(scheduleId) {
		return($http.get(getUrlForId(scheduleId)));
	};

	this.create = function(schedule) {
		return($http.post(getUrl(), schedule));
	};

	this.update = function(scheduleId, schedule) {
		return($http.put(getUrlForId(scheduleId), schedule));
	};

	this.destroy = function(scheduleId) {
		return($http.delete(getUrlForId(scheduleId)));
	};
});