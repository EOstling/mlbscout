DROP TABLE IF EXISTS apiCall;
DROP TABLE IF EXISTS accessLevel;
DROP TABLE IF EXISTS favoritePlayer;
DROP TABLE IF EXISTS schedule;
DROP TABLE IF EXISTS team;
DROP TABLE IF EXISTS player;
DROP TABLE IF EXISTS user;

CREATE TABLE user(
	userId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	useraccessLevel INT UNSIGNED NOT NULL,
	userapiCall VARCHAR (2000),
	userActivationToken INT,
	userEmail VARCHAR(64) NOT NULL,
	userFirstName VARCHAR(32) NOT NULL,
	userHash INT,
	userLastName VARCHAR(32) NOT NULL,
	userPassword VARCHAR(64) NOT NULL,
	userPhoneNumber INT NOT NULL,
	userSalt INT,
	userUpdate VARCHAR(64),
	INDEX(userId),
	UNIQUE(userEmail),
	PRIMARY KEY (userId)
);

CREATE TABLE player (
	playerId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	playerUserId INT UNSIGNED NOT NULL,
	playerBatting INT,
	playerCommitment VARCHAR(128),
	playerFirstName VARCHAR (32),
	playerHealthStatus VARCHAR(64),
	playerHeight INT,
	playerHomeTown VARCHAR(64),
	playerLastName VARCHAR (32),
	playerPosition VARCHAR (8),
	playerThrowingHand VARCHAR(2),
	playerUpdate VARCHAR (32),
	INDEX(playerUserId),
	INDEX(playerId),
	FOREIGN KEY (playerUserId)REFERENCES user(userId),
	PRIMARY KEY(playerId)
);

CREATE TABLE team(
	teamId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	teamType VARCHAR(32) NOT NULL,
	teamName VARCHAR (64) NOT NULL,
	teamRoster VARCHAR(64),
	INDEX(teamId),
	PRIMARY KEY (teamId)
);

CREATE TABLE schedule (
	scheduleId INT  UNSIGNED AUTO_INCREMENT NOT NULL,
	scheduleTeamId INT UNSIGNED NOT NULL  ,
	scheduleLocation VARCHAR(64),
	scheduleStartingPosition VARCHAR(32),
	scheduleTime DATETIME,
	INDEX(scheduleId),
	INDEX(scheduleTeamId),
	FOREIGN KEY(scheduleTeamId)REFERENCES team(TeamId),
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
	accessLevelName VARCHAR(2),
	PRIMARY KEY(accessLevelId)
);

CREATE TABLE apiCall(
	apiCallId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	apiCallUserId INT UNSIGNED NOT NULL,
	apiCallDatetime DATETIME NOT NULL,
	apiCallQueryString VARCHAR(2000),
	apiCallURL VARCHAR(32),
	apiCallHttpVerb VARCHAR (32),
	apiCallBrowser VARCHAR(32),
	apicallIP VARCHAR (32),
	apiCallPayload VARCHAR(64),
	INDEX(apiCallUserid),
	INDEX(apiCallId),
	FOREIGN KEY (apiCallUserId)REFERENCES user(UserId),
	PRIMARY KEY (apiCallId,apiCallUserId)
);
