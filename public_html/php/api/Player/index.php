<?php
use Edu\Cnm\MlbScout;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
/**
 * api for the Player class
 *
 * @author Lucas Laudick based on code by Derek Mauldin
 **/
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/mlbscout.ini");
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$playerUserId = filter_input(INPUT_GET, "playerUserId", FILTER_VALIDATE_INT);
	$PlayerTeamId = filter_input(INPUT_GET, "playerTeamId", FILTER_VALIDATE_INT);
	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new \InvalidArgumentException("id cannot be empty or negative", 405));
	}
	// handle GET request - if id is present, that player is returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//get a specific player and update reply
		if(empty($id) === false) {
			$player = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
			if($player !== null) {
				$reply->data = $player;
			}
		}
		//make sure the User id is valid for the method that requires it
		if(($method === "GET") && (empty($playerUserId) === true || $playerUserId < 0)) {
			throw(new \InvalidArgumentException("player user id cannot be empty or negative", 405));
		}
		//get player by user id and update reply
		if(empty($playerUserId) === false) {
			$players = MlbScout\Player::getPlayerByPlayerUserId($pdo, $playerUserId);
			if($players !== null) {
				$reply->data = $players;
			}
			//make sure the Team id is valid for the method that requires it
			if(($method === "GET") && (empty($playerTeamId) === true || $playerTeamId < 0)) {
				throw(new \InvalidArgumentException("player team id cannot be empty or negative", 405));
			}
			//get player by team id and update reply
			if(empty($playerTeamId) === false) {
				$player = MlbScout\Player::getPlayerByPlayerTeamId($pdo, $playerTeamId);
				if($players !== null) {
					$reply->data = $players;
				}
			} else if($method === "PUT" || $method === "POST") {
				verifyXsrf();
				$requestContent = file_get_contents("php://input");
				$requestObject = json_decode($requestContent);
				//make sure player batting is available
//				if(empty($requestObject->playerBatting) === true) {
//					throw(new \InvalidArgumentException ("No player batting.", 405));
//				}
				//make sure player commitment is available
//				if(empty($requestObject->playerCommitment) === true) {
//					throw(new \InvalidArgumentException ("No player commitment.", 405));
//				}
				//make sure player first name is available
				if(empty($requestObject->playerFirstName) === true) {
					throw(new \InvalidArgumentException ("No player First Name.", 405));
				}
//				//make sure player health status is available
//				if(empty($requestObject->playerHealthStatus) === true) {
//					throw(new \InvalidArgumentException ("No player Health Status.", 405));
//				}
//				//make sure player height is available
//				if(empty($requestObject->playerHeight) === true) {
//					throw(new \InvalidArgumentException ("No player Height.", 405));
//				}
				//make sure player home town is available
				if(empty($requestObject->playerHomeTown) === true) {
					throw(new \InvalidArgumentException ("No player Home Town.", 405));
				}
				//make sure player last name is available
				if(empty($requestObject->playerLastName) === true) {
					throw(new \InvalidArgumentException ("No player Last Name.", 405));
				}
				//make sure player position is available
				if(empty($requestObject->playerPosition) === true) {
					throw(new \InvalidArgumentException ("No player position.", 405));
				}
				//make sure player Throwing hand is available
				if(empty($requestObject->playerThrowingHand) === true) {
					throw(new \InvalidArgumentException ("No player Throwing Hand.", 405));
				}
//				//make sure player weight is available
//				if(empty($requestObject->playerWeight) === true) {
//					throw(new \InvalidArgumentException ("No player weight.", 405));
//				}
				//perform the actual put or post
				if($method === "PUT") {
					// update player batting if it needs updated
//					if(($requestObject->playerBatting) === true) {
//						// retrieve the player to update
//						$player = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
//						if($player === null) {
//							throw(new RuntimeException("player does not exist", 404));
//						}
//						// put the new player batting into the player and update
//						$player->setPlayerBatting($requestObject->playerBatting);
//						$player->update($pdo);
//						// update reply
//						$reply->message = "player updated OK";
//						// update player rating if it needs updated
//					}
					if(($requestObject->playerCommitment) === true) {
						// retrieve the player to update
						$player = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
						if($player === null) {
							throw(new RuntimeException("player does not exist", 404));
						}
						// put the new player Commitment into the player and update
						$player->setPlayerCommitment($requestObject->playerCommitment);
						$player->update($pdo);
						// update reply
						$reply->message = "player updated OK";
						// update player rating if it needs updated
					}
//					if(($requestObject->playerFirstName) === true) {
//						// retrieve the player to update
//						$player = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
//						if($player === null) {
//							throw(new RuntimeException("player does not exist", 404));
//						}
//						// put the new player First Name into the player and update
//						$player->setPlayerFirstName($requestObject->playerFirstName);
//						$player->update($pdo);
//						// update reply
//						$reply->message = "player updated OK";
//						// update player rating if it needs updated
//					}
					if(($requestObject->playerHealthStatus) === true) {
						// retrieve the player to update
						$player = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
						if($player === null) {
							throw(new RuntimeException("player does not exist", 404));
						}
						// put the new player Health Status into the player and update
						$player->setPlayerHealthStatus($requestObject->playerHealthstatus);
						$player->update($pdo);
						// update reply
						$reply->message = "player updated OK";
						// update player rating if it needs updated
					}
					if(($requestObject->playerHeight) === true) {
						// retrieve the player to update
						$player = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
						if($player === null) {
							throw(new RuntimeException("player does not exist", 404));
						}
						// put the new player Height into the player and update
						$player->setPlayerHeight($requestObject->playerHeight);
						$player->update($pdo);
						// update reply
						$reply->message = "player updated OK";
						// update player rating if it needs updated
					}
					if(($requestObject->playerHomeTown) === true) {
						// retrieve the player to update
						$player = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
						if($player === null) {
							throw(new RuntimeException("player does not exist", 404));
						}
						// put the new player Home Town into the player and update
						$player->setPlayerHomeTown($requestObject->playerHomeTown);
						$player->update($pdo);
						// update reply
						$reply->message = "player updated OK";
						// update player rating if it needs updated
					}
					if(($requestObject->playerLastName) === true) {
						// retrieve the player to update
						$player = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
						if($player === null) {
							throw(new RuntimeException("player does not exist", 404));
						}
						// put the new player Last Name into the player and update
						$player->setPlayerLastName($requestObject->playerLastName);
						$player->update($pdo);
						// update reply
						$reply->message = "player updated OK";
						// update player rating if it needs updated
					}
					if(($requestObject->playerPosition) === true) {
						// retrieve the player to update
						$player = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
						if($player === null) {
							throw(new RuntimeException("player does not exist", 404));
						}
						// put the new player position into the player and update
						$player->setPlayerPosition($requestObject->playerPostion);
						$player->update($pdo);
						// update reply
						$reply->message = "player updated OK";
						// update player rating if it needs updated
					}
					if(($requestObject->playerThrowingHand) === true) {
						// retrieve the player to update
						$player = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
						if($player === null) {
							throw(new RuntimeException("player does not exist", 404));
						}
						// put the new player Throwing Hand into the player and update
						$player->setPlayerThrowingHand($requestObject->playerThrowingHand);
						$player->update($pdo);
						// update reply
						$reply->message = "player updated OK";
						// update player rating if it needs updated
					}
					if(($requestObject->playerWeight) === true) {
						// retrieve the player to update
						$player = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
						if($player === null) {
							throw(new RuntimeException("player does not exist", 404));
						}
						// put the new player commitment into the feedback and update
						$player->setplayerWeight($requestObject->playerWeight);
						$player->update($pdo);
						// update reply
						$reply->message = "player updated OK";
					} else if($method === "POST") {
						//  make sure playerUserId or playerTeamId is available
						if(empty($requestObject->playerUserId) === true || empty($requestObject->playerTeamId) === true) {
							throw(new \InvalidArgumentException ("No User or Team ID.", 405));
						}
						// create new player and insert into the database
						$player = new MlbScout\Player(null, $requestObject->playerUserId, $requestObject->playerTeamId, $requestObject->playerBatting, $requestObject->playerCommitment, $requestObject->playerFirstName, $requestObject->playerHealthStatus, $requestObject->playerHeight, $requestObject->playerHomeTown, $requestObject->playerLastName, $requestObject->playerPosition, $requestObject->playerThrowingHand, $requestObject->playerWeight);
						$player->insert($pdo);
						// update reply
						$reply->message = "player created OK";
					}
				} else if($method === "DELETE") {
					verifyXsrf();
					// retrieve the player to be deleted
					$player = MlbScout\Player::getPlayerByPlayerId($pdo, $id);
					if($player === null) {
						throw(new RuntimeException("player does not exist", 404));
					}
					// delete player
					$player->delete($pdo);
					// update reply
					$reply->message = "Player deleted OK";
				} else {
					throw (new InvalidArgumentException("Invalid HTTP method request"));
				}
			}
		}
	}
} // update reply with exception information
catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);