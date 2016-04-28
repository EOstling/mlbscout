<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Conceptual Model & ERD</title>
	</head>
	<body>
		<main>
			<h1>Conceptual Model</h1>
			<h3>Coach</h3>
			<ul>
				<li>hash</li>
				<li>salt</li>
				<li>email</li>
				<li>profileId</li>
				<li>first name</li>
				<li>last name</li>
				<li>phone number</li>
				<li>password</li>
				<li>posting</li>
			</ul>
			<h3>Scout</h3>
			<ul>
				<li>hash</li>
				<li>salt</li>
				<li>email</li>
				<li>foreignId</li>
				<li>first name</li>
				<li>last name</li>
				<li>password</li>
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
				<li>location</li>
				<li>time</li>
				<li>team name</li>
				<li>team type</li>
				<li>starters</li>
			</ul>
			<p>
			coaches post about players   m - to - n   Many coaches can post about many different players
			coaches view players         m - to - n   Many coaches can view many different players
			scouts view players          m - to - n   Many scouts can view many different players
			coaches favorite players     m - to - n   Many coaches can favorite many different players
			scout favorite players       m - to - n   Many scouts can favorite many different players
			coaches can have teams       m - to - n   Many coaches can have many different teams
			coaches view schedules       m - to - n   Many coaches can view many different schedules
			scouts view schedules        m - to - n   Many scouts can view many different schedules
			many teams have many players m - to - n   Many teams can have many different players</p>
		</main>
	</body>
</html>