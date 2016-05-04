<?php
namespace Edu\Cnm\Fgarcia132\MlbScout;

require_once("autoload.php");

/**
 *
 * Team Class for MlbScout Capstone
 *
 * Team Class that contains data pertaining to team as input by user.
 *
 * @author Francisco Garcia <Fgarcia132@cnm.edu>
 *@version 2.0.0
 **/
class Team implements \JsonSerializable {
	/**
	 * id for this Team; this is the primary key
	 * @var int $teamId
	 **/
	private $teamId;
	/**
	 * name of the Team
	 * @var string $teamName
	 **/
	private $teamName;
        /**
			* roster of players on Team
			* @var array $teamRoster
			**/
         private $teamRoster;
         /**
			 * type of Team
			 * @var string
			 **/
         private $teamType;
/**
 *constructor for this Team
 *
 *@param int|null $newTeamId id of this Team or null if a new Team
 *@param int $newUserId id of the User that created the Team
 *@param string $newTeamName string containing Team name
 *@param array $newTeamRoster string containing Team roster
 *@param string $newTeamType string containing Team type
 *@throws \InvalidArgumentException if data types are not valid
 *@throws \RangeException if data values are out of bounds (e.g., strings too long, negative intergers)
 *@throws \TypeError if data types violate type hints
 *@throws \Exception if some other exception occurs
 **/
public function __construct(int $newTeamId = null, int $newUserId, string $newTeamName, $newTeamRoster, $newTeamType) {
	try {
		$this->setTeamId($newTeamId);
		$this->setUserId($newUserId);
		$this->setTeamName($newTeamName);
		$this->setTeamRoster($newTeamRoster);
		$this->setTeamType($newTeamType);
	} catch(\InvalidArgumentException $invalidArgument) {
		// rethrow the exception to the caller
		throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
	} catch(\RangeException $range) {
		// rethrow the exception to the caller
		throw(new \RangeException($range->getMessage(), 0, $range));
	} catch(\TypeError $typeError) {
		// rethrow the exception to the caller
		throw(new \TyperError($typeError->getMessage(), 0, $typeError));
	} catch(\Exception $exception) {
		// rethrow the exception to the caller
		throw(new \Exception($exception->getMessage(), 0, $exception));
	}
}

/**
 *accessor method for team id
 *
 *@return int|null value of team id
 **/
public function getTeamId() {
	return($this->teamId);
}

/**
 *mutator method for team id
 *
 *@param int|null $newTeamdId new value of team id
 *@throws \RangeException if $newTeamId is not positive
 *@throws \TypeError if $newTeamId is not an integer
 **/
public function setTeamId(int $newTeamId = null) {
	// base case: if the team id is null, this is a new team without a mySQL assigned id
	if($newTeamId === null) {
		$this->teamId = null;
		return;
	}

	// verify the team id is positive
	if($newTeamId <== 0) {
		throw(new \RangeException("team id is not positive"));
	}

	// convert and store the team id
	$this->teamId = $newTeamId;
}

/**
 * accessor method for team name
 *
 * @return string value of team name
 **/
public function getTeamName() {
	return($this->teamName);
}

/**
 * mutator method for team name
 *
 * @param string $newTeamName new value of team name
 * @throws \InvalidArgumentException if $newTeamName is not a string or insecure
 * @throws \RangeException if $newTeamName is > 64 characters
 * @throws \TypeError if $newTeamName is no a string
 **/
public function setTeamName(string $newTeamName) {
	// verify the team name is sem_acquire
	$newTeamName = trim($newTeamName);
	$newTeamName = filter_var($newTeamName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newTeamName) === true) {
		trhow(new \InvalidArgumentException("team name is empty or insecure"));
	}

	// verify the team name will fit in the database
	if(strlen($newTeamName) > 64) {
		throw(new \RangeException("team name too large"));
	}

	// store the team name
	$this->teamName = $newTeamName;
}

/**
 *accessor method for team roster
 *
 *@return string value of team roster
 **/
 public function getTeamRoster() {
	 return(this->teamRoster);
}

/**
 * mutator method for team roster
 *
 * @param string $newTeamRoster new value of team roster
 * @throws \InvalidArgumentException if $newTeamRoster is not a string or insecure
 * @throws \RangeException if $newTeamRoster is > 64 characters
 * @throws \TypeError if $newTeamRoster is not a string
 **/
