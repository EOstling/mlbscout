DROP TABLE IF EXISTS ApiCall;
DROP TABLE IF EXISTS favoritePlayer;
DROP TABLE IF EXISTS schedule;
DROP TABLE IF EXISTS player;
DROP TABLE IF EXISTS team;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS accessLevel;

CREATE TABLE accessLevel(
	accessLevelId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	accessLevelName VARCHAR(24),
	PRIMARY KEY(accessLevelId)
);

CREATE TABLE user(
	userId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	userAccessLevelId INT UNSIGNED NOT NULL,
	userActivationToken CHAR(32),
	userEmail VARCHAR(64) NOT NULL,
	userFirstName VARCHAR(32) NOT NULL,
	userHash CHAR(128) NOT NULL,
	userLastName VARCHAR(32) NOT NULL,
	userPassword VARCHAR(64) NOT NULL,
	userPhoneNumber VARCHAR(20) NOT NULL,
	userSalt CHAR(64) NOT NULL,
	userUpdate VARCHAR(64),
	INDEX(userId),
	INDEX (userAccessLevelId),
	UNIQUE(userEmail),
	FOREIGN KEY (userAccessLevelId) REFERENCES accessLevel(accessLevelId),
	PRIMARY KEY (userId)
);

CREATE TABLE team(
	teamId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	teamType VARCHAR(32) NOT NULL,
	teamName VARCHAR(64) NOT NULL,
	INDEX(teamId),
	PRIMARY KEY (teamId)
);

CREATE TABLE player (
	playerId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	playerTeamId INT UNSIGNED NOT NULL,
	playerUserId INT UNSIGNED NOT NULL,
	playerBatting CHAR(1) NOT NULL,
	playerCommitment VARCHAR(128),
	playerFirstName VARCHAR(32) NOT NULL,
	playerHealthStatus VARCHAR(64),
	playerHeight TINYINT UNSIGNED NOT NULL,
	playerHomeTown VARCHAR(64) NOT NULL,
	playerLastName VARCHAR(32) NOT NULL,
	playerPosition VARCHAR(8) NOT NULL,
	playerThrowingHand CHAR(1) NOT NULL,
	playerWeight TINYINT UNSIGNED NOT NULL,
	INDEX(playerTeamId),
	INDEX(playerUserId),
	INDEX(playerId),
	FOREIGN KEY (playerTeamId)REFERENCES team(teamId),
	FOREIGN KEY (playerUserId)REFERENCES user(userId),
	PRIMARY KEY(playerId)
);

CREATE TABLE schedule (
	scheduleId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	scheduleTeamId INT UNSIGNED NOT NULL,
	scheduleLocation VARCHAR(64) NOT NULL,
	scheduleStartingPosition VARCHAR(32) NOT NULL,
	scheduleTime DATETIME NOT NULL,
	INDEX(scheduleId),
	INDEX(scheduleTeamId),
	FOREIGN KEY(scheduleTeamId)REFERENCES team(teamId),
	PRIMARY KEY(scheduleId,scheduleTeamId)
);

CREATE TABLE favoritePlayer(
	favoritePlayerId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	favoriteUserId INT UNSIGNED NOT NULL,
	INDEX(favoritePlayerId),
	INDEX(favoriteUserId),
	FOREIGN KEY (favoriteUserId)REFERENCES user(userId),
	FOREIGN KEY (favoritePlayerId) REFERENCES player(playerId),
	PRIMARY KEY (favoriteUserId,favoritePlayerId)
);

CREATE TABLE ApiCall(
	ApiCallId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	ApiCallUserId INT UNSIGNED NOT NULL,
	ApiCallBrowser VARCHAR(128) NOT NULL,
	ApiCallDateTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	ApiCallHttpVerb VARCHAR(6) NOT NULL,
	ApiCallIP VARBINARY(16) NOT NULL,
	ApiCallQueryString VARCHAR(128),
	ApiCallPayload VARCHAR(2000),
	ApiCallURL VARCHAR(128) NOT NULL,
	INDEX(ApiCallUserId),
	INDEX(ApiCallId),
	FOREIGN KEY(ApiCallUserId) REFERENCES user(UserId),
	PRIMARY KEY(ApiCallId, ApiCallUserId)
);
