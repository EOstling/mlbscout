<!DOCTYPE html>
<html lang="em">
	<head>
		<meta charset="UTF-8">
		<title>Conceptual Model & ERD</title>
	</head>
	<body>
		<main>
			<h1>Conceptual Model</h1>
			<h3>User</h3>
			<ul>
				<li>userId </li>
				<li>userAccessLevelId</li>
				<li>userApiKey</li>
				<li>userActivationToken</li>
				<li>userEmail</li>
				<li>userFirstName</li>
				<li>userHash</li>
				<li>userLastName</li>
				<li>userPassword</li>
				<li>userPhoneNumber</li>
				<li>userSalt</li>
			</ul>
			<h3>Access level</h3>
			<ul>
				<li>accessLevelId</li>
				<li>accessName</li>
			</ul>
			<h3>Player</h3>
			<ul>
				<li>playerId</li>
				<li>playerUserId</li>
				<li>playerBatting</li>
				<li>playerCommitment</li>
				<li>playerFirstName</li>
				<li>playerHealthStatus</li>
				<li>playerHeight</li>
				<li>playerLastName</li>
				<li>playerLocation</li>
				<li>playerPosition</li>
				<li>playerThrowingHand</li>
				<li>playerUpdate</li>
				<li>playerWeight</li>
			</ul>
			<h3>Team</h3>
			<ul>
				<li>teamId</li>
				<li>teamName</li>
				<li>teamStarter</li>
				<li>teamType</li>
			</ul>
			<h3>ApiCall</h3>
			<ul>
				<li>apiCallId</li>
				<li>apiCallBrowser</li>
				<li>apiCallDateTime</li>
				<li>apiCallHttpVerb</li>
				<li>apiCallIP</li>
				<li>apiCallPayload</li>
				<li>apiCallQueryString</li>
				<li>apiCallUrl</li>
				<li>apiCallUserId</li>
			</ul>
			<h3>schedule</h3>
			<ul>
				<li>scheduleId</li>
				<li>scheduleTeamId</li>
				<li>scheduleDate</li>
				<li>scheduleLocation</li>
				<li>scheduleStartingPitcherId</li>
				<li>scheduleTime</li>
			</ul>
			<h3>favoritePlayer</h3>
			<ul>
				<li>favoriteUserId</li>
				<li>favoritePlayerId</li>
			</ul>
			<h3>Relations</h3>
			<ul>
				<li>User updates about players 1 - to - m   Users can post about many different players</li>
				<li>User view players          m - to - n   Many users can view many different players</li>
				<li>Users favorite players     m - to - n   Many users can favorite many different players</li>
				<li>Users can have teams       m - to - n   Many users can have many different teams</li>
				<li>Users view schedules       1 - to - m   Many users can view many different schedules</li>
				<li>Teams have players         m - to - n   Many teams can have many different players</li>
				<li>User has ApiCall	 			 1 - to - m   User can have many ApiCalls</li>
				<li>User favorites player 		 m - to - m   Many users can favorite many players</li>
				<li>User has access level 		 1 - to - m   Many users can have one access level</li>
			</ul>
		</main>
	</body>
</html>