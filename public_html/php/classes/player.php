<?php
namespace Edu\Cnm\llaudick\mlbscout;

/**
 *
 *
 *
 * @author Lucas Laudick <llaudick@cnm.edu>
 **/
class Player implements \JsonSerializable {
	/**
	 * id for player; this is the primary key
	 * @var int $playerId
	 **/
	private $playerId;
	/**
	 * id of the user that has this player; this is the foreign key
	 * @var int $playerUserId
	 **/
	private $playerUserId;
	/**
	 *
	 * @var int $playerBatting
	 **/
	private $playerBatting;
	/**
	 *
	 * @var string $playerCommitment
	 **/
	private $playerCommitment;
	/**
	 *
	 * @var string $playerFirstName
	 **/
	private $playerFirstName;
	/**
	 *
	 * @var string $playerHealthStatus
	 **/
	private $playerHealthStatus;
	/**
	 *
	 * @var int $playerHeight
	 **/
	private $playerHeight;
	/**
	 *
	 * @var string $playerHomeTown
	 **/
	private $playerHomeTown;
	/**
	 *
	 * @var string $playerLastName
	 **/
	private $playerLastName;
	/**
	 *
	 * @var string $playerPosition
	 **/
	private $playerPosition;
	/**
	 *
	 * @var string $playerThrowingHand
	 **/
	private $playerThrowingHand;
	/**
	 *
	 * @var string $playerUpdate
	 **/
	private $playerUpdate;
	/**
	 *
	 * @var int $playerWeight
	 **/
	private $playerWeight;

