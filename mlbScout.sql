DROP TABLE IF EXISTS apiCall;
DROP TABLE IF EXISTS accessLevel;
DROP TABLE IF EXISTS favoritePlayer;
DROP TABLE IF EXISTS schedule;
DROP TABLE IF EXISTS player;
DROP TABLE IF EXISTS team;
DROP TABLE IF EXISTS user;

CREATE TABLE user(
	userId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	userAccessLevel INT UNSIGNED NOT NULL,
	userActivationToken CHAR(32),
	userEmail VARCHAR(64) NOT NULL,
	userFirstName VARCHAR(32) NOT NULL,
	userHash CHAR(128) NOT NULL,
	userLastName VARCHAR(32) NOT NULL,
	userPassword VARCHAR(64) NOT NULL,
	userPhoneNumber INT NOT NULL,
	userSalt CHAR(64) NOT NULL,
	userUpdate VARCHAR(64),
	INDEX(userId),
	UNIQUE(userEmail),
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

CREATE TABLE accessLevel(
	accessLevelId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	accessLevelName VARCHAR(24),
	PRIMARY KEY(accessLevelId)
);

CREATE TABLE apiCall(
	apiCallId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	apiCallUserId INT UNSIGNED NOT NULL,
	apiCallDateTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	apiCallQueryString VARCHAR(128),
	apiCallURL VARCHAR(128) NOT NULL,
	apiCallHttpVerb VARCHAR(6) NOT NULL,
	apiCallBrowser VARCHAR(128) NOT NULL,
	apicallIP VARBINARY(16) NOT NULL,
	apiCallPayload VARCHAR(2000),
	INDEX(apiCallUserId),
	INDEX(apiCallId),
	FOREIGN KEY(apiCallUserId) REFERENCES user(UserId),
	PRIMARY KEY(apiCallId, apiCallUserId)
);
