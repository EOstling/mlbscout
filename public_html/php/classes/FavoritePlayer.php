<?php
namespace Edu\Cnm\MlbScout;

require_once("autoload.php");

/**
 * Favorite Player Class
 *
 * Favorite Player Class is the combination of two foreign keys; favoritePlayerFavoritePlayerPlayerId and favoritePlayerUserId
 * @author Francisco Garcia <fgarcia132@cnm.edu>
 * @version 2.0.0
 **/
class FavoritePlayer implements \JsonSerializable {
	/**
	 * id for the user that favorited the player; this is a foreign key
	 * @var int $favoritePlayerUserId
	 **/
	private $favoritePlayerUserId;
	/**
	 * id for the player that was favorited; this is a foreign key
	 * @var int $favoritePlayerFavoritePlayerPlayerId
	 **/
	private $favoritePlayerPlayerId;

	/**
	 * constructor for this favoritePlayer
	 * @param int $newFavoritePlayerUserId  id of the User that favorited the player
	 * @param int $newFavoritePlayerPlayerId id of the player that was favorited
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newFavoritePlayerPlayerId = null, int $newFavoritePlayerUserId = null) {
		// use the mutators to do the work for us
		try {
			$this->setFavoritePlayerPlayerId($newFavoritePlayerPlayerId);
			$this->setFavoritePlayerUserId($newFavoritePlayerUserId);
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
	 * accessor method for favorite player player id
	 *
	 * @return int value of favorite player player id
	 **/
	public function getFavoritePlayerPlayerId() {
		return ($this->favoritePlayerPlayerId);
	}

	/**
	 * mutator method for favorite player player id
	 *
	 * @param int $newFavoritePlayerPlayerId new value of player id
	 * @throws \RangeException if $newFavoritePlayerPlayerId is not positive
	 * @throws \TypeError if $newFavoritePlayerPlayerId is not an integer
	 **/
	public function setFavoritePlayerPlayerId(int $newFavoritePlayerPlayerId) {
		// verify the player id is positive
		if($newFavoritePlayerPlayerId <= 0) {
			throw(new \RangeException("favorite player player id is not positive"));
		}

		// convert and store the player id
		$this->favoritePlayerPlayerId = $newFavoritePlayerPlayerId;
        }

	/**
	 * accessor method for favorite player user id
	 *
	 * @return int value of favorite player user id
	 **/
	public function getFavoritePlayerUserId() {
		return ($this->favoritePlayerUserId);
	}

	/**
	 * mutator method for favorite player user id
	 *
	 * @param int $newFavoritePlayerUserId
	 * @throws \RangeException if $newFavoritePlayerUserId is not positive
	 * @throws \TypeError if $newFavoritePlayerUserId is not an integer
	 **/
	public function setFavoritePlayerUserId(int $newFavoritePlayerUserId) {
		// verify the user id is positive
		if($newFavoritePlayerUserId <= 0) {
			throw(new \RangeException("user id is not positive"));
		}

		// convert and store the user id
		$this->favoritePlayerUserId = $newFavoritePlayerUserId;
	}

	/**
	 * inserts this FavoritePlayer into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// ensure the object exists before inserting
		if($this->favoritePlayerUserId === null || $this->favoritePlayerPlayerId === null) {
			throw(new \PDOException("not a valid favorite"));
		}

		// create query template
		$query = "INSERT INTO favoritePlayer(favoritePlayerUserId, favoritePlayerPlayerId) VALUES(:favoritePlayerUserId, :favoritePlayerPlayerId)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["favoritePlayerUserId" => $this->favoritePlayerUserId, "favoritePlayerPlayerId" => $this->favoritePlayerPlayerId];
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
		if($this->favoritePlayerUserId === null || $this->favoritePlayerPlayerId === null) {
			throw(new \PDOException("not a valid favorite"));
		}

		// create query template
		$query = "DELETE FROM favoritePlayer WHERE favoritePlayerUserId = :favoritePlayerUserId AND favoritePlayerPlayerId = :favoritePlayerPlayerId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["favoritePlayerUserId" => $this->favoritePlayerUserId, "favoritePlayerPlayerId" => $this->favoritePlayerPlayerId];
		$statement->execute($parameters);
	}

	/**
	 * gets the Favorite by favorite player player id and favorite player user id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoritePlayerPlayerId favorite player player id to search for
	 * @param int $favoritePlayerUserId favorite player user id to search for
	 * @return FavoritePlayer|null Favorite found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFavoritePlayerByFavoritePlayerPlayerIdAndFavoritePlayerUserId(\PDO $pdo, int $favoritePlayerPlayerId, int $favoritePlayerUserId) {
            // sanitize the player id and user id before searching
            if($favoritePlayerPlayerId <= 0) {
                throw(new \PDOException("player id is not positive"));
            }
				if($favoritePlayerUserId <= 0) {
						throw(new \PDOException("user id is not positive"));
}

	// create query template
	$query = "SELECT favoritePlayerPlayerId, favoritePlayerUserId FROM favoritePlayer WHERE favoritePlayerPlayerId = :favoritePlayerPlayerId AND favoritePlayerUserId = :favoritePlayerUserId";
	$statement = $pdo->prepare($query);

	// bind the player id and user id to the place holder in the template
	$parameters = ["favoritePlayerPlayerId" => $favoritePlayerPlayerId, "favoritePlayerUserId" => $favoritePlayerUserId];
	$statement->execute($parameters);

	// grab the favoritePlayer from mySQL
	try {
		$favoritePlayer = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$favoritePlayer = new FavoritePlayer($row["favoritePlayerPlayerId"], $row["favoritePlayerUserId"]);
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
	 * @param int $favoritePlayerUserId user id to search for
	 * @return \SplFixedArray SplFixedArray of FavoritePlayers found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct type
	 **/
	public static function getFavoritePlayerPlayerUserId(\PDO $pdo, int $favoritePlayerUserId) {
		// sanitize the user id
		if($favoritePlayerUserId < 0) {
			throw(new \PDOException("user id is not positive"));
		}

		// create query template
		$query = "SELECT favoritePlayerUserId, favoritePlayerPlayerId FROM favoritePlayer WHERE favoritePlayerUserId = :favoritePlayerUserId";
		$statement = $pdo->prepare($query);

		// bind the member variable to the place holder in the template
		$parameters = ["favoritePlayerUserId" => $favoritePlayerUserId];
		$statement->execute($parameters);

		// build an array of FavoritePlayers
		$favoritePlayers = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favoritePlayer = new FavoritePlayer($row["favoritePlayerPlayerId"], $row["favoritePlayerUserId"]);
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
 * gets the FavoritePlayer by favorite player player id
 *
 * @param \PDO $pdo PDO connection object
 * @param int $favoritePlayerPlayerId player id to search for
 * @return \SplFixedArray array of FavoritePlayers found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getFavoritePlayerByFavoritePlayerPlayerId(\PDO $pdo, int $favoritePlayerPlayerId) {
	// sanitize the player id
	if($favoritePlayerPlayerId <= 0) {
		throw(new \PDOException("player id is not positive"));
	}

	// create query template
	$query = "SELECT favoritePlayerUserId, favoritePlayerPlayerId FROM favoritePlayer WHERE favoritePlayerPlayerId = :favoritePlayerPlayerId";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holders in the template
	$parameters = ["favoritePlayerPlayerId" => $favoritePlayerPlayerId];
	$statement->execute($parameters);

	// build an array of favoritePlayers
	$favoritePlayers = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$favoritePlayer = new FavoritePlayer($row["favoritePlayerPlayerId"], $row["favoritePlayerUserId"]);
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