	/**
	 * constructor for this Player
	 *
	 * @param int|null $newPlayerId id of this player or null if a new playerWeight
	 * @param int $newPlayerUserId id of the playerUser that has the playerUser
	 * @param int $newPlayerBatting of the players batting stats_skew
	 * @param int $newPlayerHeight of the players height
	 * @param int $newPlayerWeight of the players weight
	 * @param string $newPlayerCommitment string containing the player if they have commited or not
	 * @param string $newPlayerFirstName string containing the players first name
	 * @param string $newPlayerHealthStatus string containing the players health status
	 * @param string $newPlayerHomeTown string containing the players hometown
	 * @param string $newPlayerLastName string containing the players last name
	 * @param string $newPlayerPosition string containing the players position
	 * @param string $newPlayerThrowingHand string containing the players throwing hand
	 * @param string $newPlayerUpdate string containing the players updated status
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integer)
	 * @throws \TypeError if data types violate type HttpInflateStream
	 * @throws \Exception if some other exceptions oci_new_cursor
	 **/
	public function __construct(int $newPlayerId = null, int $newPlayerUserId, int $newPlayerBatting, int $newPlayerHeight, int $newPlayerWeight, string $newPlayerCommitment, string $newPlayerFirstName, string $newPlayerHealthStatus, string $newPlayerHomeTown, string $newPlayerLastName, string $newPlayerPosition, string $newPlayerThrowingHand, string $newPlayerUpdate) {
		try {
			$this->setPlayerId($newPlayerId);
			$this->setPlayerUserId($newPlayerUserId);
			$this->setPlayerBatting($newPlayerBatting);
			$this->setPlayerHeight($newPlayerHeight);
			$this->setPlayerWeight($newPlayerWeight);
			$this->setPlayerCommitment($newPlayerCommitment);
			$this->setPlayerFirstName($newPlayerFirstName);
			$this->setPlayerHealthStatus($newPlayerHealthStatus);
			$this->setPlayerHomeTown($newPlayerHomeTown);
			$this->setPlayerLastName($newPlayerLastName);
			$this->setPlayerPosition($newPlayerPosition);
			$this->setPlayerThrowingHand($newPlayerThrowingHand);
			$this->setPlayerUpdate($newPlayerUpdate);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow th exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			//rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			//rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for player id
	 *
	 * @return int|null value of player id
	 **/
	public function getPlayerId() {
		return($this->playerId);
	}

	/**
	 * mutato method for player id
	 *
	 * @param int|null $newPlayerId new value of player id
	 * @throws \RangeException if $newPlayerId is not positive
	 * @throws \TypeError if $newPlayerId is not an integer
	 **/
	public function setPlayerId(int $newPlayerId = null) {
		// if the player id is null, this a new tweet wihtout a mysql assigned id
		if($newPlayerId === null) {
			$this->playerId = null;
			return;
		}

		// verify the player id is positive
		if($newPlayerId <= 0) {
			throw(new \RangeException("player id is not positive"));
		}

		//convert and store player id
		$this->playerId = $newPlayerId;
	}

	/**
	 * accessor method for playeruser id
	 *
	 * @return in value of playeruser id
	 **/
	public function getPlayerUserId() {
		return($this->PlayerUserId);
	}

	/**
	 * mutator method for playeUser id
	 *
	 * @param int $newPlayerUserId new value of playerUser id
	 * @throws \RangeException if $newPlayerUserId is not positive
	 * @throws \TypeError if $newPlayerUserId is not an integer
	 **/
	public function setPlayerUserId(int $newPlayerUserId) {
		// verify the playerUser id is positve
		if($newPlayerUserId <= 0) {
			throw(new\ RangeException("playerUser id is not positve"));
		}
		// convert and store playerUser id
		$this->playerUserId = $newPlayerUserId;
	}

	/**
	 * accessor method for playerBatting
	 *
	 * @return value of playerBatting
	 **/
	public function getPlayerBatting() {
		return($this->playerBatting);
	}

	/**
	 * mutator method for playerBatting
	 *
	 * @param int $newPlayerBatting new value of playerBatting
	 * @throws \RangeException if $newPlayerBatting is not positive
	 * @throws \TypeError if $newPlayerBatting is not a string
	 **/
	public function setPlayerBatting(int $newPlayerBatting) {
		// verify playerBatting is positive
		if($newPlayerBatting <= 0) {
			throw(new\ RangeException("player batting is not positive"));
		}

		// convert and store the playerBatting
		$this->playerBatting = $newPlayerBatting;
	}

	/**
	 * @ accessor method for playerCommitment
	 *
	 * @return string value of playerCommitment content
	 **/
	public function getPlayerCommitment() {
		return($this->playerCommitment);
	}

	/**
	 * mutator method for playerCommitment
	 *
	 * @param string $newPlayerCommitment new value of playerCommitment
	 * @throws \InvalidArgumentException if $newPlayerCommitment is not a string or insecure
	 * @throws \RangeException if $newPlayerCommitment is > 128 characters
	 * @throws \TypeError if $newPlayerCommitment is not a string
	 **/
	public function setPlayerCommitment(string $newPlayerCommitment) {
		// verify the playerCommitment is sqlite_current
		$newPlayerCommitment = trim($newPlayerCommitment);
		$newPlayerCommitment = filter_var($newPlayerCommitment, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPlayerCommitment) === true) {
			throw(new \InvalidArgumentException("player commitment is empty or insecure"));
		}

		// verify the playerCommitment will fit the database
		if(strlen($newPlayerCommitment) > 128) {
			throw(new \RangeException("player commitment too large"));
		}

		// store the player commitment
		$this->playerCommitment = $newPlayerCommitment;
	}

	/**
	 * accessor method for playerFirstName
	 *
	 * @return string value of playerFirstName
	 **/
	public function getPlayerFirstName() {
		return($this->playerFirstName);
	}

	/**
	 * mutator method for playerFirstName
	 *
	 * @param string $newPlayerFirstName new value of playerFirstName
	 * @throws \InvalidArgumentException if $newPlayerFirstName is not a string or insecure
	 * @throws \RangeException if $newPlayerFirstName is > 32 charachters
	 * @throws \TypeError if $newPlayerFirstName is not a string
	 **/
	public function setPlayerFirstName(string $newPlayerFirstName) {
		// verify the playerFirstName is sqlite_current
		$newPlayerFirstName = trim($newPlayerFirstName);
		$newPlayerFirstName = filter_var($newPlayerFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPlayerFirstName) === true) {
			throw(new \InvalidArgumentException("player first name is empty or insecure"));
		}

		// verify the playerFirstName will fit the database
		if(strlen($newPlayerFirstName) > 32) {
			throw(new \RangeException("player first name too large"));
		}

		// store the playerFirstName
		$this->playerFirstName = $newPlayerFirstName;
	}

	/**
	 * accessor method for playerHealthStatus
	 *
	 * @return string value of playerHealthStatus
	 **/
	public function getPlayerHealthStatus() {
		return($this->playerHealthStatus);
	}

	/**
	 * mutator method for playerHealthStatus
	 *
	 * @param string $newPlayerHealthStatus new value of playerHealthStatus
	 * @throws \InvalidArgumentException if $newPlayerHealthStatus is not a string or insecure
	 * @throws \RangeException if $newPlayerHealthStatus is > 64 charachters
	 * @throws \TypeError if $newPlayerHealthStatus is not a string
	 **/
	public function setPlayerHealthStatus(string $newPlayerHealthStatus) {
		// verify the playerHealthStatus is sqlite_current
		$newPlayerHealthStatus = trim($newPlayerHealthStatus);
		$newPlayerHealthStatus = filter_var($newPlayerHealthStatus, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPlayerHealthStatus) === true) {
			throw(new \InvalidArgumentException("player health status id empty or secure"));
		}

		// verify the playerHealthStatus will fit the database
		if(strlen($newPlayerHealthStatus) > 64) {
			throw(new \RangeException("player health status too large"));
		}

