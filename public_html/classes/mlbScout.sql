DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS player;
DROP TABLE IF EXISTS team;
DROP TABLE IF EXISTS ApiCall;
DROP TABLE IF EXISTS favoritePlayer;
DROP TABLE IF EXISTS accessLevel;
DROP TABLE IF EXISTS schedule;

CREATE TABLE user(
	userId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	userAccessLevel INT UNSIGNED NOT NULL,
	userApiCall VARCHAR (32),
	userActivationToken INT,
	userEmail VARCHAR(64) NOT NULL,
	userFirstName VARCHAR(32) NOT NULL,
	userHash INT,
	userLastName VARCHAR(32) NOT NULL,
	userPassword VARCHAR(64) NOT NULL,
	userPhoneNumber INT NOT NULL,
	userSalt INT,
	userUpdate VARCHAR UNSIGNED,
	UNIQUE (EMAIL),
	INDEX(userId),
	FOREIGN KEY (userApiCall) REFERENCES ApiCall(userApiCall),
	FOREIGN KEY (userAccessLevel) REFERENCES AccessLevel(userAccessLevel)
	PRIMARY KEY(userId),
);

CREATE TABLE player (
 playerId INT UNSIGNED AUTO_INCREMENT NOT NULL,
 playerUserId INT UNSIGNED NOT NULL,
 playerBatting INT,
 playerCommitment VARCHAR(128)
 playerFirstName VARCHAR (32)
 playerHealthStatus VARCHAR(64)
 playerHeight INT
 playerHomeTown VARCHAR(64)
 playerLastName VARCHAR (32)
 playerPosition VARCHAR (32)
 playerThrowingHand VARCHAR(16)
 playerUpdate VARCHAR (32)
 INDEX(playerUserId),
 FOREIGN KEY(playerUserId) REFERENCES playerUser(playerUserId),
 PRIMARY KEY(playerId)
);

CREATE TABLE schedule (
 scheduleId INT UNSIGNED AUTO_INCREMENT NOT NULL,
 scheduleTeamId INT UNSIGNED NOT NULL,
 scheduleDate DATETIME NOT NULL
 schedulelocation VARCHAR(64)
 scheduleStartingPosition VARCHAR(32)
 scheduleTime VARCHAR(32)
 INDEX(scheduleTeamId),
 FOREIGN KEY(scheduleTeamId) REFERENCES scheduleTeam(scheduleTeamId),
 PRIMARY KEY(scheduleId)
);

CREATE TABLE apiCall(
apiCallId INT UNSIGNED AUTO_INCREMENT NOT NULL,
apiCallUserId UNSIGNED NOT NULL,
apiCallDatetime DATETIME NOT NULL,
apiCallQueryString VARCHAR(2000),
apiCallURL VARCHAR(32),
apiCallHttpVerb VARCHAR (32),
apiCallBrowser VARCHAR(32),
apicallIP VARCHAR (32),
apiCallPayload VARCHAR(64),
INDEX(apiCallUserid),
FOREIGN KEY (apiCallUserId)REFERENCES apiCall(apiCallUserId),
PRIMARY KEY (apiCallId)
);

CREATE TABLE team(
teamId INT UNSIGNED AUTO_INCREMENT NOT NULL,
teamType VARCHAR(32) NOT NULL,
teamName VARCHAR (64) NOT NULL,
teamStarters VARCHAR(64)
INDEX(teamId),
UNIQUE (teamId),
PRIMARY KEY (teamId)
);

CREATE TABLE AccessLevel(
accessLevelId INT UNSIGNED AUTO_INCREMENT NOT NULL,
accessLevelName VARCHAR(2) NOT NULL,
INDEX(accessLevelId),
PRIMARY KEY(accessLevelId)
);

CREATE TABLE favorite(
favoritePlayerId INT UNSIGNED AUTO_INCREMENT NOT NULL,
favoriteUserId INT NOT NULL,
INDEX(favoriteUserId),
PRIMARY KEY(favoritePlayerId),
FOREIGN KEY(favoriteUserId)REFERENCES favorite(favoriteUserId)
);