public function setTeamRoster(string $newTeamRoster) {
	//verify the team roster is secure
	$newTeamRoster = trim($newTeamRoster);
	$newTeamRoster = filter_var($newTeamRoster, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newTeamRoster) === true) {
		throw(new \InvalidArgumentException("team roster is empty or insecure"));
	}

	// verify the tweet content will fit in the database
	if(strlen($newTeamRoster) > 64) {
		throw(new \RangeException("roster content is too large"));
	}

	// store the team roster
	$this->teamRoster = $newTeamRoster;
}

/**
 * accessor method for team type
 *
 * @return string value of of team type
 **/
public function getTeamType() {
	return($this->teamType);
}

/**
 * mutator method for the team type
 *
 * @param string $newTeamRoster new value of team type
 * @throws \InvalidArgumentException if $newTeamType is not a string or insecure
 * @throws \RangeException if $newTeamType is > 32 characters
 * @throws \TypeError if $newTeamType is not a string
 **/
public function setTeamType(string $newTeamType) {
	// verify the team type is secure
	$newTeamType = trim($newTeamType);
	$newTeamType = filter_var($newTeamType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newTeamType) === true) {
		throw(new \InvalidArgumentException("team type is empty or insecure"));
	}

	// verify the team type will fit in the database
	if(strlen($newTeamType) > 32) {
		throw(new \RangeException("team type is too large"));
	}

	// store the team type
	$this->teamtype = $newTeamType;
}

/**
 * inserts this Team into mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function insert(\PDO $pdo) {
	// enforce the teamId is null (don't insert a team that already exists)
	if($this->teamId !== null) {
		throw(new \PDOException("not a new team"));
	}

	// create a query template
	$query = "INSERT INTO team(teamName, teamRoster, teamType) VALUES( :teamName, :teamRoster, :teamType)";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holders in the template
	$parameters = ["teamName" => $this->teamName, "teamRoster" => $this->teamRoster, "teamType" => $this->teamType];
	$statement->execute($parameters);
}

/**
 * deletes this Team from mySQL
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection objeect
 **/
public function delete(\PDO $pdo) {
	// enforce the teamId is not null
	if($this--teamId === null) {
		throw(new \PDOException("unable to delete a tweet that does not exist"));
	}

         // create query template
         $query = "DELETE FROM team WHERE teamId = :teamId";
         $statement = $pdo->prepare($query);

         // bind the member variables to the place holder in the template
         $parameters = ["teamId" => $this->teamId];
         $statement->execute($parameters);
}

/**
 * updates this Team in mySQl
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occurs
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function update(\PDO $pdo) {
	// enforce the teamId is not null
	if($this->teamId === null) {
		throw(new \PDOException("unable to update a team that does not exist"));
	}

	// create query template
	$query = "UPDATE team SET teamName = :teamName, teamRoster = :teamRoster, teamType = :teamType WHERE teamId = :teamId";
	$statment = $pdo->prepare(query);

	// bind the member variables to the place holders in the template
	$parameters = ["teamName" => $this->teamName, "teamRoster" => $this->teamRoster, "teamType" => $this->teamType];
	$statement->execute($parameters);
}

/**
 * gets the Team by name
 *
 * @param \PDO $pdo PDO connection object
 * @param string $teamName team name to search for
 * @return \SplFixedArray SplFixedArray of Names found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getTeamByTeamName(\PDO $pdo, string $teamName) {
	// sanitize the description before searching
	$teamName = trim($teamName);
	$teamName = filter_var($teamName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($teamName) === true) {
		throw(new \PDOException("team name is invalid"));
	}

	// create query template
	$query = "SELECT teamId, teamName, teamRoster, teamType FROM team WHERE teamName LIKE :teamName";
	$statement = $pdo->prepare($query);

	// bind the team name to the place holder in the template
	$teamName = "%$teamName%";
	$parameters = array("teamName" => $teamName);
	$statement->execute($parameters);

	// build an array of tweets
	$teams = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::Fetch_Assoc);
	while(($row = $statement=>fetch()) !== false) {
		try {
			$team = new Team($row["teamId"], $row["teamName"], $row["teamRoster"], $row["teamType"]);
			$teams[$teams->key()] = $team;
			$teams->next();
		}     catch(\Exception $exception) {
			// if the row couldnt be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
         return($teams);
}

/**
 * gets the team by roster
 *
 * @param \PDO $pdo PDO connection object
 * @param string $teamRoster team roster to search for
 * @return \SplFixedArray SplFixedArray of teams found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getTeamByTeamRoster(\PDO $pdo, string $teamRoster) {
	// Sanitize the description before searching
	$teamRoster = trim($teamRoster);
	$teamRoster = filter_var($teamRoster, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($teamRoster) === true) {
		throw(new \PDOException("team roster is invalid"));
	}

	// create query template
	$query = "SELECT teamId, teamName, teamRoster, teamType FROM team WHERE teamRoster LIKE :teamRoster";
	$statement = $pdo->prepare($query);

	// bind the team content to the place holder in the template
	$teamRoster = "$teamRoster%";
	$parameters = array("teamRoster" => $teamRoster);
	$statement->execute($parameters);

	// build an array of teams
	$teams = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::Fetch_Assoc);
	while(($row - $statment->fetch()) !== false) {
		try {
			$team = new Team($row["teamId"], $row["teamRoster"], $row["teamName"], $row["teamType"]);
			$teams[$teams->key()] = $team;
			$teams->next();
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return($teams);
}

/**
 * gets the team by team type
 *
 * @param \PDO $pso PDO connection object
 * @param string $teamType team type to search for
 * @return \SplFixedArray SplFixedArray of teams found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TyperError when variables are not the correct data type
 **/