		//store the playerHealthStatus
		$this->playerHealthStatus = $newPlayerHealthStatus;
	}

	/**
	 * accessor method for playerHeight
	 *
	 * @return int value of playerHeight
	 **/
	public function getPlayerHeight() {
		return ($this->playerHeight);
	}

	/**
	 * mutator method for playerHeight
	 * @param int $newPlayerHeight new value of playerHeight
	 * @throws \RangeException if $newPlayerHeight is not positive
	 * @throws \TypeError if $newPlayerHeight is not an integer
	 **/
	public function setPlayerHeight(int $playerHeight) {
		// verify the playerHeight is positive
		if($newPlayerHeight <= 0) {
			throw(new \RangeException("player height is not positve"));
		}

		//convert and store playerHeight
		$this->playerHeight = $newPlayerHeight;
	}

	/**
	 * accessor method for playerHomeTown
	 *
	 * @return string value of playerHomeTown
	 **/
	public function getPlayerHomeTown() {
		return($this->$newPlayerHomeTown);
	}

	/**
	 * mutator method for playerHomeTown
	 *
	 * @param string $newPlayerHomeTown new value of playerHomeTown
	 * @throws \InvalidArgumentException if $newPlayerHomeTown is not a string of insecure
	 * @throws \RangeException if $newPlayerHomeTown is > 64 characters
	 * @throws \TypeError if $newPlayerHomeTown is not a string
	 **/
	public function setPlayerHomeTown(string $newPlayerHomeTown) {
		// verify the playerHomeTown is secure
		$newPlayerHomeTown = trim($newPlayerHomeTown);
		$newPlayerHomeTown = filter_var($newPlayerHomeTown, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPlayerHomeTown) === true) {
			throw(new \InvalidArgumentException("player home town is empty or insecure"));
		}

		// verify the playerHomeTown will fit the database
		if(strlen($newPlayerHomeTown) > 64) {
			throw(new \RangeException(player home town is too large));
      }

		// store the playerHomeTown
		$this->playerHomeTown = $newPlayerHomeTown;
	}

	/**
	 * accessor method for playerLastName
	 *
	 * @return string value of playerLastName
	 **/
	public function getPlayerLastName() {
		return($this->playerLastName);
	}

	/**
	 * mutator method for playerLastName
	 *
	 * @param string $newPlayerLastName new value of playerLastName
	 * @throws \InvalidArgumentException if $newPlayerLastName is not a string or insecure
	 * @throws \RangeException if $newPlayerLastName is > 32 characters
	 * @throws \TypeError if $newPlayerLastName is not a string
	 **/
	public function setPlayerLastName(string $newPlayerLastName) {
		// verify the playerLastName is secure
		$newPlayerLastName = trim($newPlayerLastName);
		$newPlayerLastName = filter_var($newPlayerLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPlayerLastName) === true) {
			throw(new \InvalidArgumentException("player last name is empty or insecure"));
		}

		// verify the playerLastName will fit the database
		if(strlen($newPlayerLastName) > 32) {
			throw(new \RangeException("player last name is too large"));
		}

		// store the playerLastName
		$this->playerLastName = $newPlayerLastName;
	}

	/**
	 * accessor method for playerPosition
	 *
	 * @return string value of playerPosition
	 **/
	public function getPlayerPosition() {
		return($this->playerPosition);
	}

	/**
	 * mutator method for playerPosition
	 *
	 * @param string $newPlayerPosition new value of playerPosition
	 * @throws \InvalidArgumentException if $newPlayerPosition is not a string or insecure
	 * @throws \RangeException if $newPlayerPosition is > 32 characters
	 * @throws \TypeError if $newPlayerPosition is not a string
	 **/
	public function setPlayerPosition(string $newPlayerPosition) {
		// verify the playerPosition is secure
		$newPlayerPosition = trim($newPlayerPosition);
		$newPlayerPosition = filter_var($newPlayerPosition, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPlayerPosition) === true) {
			throw(new \InvalidArgumentException("player position is empty or insecure"));
		}

		// verify the playerPositionwill fit the database
		if(strlen($newPlayerPosition) > 32) {
			throw(new \RangeException("player position is too large"));
		}

		// store the player position
		$this->playerPosition = $newPlayerPosition;
	}


	/**
	 * accessor method for playerThrowingHand
	 *
	 * @return string value of playerThrowingHand
	 **/
	public function getPlayerThrowingHand() {
		return($this->$newPlayerThrowingHand);
	}

	/**
	 * mutator method for playerThrowingHand
	 *
	 * @param string $newPlayerThrowingHand new value of playerThrowingHand
	 * @throws \InvalidArgumentException if $newPlayerThrowingHand is not a string or insecure
	 * @throws \RangeException if $newPlayerThrowingHand is > 16 characters
	 * @throws \TypeError if $newPlayerThrowingHand is not a string
	 **/
	public function setPlayerThrowingHand(string $newPlayerThrowingHand) {
		// verify the playerThrowingHand is secure
		$newPlayerThrowingHand = trim($newPlayerThrowingHand);
		$newPlayerThrowingHand = filter_var($newPlayerThrowingHand, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPlayerThrowingHand) === true) {
			throw(new \InvalidArgumentException("player throwing hand is empty or insecure"));
		}

		// verify the playerThrowingHand will fit the database
		if(strlen($newPlayerThrowingHand) > 16) {
			throw(new \RangeException(" player throwing hand is too large"));
		}

		// store the playerThrowingHand
		$this->playerThrowingHand = $newPlayerThrowingHand;
	}

	/**
	 * accessor method for playerUpdate
	 *
	 * @return string value of playerUpdate
	 **/
	public function getPlayerUpdate() {
		return($this->playerUpdate);
	}

	/**
	 * mutator method for playerUpdate
	 *
	 * @param string $newPlayerUpdate new value of playerUpdate
	 * @throws \InvalidArgumentException if $newPlayerUpdate is not a string or insecure
	 * @throws \RangeException if $newPlayerUpdate is > 32 characters
	 * @throws \TypeError if $newPlayerUpdate is not a string
	 **/
	public function setPlayerUpdate(string $newPlayerUpdate) {
		// verify the playerUpdate is secure
		$newPlayerUpdate = trim($newPlayerUpdate);
		$newPlayerUpdate = filter_var($newPlayerUpdate, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPlayerUpdate) === true) {
			throw(new \InvalidArgumentException("player update is empty or insecure"));
		}

		// verify the playerUpdate will fit the database
		if(strlen($newPlayerUpdate) > 32) {
			throw(new \RangeException("player update is too large"));
		}

		// store the playerUpdate
		$this->playerUpdate = $newPlayerUpdate;
	}

	/**
	 * accessor method for playerWeight
	 *
	 * @return int value of playerWeight
	 **/
	public function getPlayerWeight() {
		return($this->playerWeight);
	}

	/**
	 * mutator method for playerWeight
	 *
	 * @param int $newPlayerWeight new value of playerWeight
	 * @throws \RangeException if $newPlayerWeight is not positive
	 * @throws \TypeError if $newPlayerWeight is not an integer
	 **/
	public function setPlayerWeight(int $newPlayerWeight) {
		// verify the playerWeight is positive
		if($newPlayerWeight <= 0) {
			throw(new \RangeException("player weight is not positive"));
		}

		// convert and store playerWeight
		$this->playerWeight = $newPlayerWeight;
	}

	/**
	 * inserts the player into mySQL
	 *
	 * @param \PDO $pdo PDO conncetion oci_fetch_object
	 * @throws \PDOException when mySQl related errors oci_new_cursor
	 * @throws \TypeError if $pdo is not a PDO conncetion object
	 **/
	public function insert(\PDO $pdo) {
		// enforce the player id is null (dont need to insert the player if its already in the system)
		if($this->playerId !== null) {
			throw(new \PDOException("not a new player"));
		}

		// create query template
		$query = "INSERT INTO player(playerUserId, playerBatting, playerCommitment, playerFirstName, playerHealthStatus, playerHeight, playerHomeTown, playerLastName, playerPosition, playerThrowingHand, playerUpdate, playerWeight) VALUES(:playerUserId, :playerBatting, :playerCommitment, :playerFirstName, :playerHealthStatus, :playerHeight, :playerHomeTown, :playerLastName, :playerPosition, :playerThrowingHand, :playerUpdate, :playerWeight)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["playerUserId" => $this->playerUserId, "playerBatting" => $this->playerBatting, "playerCommitment" => $this->playerCommitment, "playerFirstName" => $this->playerFirstName, "playerHealthStatus" => $this->playerHealthStatus, "playerHeight" => $this->playerHeight, "playerHomeTown" => $this->playerHomeTown, "playerLastName" => $this->playerLastName, "playerPosition" => $this->playerPosition, "playerThrowingHand" => $this->playerThrowingHand, "playerUpdate" => $this->playerUpdate, "playerWeight" => $this->playerWeight];
		$statement->execute($parameters);

		//update the null playerId with what mySQL just gave us
		$this->playerId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this player from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
publuc function delete(\PDO $pdo) {
	// enforce the playerId is not null (dont delete players that haevnt been inserted)
	if($this->playerId === null) {
		throw(new \PDOException("unable to delete a player that does not exist"));
	}

	// create query template
	$query = "DELETE FROM player WHERE playerId =:playerId";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place homder in the template
	$parameters = ["playerId" => $this->playerId];
	$statement->execute($parameters);
	}

	/**
	 * updates the player in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) {
		// enforce the playerId is not null (dont update a player that hasn't been inserted)
		if($this->playerId === null) {
			throw(new \PDOException("unable to update a player that does not exist"));
		}

		// create query template
		$query = "UPDATE player SET playerUserId = :playerUserId, playerBatting = :playerBatting, playerCommitment = :playerCommitment, playerFirstName = :playerFirstName, playerHealthStatus = :playerHealthStatus, playerHeight = :playerHeight, playerHomeTown = :playerHomeTown, playerLastName = :playerLastName, playerPosition = :playerPosition, playerThrowingHand = :playerThrowingHand, playerUpdate = :playerUpdate, playerWeight = :playerWeight WHERE playerId = :playerId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["playerUserId" => $this->playerUserId, "playerBatting" => $this->playerBatting, "playerCommitment" => $this->playerCommitment, "playerFirstName" => $this->playerFirstName, "playerHealthStatus" => $this->playerHealthStatus, "playerHeight" => $this->playerHeight, "playerHomeTown" => $this->playerHomeTown, "playerLastName" => $this->playerLastName, "playerPosition" => $this->playerPosition, "playerThrowingHand" => $this->playerThrowingHand, "playerUpdate" => $this->playerUpdate, "playerWeight" => $this->playerWeight, "playerId" => $this->playerId];
		$statement->execute($parameters);
	}

	/**
	 * gets player by playerCommitment
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $playerCommitment player commitment to search for
	 * @return \SplFixedArray SplFixedArray of players found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPlayerByPlayerCommitment(\PDO $pdo, string $playerCommitment) {
		// sanitize the description before searching
		$playerCommitment = trim($playerCommitment);
		$playerCommitment = filter_var($playerCommitment, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($playerCommitment) === true) {
			throw(new \PDOException("player commitment is invalid"));
		}

		// create query template
		$query = "SELECT playerId, playerUserId, playerBatting, playerCommitment, playerFirstName, playerHealthStatus, playerHeight, playerHomeTown, playerLastName, playerPosition, playerThrowingHand, playerUpdate, playerWeight FROM player WHERE playerCommitment LIKE :playerCommitment";
		$statement = $pdo->prepare($query);

		//bind the playerCommitment to the place holder in the template
		$playerCommitment = "%$playerCommitment%";
		$parameters = array("playerCommitment" => $playerCommitment);
		$statement->execute($parameters);

		// build an array of players
		$players = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$player = new Player($row["playerId"], $row["playerUserId"], $row["playerBatting"], $row["playerCommitment"], $row["playerFirstName"], $row["playerHealthStatus"], $row["playerHeight"], $row["playerHomeTown"], $row["playerLastName"], $row["playerPosition"], $row["playerThrowingHand"], $row["playerUpdate"], $row["playerWeight"]);
				$players[$players->key()] = $player;
				$players->next();
			}catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($players);
	}

	/**
	 * gets player by playerFirstName
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $playerFirstName player first name to search for
	 * @return \SplFixedArray SplFixedArray of players found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPlayerByPlayerFirstName(\PDO $pdo, string $playerFirstName) {
		// sanitize the description before searching
		$playerFirstName = trim($playerFirstName);
		$playerFirstName = filter_var($playerFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($playerFirstName) === true) {
			throw(new \PDOException("player first name is invalid"));
		}

		// create query template
		$query = "SELECT playerId, playerUserId, playerBatting, playerCommitment, playerFirstName, playerHealthStatus, playerHeight, playerHomeTown, playerLastName, playerPosition, playerThrowingHand, playerUpdate, playerWeight FROM player WHERE playerFirstName LIKE :playerFirstName";
		$statement = $pdo->prepare($query);

		//bind the playerUserId to the place holder in the template
		$playerFirstName = "%$playerFirstName%";
		$parameters = array("playerFirstName" => $playerFirstName);
		$statement->execute($parameters);

		// build an array of players
		$players = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$player = new Player($row["playerId"], $row["playerUserId"], $row["playerBatting"], $row["playerCommitment"], $row["playerFirstName"], $row["playerHealthStatus"], $row["playerHeight"], $row["playerHomeTown"], $row["playerLastName"], $row["playerPosition"], $row["playerThrowingHand"], $row["playerUpdate"], $row["playerWeight"]);
				$players[$players->key()] = $player;
				$players->next();
			}catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($players);
	}

	/**
	 * gets player by playerHealthStatus
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $playerHealthStatus player user id to search for
	 * @return \SplFixedArray SplFixedArray of players found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPlayerByPlayerHealthStatus(\PDO $pdo, string $playerHealthStatus) {
		// sanitize the description before searching
		$playerHealthStatus = trim($playerHealthStatus);
		$playerHealthStatus = filter_var($playerHealthStatus, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($playerHealthStatus) === true) {
			throw(new \PDOException("player health status is invalid"));
		}

		// create query template
		$query = "SELECT playerId, playerUserId, playerBatting, playerCommitment, playerFirstName, playerHealthStatus, playerHeight, playerHomeTown, playerLastName, playerPosition, playerThrowingHand, playerUpdate, playerWeight FROM player WHERE playerHealthStatus LIKE :playerHealthStatus";
		$statement = $pdo->prepare($query);

		//bind the playerHealthStatus to the place holder in the template
		$playerHealthStatus = "%$playerHealthStatus%";
		$parameters = array("playerHealthStatus" => $playerHealthStatus);
		$statement->execute($parameters);

		// build an array of players
		$players = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$player = new Player($row["playerId"], $row["playerUserId"], $row["playerBatting"], $row["playerCommitment"], $row["playerFirstName"], $row["playerHealthStatus"], $row["playerHeight"], $row["playerHomeTown"], $row["playerLastName"], $row["playerPosition"], $row["playerThrowingHand"], $row["playerUpdate"], $row["playerWeight"]);
				$players[$players->key()] = $player;
				$players->next();
			}catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($players);
	}

	/**
	 * gets player by playerHomeTown
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $playerHomeTown player user id to search for
	 * @return \SplFixedArray SplFixedArray of players found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPlayerByHomeTown(\PDO $pdo, string $playerHomeTown) {
		// sanitize the description before searching
		$playerHomeTown = trim($playerHomeTown);
		$playerHomeTown = filter_var($playerHomeTown, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($playerHomeTown) === true) {
			throw(new \PDOException("player home town is invalid"));
		}

		// create query template
		$query = "SELECT playerId, playerUserId, playerBatting, playerCommitment, playerFirstName, playerHealthStatus, playerHeight, playerHomeTown, playerLastName, playerPosition, playerThrowingHand, playerUpdate, playerWeight FROM player WHERE playerHomeTown LIKE :playerHomeTown";
		$statement = $pdo->prepare($query);

		//bind the playerHomeTown to the place holder in the template
		$playerHomeTown = "%$playerHomeTown%";
		$parameters = array("playerHomeTown" => $playerHomeTown);
		$statement->execute($parameters);

		// build an array of players
		$players = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$player = new Player($row["playerId"], $row["playerUserId"], $row["playerBatting"], $row["playerCommitment"], $row["playerFirstName"], $row["playerHealthStatus"], $row["playerHeight"], $row["playerHomeTown"], $row["playerLastName"], $row["playerPosition"], $row["playerThrowingHand"], $row["playerUpdate"], $row["playerWeight"]);
				$players[$players->key()] = $player;
				$players->next();
			}catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($players);
	}

	/**
	 * gets player by playerLastName
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $playerLastName player last name to search for
	 * @return \SplFixedArray SplFixedArray of players found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPlayerByPlayerLastName(\PDO $pdo, string $playerLastName) {
		// sanitize the description before searching
		$playerLastName = trim($playerLastName);
		$playerLastName = filter_var($playerLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($playerLastName) === true) {
			throw(new \PDOException("player last name is invalid"));
		}

		// create query template
		$query = "SELECT playerId, playerUserId, playerBatting, playerCommitment, playerFirstName, playerHealthStatus, playerHeight, playerHomeTown, playerLastName, playerPosition, playerThrowingHand, playerUpdate, playerWeight FROM player WHERE playerLastName LIKE :playerLastName";
		$statement = $pdo->prepare($query);

		//bind the playerLastName to the place holder in the template
		$playerLastName = "%$playerLastName%";
		$parameters = array("playerLastName" => $playerLastName);
		$statement->execute($parameters);

		// build an array of players
		$players = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$player = new Player($row["playerId"], $row["playerUserId"], $row["playerBatting"], $row["playerCommitment"], $row["playerFirstName"], $row["playerHealthStatus"], $row["playerHeight"], $row["playerHomeTown"], $row["playerLastName"], $row["playerPosition"], $row["playerThrowingHand"], $row["playerUpdate"], $row["playerWeight"]);
				$players[$players->key()] = $player;
				$players->next();
			}catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($players);
	}

	/**
	 * gets player by playerPosition
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $playerPosition player position to search for
	 * @return \SplFixedArray SplFixedArray of players found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPlayerByPlayerPosition(\PDO $pdo, string $playerPosition) {
		// sanitize the description before searching
		$playerPosition = trim($playerPosition);
		$playerPosition = filter_var($playerPosition, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($playerPosition) === true) {
			throw(new \PDOException("player position is invalid"));
		}

		// create query template
		$query = "SELECT playerId, playerUserId, playerBatting, playerCommitment, playerFirstName, playerHealthStatus, playerHeight, playerHomeTown, playerLastName, playerPosition, playerThrowingHand, playerUpdate, playerWeight FROM player WHERE playerPosition LIKE :playerPosition";
		$statement = $pdo->prepare($query);

		//bind the playerPosition to the place holder in the template
		$playerPosition = "%$playerPosition%";
		$parameters = array("playerPosition" => $playerPosition);
		$statement->execute($parameters);

		// build an array of players
		$players = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$player = new Player($row["playerId"], $row["playerUserId"], $row["playerBatting"], $row["playerCommitment"], $row["playerFirstName"], $row["playerHealthStatus"], $row["playerHeight"], $row["playerHomeTown"], $row["playerLastName"], $row["playerPosition"], $row["playerThrowingHand"], $row["playerUpdate"], $row["playerWeight"]);
				$players[$players->key()] = $player;
				$players->next();
			}catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($players);
	}

	/**
	 * gets player by playerThrowingHand
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $playerThrowingHand player throwing hand to search for
	 * @return \SplFixedArray SplFixedArray of players found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPlayerByPlayerThrowingHand(\PDO $pdo, string $playerThrowingHand) {
		// sanitize the description before searching
		$playerThrowingHand = trim($playerThrowingHand);
		$playerThrowingHand = filter_var($playerThrowingHand, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($playerThrowingHand) === true) {
			throw(new \PDOException("player throwing hand is invalid"));
		}

		// create query template
		$query = "SELECT playerId, playerUserId, playerBatting, playerCommitment, playerFirstName, playerHealthStatus, playerHeight, playerHomeTown, playerLastName, playerPosition, playerThrowingHand, playerUpdate, playerWeight FROM player WHERE playerThrowingHand LIKE :playerThrowingHand";
		$statement = $pdo->prepare($query);

		//bind the playerThrowingHand to the place holder in the template
		$playerThrowingHand = "%$playerThrowingHand%";
		$parameters = array("playerThrowingHand" => $playerThrowingHand);
		$statement->execute($parameters);

		// build an array of players
		$players = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$player = new Player($row["playerId"], $row["playerUserId"], $row["playerBatting"], $row["playerCommitment"], $row["playerFirstName"], $row["playerHealthStatus"], $row["playerHeight"], $row["playerHomeTown"], $row["playerLastName"], $row["playerPosition"], $row["playerThrowingHand"], $row["playerUpdate"], $row["playerWeight"]);
				$players[$players->key()] = $player;
				$players->next();
			}catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($players);
	}

	/**
	 * gets player by playerUpdate
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $playerUpdate player update to search for
	 * @return \SplFixedArray SplFixedArray of players found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPlayerByPlayerUpdate(\PDO $pdo, string $playerUpdate) {
		// sanitize the description before searching
		$playerUpdate = trim($playerUpdate);
		$playerUpdate = filter_var($playerUpdate, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($playerUpdate) === true) {
			throw(new \PDOException("player update is invalid"));
		}

		// create query template
		$query = "SELECT playerId, playerUserId, playerBatting, playerCommitment, playerFirstName, playerHealthStatus, playerHeight, playerHomeTown, playerLastName, playerPosition, playerThrowingHand, playerUpdate, playerWeight FROM player WHERE playerUpdate LIKE :playerUpdate";
		$statement = $pdo->prepare($query);

		//bind the playerUpdate to the place holder in the template
		$playerUpdate = "%$playerUpdate%";
		$parameters = array("playerUpdate" => $playerUpdate);
		$statement->execute($parameters);

		// build an array of players
		$players = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$player = new Player($row["playerId"], $row["playerUserId"], $row["playerBatting"], $row["playerCommitment"], $row["playerFirstName"], $row["playerHealthStatus"], $row["playerHeight"], $row["playerHomeTown"], $row["playerLastName"], $row["playerPosition"], $row["playerThrowingHand"], $row["playerUpdate"], $row["playerWeight"]);
				$players[$players->key()] = $player;
				$players->next();
			}catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($players);
	}

	/**
	 * gets the player by playerId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $playerId player id to search for
	 * @return player|null player found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPlayerByPlayerId(\PDO $pdo, int $playerId) {
		// sanitixe the player id before searching
		if($playerId <= 0) {
			throw(new \PDOException("player id is not positive"));
		}

		// create query template
		$query = "SELECT playerId, playerUserId, playerBatting, playerCommitment, playerFirstName, playerHealthStatus, playerHeight, playerHomeTown, playerLastName, playerPosition, playerThrowingHand, playerUpdate, playerWeight FROM player WHERE playerId = :playerId";
		$statement = $pdo->prepare($query);

		// bind the player id to the place holder in the template
		$parameters = array("playerId" => $playerId);
		$statement->execute($parameters);

		// grab the player from mySQL
		try {
			$player = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$player = new Player($row["playerId"], $row["playerUserId"], $row["playerBatting"], $row["playerCommitment"], $row["playerFirstName"], $row["playerHealthStatus"], $row["playerHeight"], $row["playerHomeTown"], $row["playerLastName"], $row["playerPosition"], $row["playerThrowingHand"], $row["playerUpdate"], $row["playerWeight"]);
			}
		} catch(\Exception $exception) {
			// if the row couldnt be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($player);
	}

	/**
	 * gets the player by playerUserId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $playerUserId player user id to search for
	 * @return player|null player found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPlayerByPlayerUserId(\PDO $pdo, int $playerUserId) {
		// sanitixe the player user id before searching
		if($playerUserId <= 0) {
			throw(new \PDOException("player user id is not positive"));
		}

		// create query template
		$query = "SELECT playerId, playerUserId, playerBatting, playerCommitment, playerFirstName, playerHealthStatus, playerHeight, playerHomeTown, playerLastName, playerPosition, playerThrowingHand, playerUpdate, playerWeight FROM player WHERE playerUserId = :playerUserId";
		$statement = $pdo->prepare($query);

		// bind the player user id to the place holder in the template
		$parameters = array("playerUserId" => $playerUserId);
		$statement->execute($parameters);

		// grab the player from mySQL
		try {
			$player = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$player = new Player($row["playerId"], $row["playerUserId"], $row["playerBatting"], $row["playerCommitment"], $row["playerFirstName"], $row["playerHealthStatus"], $row["playerHeight"], $row["playerHomeTown"], $row["playerLastName"], $row["playerPosition"], $row["playerThrowingHand"], $row["playerUpdate"], $row["playerWeight"]);
			}
		} catch(\Exception $exception) {
			// if the row couldnt be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($player);
	}

	/**
	 * gets the player by playerBatting
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $playerBatting player batting to search for
	 * @return player|null player found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPlayerByPlayerBatting(\PDO $pdo, int $playerBatting) {
		// sanitixe the player batting before searching
		if($playerBatting <= 0) {
			throw(new \PDOException("player batting is not positive"));
		}

		// create query template
		$query = "SELECT playerId, playerUserId, playerBatting, playerCommitment, playerFirstName, playerHealthStatus, playerHeight, playerHomeTown, playerLastName, playerPosition, playerThrowingHand, playerUpdate, playerWeight FROM player WHERE playerBatting = :playerBatting";
		$statement = $pdo->prepare($query);

		// bind the player batting to the place holder in the template
		$parameters = array("playerBatting" => $playerBatting);
		$statement->execute($parameters);

		// grab the player from mySQL
		try {
			$player = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$player = new Player($row["playerId"], $row["playerUserId"], $row["playerBatting"], $row["playerCommitment"], $row["playerFirstName"], $row["playerHealthStatus"], $row["playerHeight"], $row["playerHomeTown"], $row["playerLastName"], $row["playerPosition"], $row["playerThrowingHand"], $row["playerUpdate"], $row["playerWeight"]);
			}
		} catch(\Exception $exception) {
			// if the row couldnt be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($player);
	}

	/**
	 * gets the player by playerHeight
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $playerHeight player height to search for
	 * @return player|null player found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPlayerByPlayerHeight(\PDO $pdo, int $playerHeight) {
		// sanitixe the player height before searching
		if($playerHeight <= 0) {
			throw(new \PDOException("player height is not positive"));
		}

		// create query template
		$query = "SELECT playerId, playerUserId, playerBatting, playerCommitment, playerFirstName, playerHealthStatus, playerHeight, playerHomeTown, playerLastName, playerPosition, playerThrowingHand, playerUpdate, playerWeight FROM player WHERE playerHeight = :playerHeight";
		$statement = $pdo->prepare($query);

		// bind the player height to the place holder in the template
		$parameters = array("playerHeight" => $playerHeight);
		$statement->execute($parameters);

		// grab the player from mySQL
		try {
			$player = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$player = new Player($row["playerId"], $row["playerUserId"], $row["playerBatting"], $row["playerCommitment"], $row["playerFirstName"], $row["playerHealthStatus"], $row["playerHeight"], $row["playerHomeTown"], $row["playerLastName"], $row["playerPosition"], $row["playerThrowingHand"], $row["playerUpdate"], $row["playerWeight"]);
			}
		} catch(\Exception $exception) {
			// if the row couldnt be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($player);
	}

	/**
	 * gets the player by playerWeight
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $playerWeight player weight to search for
	 * @return player|null player found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPlayerByPlayerWeight(\PDO $pdo, int $playerWeight) {
		// sanitixe the player weight before searching
		if($playerWeight <= 0) {
			throw(new \PDOException("player weight is not positive"));
		}

		// create query template
		$query = "SELECT playerId, playerUserId, playerBatting, playerCommitment, playerFirstName, playerHealthStatus, playerHeight, playerHomeTown, playerLastName, playerPosition, playerThrowingHand, playerUpdate, playerWeight FROM player WHERE playerWeight = :playerWeight";
		$statement = $pdo->prepare($query);

		// bind the player weight to the place holder in the template
		$parameters = array("playerWeight" => $playerWeight);
		$statement->execute($parameters);

		// grab the player from mySQL
		try {
			$player = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$player = new Player($row["playerId"], $row["playerUserId"], $row["playerBatting"], $row["playerCommitment"], $row["playerFirstName"], $row["playerHealthStatus"], $row["playerHeight"], $row["playerHomeTown"], $row["playerLastName"], $row["playerPosition"], $row["playerThrowingHand"], $row["playerUpdate"], $row["playerWeight"]);
			}
		} catch(\Exception $exception) {
			// if the row couldnt be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($player);
	}

	/**
	 *formats the state variables for jSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
}