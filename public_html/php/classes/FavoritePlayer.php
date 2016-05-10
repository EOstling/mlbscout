<?php
namespace Edu\Cnm\MlbScout;

require_once("autoload.php");

/**
 * Favorite Player Class
 *
 * Favorite Player Class is the combination of two foreign keys; playerId and userId
 * @author Francisco Garcia <fgarcia132@cnm.edu>
 * @version 2.0.0
 **/
class FavoritePlayer implements \JsonSerializable {
	/**
	 * id for the user that favorited the player; this is a foreign key
	 * @var int $userId
	 **/
	private $userId;
	/**
	 * id for the player that was favorited; this is a foreign key
	 * @var int $playerId
	 **/
	private $playerId;

	/**
	 * constructor for this favoritePlayer
	 * @param int $newUserId  id of the User that favorited the player
	 * @param int $newPlayerId id of the player that was favorited
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newPlayerId = null, int $newUserId = null) {
		// use the mutators to do the work for us
		try {
			$this->setPlayerId($newPlayerId);
			$this->setUserId($newUserId);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception at the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for player id
	 *
	 * @return int value of player id
	 **/
	public function getPlayerId() {
		return ($this->playerId);
	}

	/**
	 * mutator method for player id
	 *
	 * @param int $newPlayerId new value of player id
	 * @throws \RangeException if $newPlayerId is not positive
	 * @throws \TypeError if $newPlayerId is not an integer
	 **/
	public function setPlayerId(int $newPlayerId) {
		// verify the player id is positive
		if($newPlayerId <= 0) {
			throw(new \RangeException("player id is not positive"));
		}

		// convert and store the player id
		$this->playerId = $newPlayerId;
        }

	/**
	 * accessor method for user id
	 *
	 * @return int value of user id
	 **/
	public function getUserId() {
		return ($this->userId);
	}

	/**
	 * mutator method for user id
	 *
	 * @param int $newUserId
	 * @throws \RangeException if $newUserId is not positive
	 * @throws \TypeError if $newUserId is not an integer
	 **/
	public function setUserId(int $newUserId) {
		// verify the user id is positive
		if($newUserId <= 0) {
			throw(new \RangeException("user id is not positive"));
		}

		// convert and store the user id
		$this->userId = $newUserId;
	}

	/**
	 * inserts this FavoritePlayer into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// ensure the object exists before inserting
		if($this->userId === null || $this->playerId === null) {
			throw(new \PDOException("not a valid favorite"));
		}

		// create query template
		$query = "INSERT INTO favoritePlayer(userId, playerId) VALUES(:userId, :playerId)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["userId" => $this->userId, "playerId" => $this->playerId];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Favorite from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
		// ensure the object exists before deleting
		if($this->userId === null || $this->playerId === null) {
			throw(new \PDOException("not a valid favorite"));
		}

		// create query template
		$query = "DELETE FROM favoritePlayer WHERE userId = :userId AND playerId = :playerId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["userId" => $this->userId, "playerId" => $this->playerId];
		$statement->execute($parameters);
	}

	/**
	 * gets the Favorite by player id and user id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $playerId player id to search for
	 * @param int $userId user id to search for
	 * @return FavoritePlayer|null Favorite found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFavoritePlayerByPlayerIdAndUserId(\PDO $pdo, int $playerId, int $userId) {
            // sanitize the player id and user id before searching
            if($playerId <= 0) {
                throw(new \PDOException("player id is not positive"));
            }
				if($userId <= 0) {
						throw(new \PDOException("user id is not positive"));
}

	// create query template
	$query = "SELECT playerId, userId FROM favoritePlayer WHERE playerId = :playerId AND userId = :userId";
	$statement = $pdo->prepare($query);

	// bind the player id and user id to the place holder in the template
	$parameters = ["playerId" => $playerId, "userId" => $userId];
	$statement->execute($parameters);

	// grab the favoritePlayer from mySQL
	try {
		$favoritePlayer = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$favoritePlayer = new FavoritePlayer($row["playerId"], $row["userId"]);
		}
	} catch(\Exception $exception) {
		// if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return($favoritePlayer);
	}

	/**
	 * gets the FavoritePlayer by user id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $userId user id to search for
	 * @return \SplFixedArray SplFixedArray of FavoritePlayers found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct type
	 **/
	public static function getFavoritePlayerByUserId(\PDO $pdo, int $userId) {
		// sanitize the user id
		if($userId < 0) {
			throw(new \PDOException("user id is not positive"));
		}

		// create query template
		$query = "SELECT userId, playerId FROM favoritePlayer WHERE userId = :userId";
		$statement = $pdo->prepare($query);

		// bind the member variable to the place holder in the template
		$parameters = ["userId" => $userId];
		$statement->execute($parameters);

		// build an array of FavoritePlayers
		$favoritePlayers = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favoritePlayer = new FavoritePlayer($row["playerId"], $row["userId"]);
				$favoritePlayers[$favoritePlayers->key()] = $favoritePlayer;
				$favoritePlayers->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($favoritePlayers);
	}

/**
 * gets the FavoritePlayer by player id
 *
 * @param \PDO $pdo PDO connection object
 * @param int $playerId player id to search for
 * @return \SplFixedArray array of FavoritePlayers found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getFavoritePlayerByPlayerId(\PDO $pdo, int $playerId) {
	// sanitize the player id
	if($playerId <= 0) {
		throw(new \PDOException("player id is not positive"));
	}

	// create query template
	$query = "SELECT userId, playerId FROM favoritePlayer WHERE playerId = :playerId";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holders in the template
	$parameters = ["playerId" => $playerId];
	$statement->execute($parameters);

	// build an array of favoritePlayers
	$favoritePlayers = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$favoritePlayer = new FavoritePlayer($row["playerId"], $row["userId"]);
			$favoritePlayers[$favoritePlayers->key()] = $favoritePlayer;
			$favoritePlayers->next();
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return($favoritePlayers);
}

/**
 * formats the state variables for JSON Serializable
 *
 * @return array resulting state variable to serialize
 **/
public function jsonSerialize() {
	$fields = get_object_vars($this);
	return($fields);
}
}

?>