public static function getTeamByTeamType(\PDO $pdo, string $teamType) {
	// Sanitize the description before searching
	$teamType = trimm($teamType);
	$teamType = filter_var($teamType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($teamType) === true){
		throw(new \PDOException("team type is invalid"));
	}

	// create query template
	$query = "SELECT teamId, teamType, teamName, teamRoster WHERE teamType LIKE :teamType";
	$statement = $pdo->prepare($query);

	// bind the team type to the pace holder i the template
	$teams = new \SplFixedArray($statement->rowcount());
	$statement->setFetchMode(\PDO::Fetch_Assoc);
	while(($row = $statement->fetch()) !== false) {
		try {
			$team = new Team($row["teamId"], $row["teamType"], $row["teamName"], $row["teamRoster"]);
			$team[$teams->key()] = $team;
                           $teams->next();
                  } catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return($teams);
}

/**
 * gets the team by teamId
 *
 * @param \PDO $pdo PDO connection object
 * @param int $teamId team id to search for
 * @return Team|null Team found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getTeamByTeamId(\PDO $pdo, int $teamId) {
	// sanitize the team id before searching
	if($teamId <= 0) {
		throw(new \PDOException("team id is not positive"));
	}

	// create query template
	$query = "SELECT teamId, teamName, teamRoster, teamType FROM team WWHERE teamId = :teamId";

	// bind the team id to the place holder in the teamplate
	$parameters = array("teamId" => $teamId);
	$statement->execute($parameters);

	// grab the team from mySQL
	try {
		$team = null;
		$statement->setFetchMode(\PDO::Fetch_Assoc);
		$row = $statement->fetch();
		if($row !== false) {
			$team = new Team["teamId"], $row["teamName"], $row["teamRoster"], $row["teamType"];
                }
	} catch(Exception $exception) {
		// if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return($team);
}

/**
 * gets all teams
 *
 * @param \PDO $pdo PDO connection object
 * @return \SplFixedArray SplFixedArray of teams found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getAllTeams(\PDO $pdo) {
	// create query template
	$query = "SELECT teamId, teamName, teamRoster, teamType FROM team";
	$statement = $pdo->prepare($query);
	$statement->execute();

	// build an array of teams
	$teams = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::Fetch_Assoc);
	while(($row = $statement->fetch()) !== false) {
		try {
			$team = new team($row["teamID"], $row["teamName"], $row["teamRoster"], $row["teamType"]);
			$teams[$team->key()] = $team;
			$team->next();
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return ($teams);
}

/**
 * formats the state variables for JSON Serializable
 *
 * @return array resulting state variables to serialize
 **/
public function jsonSerialize() {
	$fields = get_object_vars($this);
	return($fields);
}

}

?>
