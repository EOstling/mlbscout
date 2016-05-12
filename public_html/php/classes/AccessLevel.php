<?php
namespace Edu\Cnm\MlbScout;


require_once ("autoload.php");
/**
 * access level class for MLB scout Capstone
 *
 * @author Jared Padilla <jaredpadilla16@gmail.com>
 */
class AccessLevel implements \JsonSerializable {
	/*
	 * access level id for user; this is the primary key
	 * @var int $accessLevelId
	 */
	private $accessLevelId;

	/**
	 * access level set for user
	 * @var string $accessLevelName
	 */
	private $accessLevelName;

	/**
	 * constructor for this AccessLevel
	 *
	 * @param int $newAccessLevelId new value of access level id
	 * @param string $newAccessLevelName new value of access level name
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function _construct(int $newAccessLevelId, string $newAccessLevelName) {
		try {
			$this->setAccessLevelId($newAccessLevelId);
			$this->setAccessLevelName($newAccessLevelName);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			//rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0. $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}

}
	/**
	 * accessor method for access level id
	 *
	 * @return int value of access level id
	 */
	public function getAccessLevelId() {
		return $this->accessLevelId;
	}
	
	/**
	 * mutator method for access level id
	 *
	 * @param int $newAccessLevelId new value of access level id
	 * @throws \RangeException if $newAccessLevelId
	 * @throws \TypeError if $newAccessLevelId is not an integer
	 */
	public function setAccessLevelId($newAccessLevelId) {
		// verify the access level id is positive
		if($newAccessLevelId <=0) {
			throw(new \RangeException("access level is is not positive"));
		}

		//convert and store the access level id
		$this->accessLevelId = $newAccessLevelId;
	}
	
	/**
	 * accessor method for access level name
	 *
	 * @return string value of access level name
	 */
	public function getAccessLevelName() {
		return $this->accessLevelName;
	}
	
	/**
	 * mutator method for access level name
	 *
	 * @param string $newAccessLevelName new value of access level name
	 * @throws \InvalidArgumentException if $newAccessLevelName is not a string or insecure
	 * @throws \RangeException if $newAccessLevelName is > 24 characters
	 * @throws \TypeError if $newAccessLevelName is not a string
	 */
	public function setAccessLevelName($newAccessLevelName) {
		// verify the access level name is secure
		$newAccessLevelName = trim ($newAccessLevelName);
		$newAccessLevelName = filter_var($newAccessLevelName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAccessLevelName) === true) {
			throw(new \InvalidArgumentException("access level name is empty or insecure"));

		}

		// verify the access level name will fit in the database
		if(strlen($newAccessLevelName) > 24) {
			throw(new \RangeException("access level name is too large"));
		}

		// store the access level name
		$this->accessLevelName = $newAccessLevelName;
	}
	
	/**
	 * inserts this access level into mySQL
	 * 
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		//enforce the access level id is null
		if($this->accessLevelId !== null) {
			throw(new \PDOException("not a new access level id"));
		}

		// create query template
		$query = "INSER INTO accessLevel(accessLevelName) VALUES(:accessLevelName)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["accessLevelName" => $this->accessLevelName];
		$statement->execute($parameters);

		//update the null accessLevelId with what mySQL just game us
		$this->accessLevelId = intval($pdo->lastInsertId());
	}

		/**
		 * deletes this Access Level from mySQL
		 *
		 * @param \PDO $pdo PDO connection object
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError if $pdo is not a PDO connection object
		 */
	public function delete(\PDO $pdo) {
		// enforce the accessLevelId is not null
		if($this->accessLevelId === null) {
			throw(new \PDOException("unable to delete a access level that does not exist"));
		}

		// create query template
		$query = "DELETE FROM accessLevel WHERE accessLevelId = :accessLevelId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["accessLevelId" => $this->accessLevelId];
		$statement->execute($parameters);
	}

	/**
	 * updates this AccessLevel from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) {
		//enforce the accessLevelId is not null
		if($this->accessLevelId === null) {
			throw(new \PDOException("unable to delete a access level that does not exist"));
		}

		// create query template
		$query = "UPDATE accessLevel SET accessLevelName = :accessLevelName WHERE accessLevelId = accessLevelId";
		$statement = $pdo->prepare($query);

		// bind the membe variables to the place holdes in the template
		$parameters = ["accessLevelName =>$this->accessLevelName, accessLevelId => $this->accessLevelId"];
		$statement->execute($parameters);
	}

	/**
	 * gets the Access Level by accessLevelId
	 * 
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param int $accessLevelId access level id to search for
	 * @return AccessLevel|null AccessLevel found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getAccessLevelByAccessLevelId (\PDO $pdo, int $accessLevelId) {
	// sanitize the access level id before searaching
		if($accessLevelId <=0) {
			throw(new \PDOException("access level id is not positive"));
		}

		// create query template
		$query = "SELECT accessLevelId, accessLevelName from accessLevel WHERE accessLevelId = :accessLevelId";
		$statement = $pdo->prepare($query);

		// bind the access level id to the place holder in the template
		$parameters = array("accessLevelId" => $accessLevelId);
		$statement ->execute($parameters);

		// grab the AccessLevel from mySQL
		try {
			$accessLevel = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !==false) {
				$accessLevel = new AccessLevel($row["accessLevelId"],$row["accessLevelName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($accessLevel);
}
	/**
	 * gets the AccessLevel by accessLevelName
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $accessLevelName access level name to search for
	 * @return \SplFixedArray SplFixedArray of AccessLevels found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getAccessLevelByAccessLevelName(\PDO $pdo, string $accessLevelName) {
		// sanitize the description before searching
		$accessLevelName = trim($accessLevelName);
		$accessLevelName = filter_var($accessLevelName, FILTER_SANITIZE_STRING);
		if(empty($accessLevelName) === true) {
			throw(new \PDOException("access level name is invalid"));
		}

		// create query template
		$query = "SELECT accessLevelId, accessLevelName FROM AccessLevel WHERE accessLevelName LIKE :accessLevelName";
		$statement = $pdo->prepare($query);

		//bind the access level name to the place holder in the template
		$accessLevelName = "%$accessLevelName%";
		$paramaters = array("accessLevelName" => $accessLevelName);
		$statement->execute($paramaters);

		//build an array of access levels
		$accessLevels = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$accessLevel = new AccessLevel($row["accessLevelId"], $row["accessLevelName"]);
				$accessLevels[$accessLevels->key()] = $accessLevel;
				$accessLevels->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($accessLevels);
	}

	/**
	 * gets all Access Levels
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of AccessLevels found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getAllAccessLevels(\PDO $pdo) {
		// create query template
		$query = "SELECT accessLevelId, AccessLevelName FROM AccessLevel";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of Access Levels
		$accessLevels = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$accessLevel = new AccessLevel($row["accessLevelId"], $row["accessLevelName"]);
				$accessLevels[$accessLevels->key()] = $accessLevel;
				$accessLevels->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($accessLevels);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}

}