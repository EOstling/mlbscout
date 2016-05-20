DROP TABLE IF EXISTS apiCall;
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
	favoritePlayerPlayerId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	favoritePlayerUserId INT UNSIGNED NOT NULL,
	INDEX(favoritePlayerPlayerId),
	INDEX(favoritePlayerUserId),
	FOREIGN KEY (favoritePlayerUserId)REFERENCES user(userId),
	FOREIGN KEY (favoritePlayerPlayerId) REFERENCES player(playerId),
	PRIMARY KEY (favoritePlayerUserId,favoritePlayerPlayerId)
);

CREATE TABLE apiCall(
	apiCallId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	apiCallUserId INT UNSIGNED NOT NULL,
	apiCallBrowser VARCHAR(128) NOT NULL,
	apiCallDateTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	apiCallHttpVerb VARCHAR(6) NOT NULL,
	apiCallIP VARBINARY(16) NOT NULL,
	apiCallQueryString VARCHAR(128),
	apiCallPayload VARCHAR(2000),
	apiCallURL VARCHAR(128) NOT NULL,
	INDEX(apiCallUserId),
	INDEX(apiCallId),
	FOREIGN KEY(apiCallUserId) REFERENCES user(UserId),
	PRIMARY KEY(apiCallId, apiCallUserId)
);
