<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Conceptual Model & ERD</title>
	</head>
	<body>
		<main>
			<h1>Conceptual Model</h1>
			<h3>User</h3>
			<ul>
				<li>access levelId</li>
				<li>hash</li>
				<li>salt</li>
				<li>activation token</li>
				<li>email</li>
				<li>profileId</li>
				<li>first name</li>
				<li>last name</li>
				<li>phone number</li>
				<li>password</li>
				<li>API key</li>
			</ul>
			<h3>Access level</h3>
			<ul>
				<li>Access levelId</li>
				<li>Access Name</li>
			</ul>
			<h3>Player</h3>
			<ul>
				<li>throwing hand</li>
				<li>batting</li>
				<li>first name</li>
				<li>last name</li>
				<li>commitment</li>
				<li>location</li>
				<li>position</li>
				<li>height</li>
				<li>weight</li>
				<li>health status</li>
			</ul>
			<h3>Teams</h3>
			<ul>
				<li>team name</li>
				<li>team type</li>
				<li>starters</li>
			</ul>
			<h3>API call</h3>
			<ul>
				<li>Session Handler Interface</li>
				<li>dateTime</li>
				<li>Query String</li>
				<li>UserId</li>
				<li>URL</li>
				<li>HTTPVerb</li>
				<li>Browser</li>
				<li>IP</li>
				<li>Payload</li>
			</ul>
			<h3>Relations</h3>
			<ul>
				<li>User post about players    m - to - n   Many users can post about many different players</li>
				<li>User view players          m - to - n   Many users can view many different players</li>
				<li>Users favorite players     m - to - n   Many users can favorite many different players</li>
				<li>Users can have teams       m - to - n   Many users can have many different teams</li>
				<li>Users view schedules       m - to - n   Many users can view many different schedules</li>
				<li>Teams have players         m - to - n   Many teams can have many different players</li>
			</ul>
		</main>
	</body>
</html>