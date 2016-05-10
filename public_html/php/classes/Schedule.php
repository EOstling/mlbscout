<?php
namespace Edu\Cnm\Llaudick\MlbScout;

require_once("autoload.php");

/**
 *
 *
 * @author Lucas Laudick
 **/
class Schedule implements \JsonSerializable {
	use \Edu\Cnm\MlbScout\ValidateDate;
	/**
	 * id for this schedule; this is the primary key
	 * @var int $scheduleId
	 **/
	private $scheduleId;
	/**
	 * id of the team that has the schedule; this is the foreign key
	 * @var int $scheduleTeamId
	 **/
	private $scheduleTeamId;
	/**
	 * this is the location of the game being played
	 * @var string $scheduleLocation
	 **/
	private $scheduleLocation;
	/**
	 * this is the list of starting players
	 * @var string $scheduleStartingPosition
	 **/
	private $scheduleStartingPosition;
	/**
	 * date and time the games will be played
	 * @var \DateTime $scheduleTime
	 **/
	private $scheduleTime;

	/**
	 * constructor for the schedule
	 *
	 * @param int|Null $newSchduleId id of this schedule or null if new schedule
	 * @param int $newScheudleTeamId id of the schedule team that sent the schedule
	 * @param string $scheduleLocation string containing loaction of game
	 * @param string $scheduleStartingPosition string containing starting position of the players
	 * @param \DateTime|string|null $newScheduletime date and time of the game or null if set to current time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (too long, negative...)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other excpetions occur
	 **/
	public function __construct(int $newScheduleId = null, int $newScheduleTeamId, string $newScheduleLocation, string $newScheduleStartingPosition, $newScheduleTime = null) {
		try {
			$this->setScheduleId($newScheduleId);
			$this->setScheduleTeamId($newScheduleTeamId);
			$this->setScheduleLocation($newScheduleLocation);
			$this->setScheduleStartingPosition($newScheduleStartingPosition);
			$this->setScheduleTime($newScheduleTime);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $excepion) {
			// rethrow the exception to the caller
			throw(new \Exception($excepion->getMessage(), 0, $excepion));
		}
	}

	/**
	 * accessor method for schedule id
	 *
	 * @return int|null value of schedule id
	 **/
	public function getScheduleId() {
		return($this->scheduleId);
	}

	/**
	 * mutator method for schedule id
	 *
	 * @param int|null $newScheduleId new value of schedule id
	 * @throws \RangeException if $newScheduleId is not positive
	 * @throws \TypeError if $newScheduleId is not an integer
	 **/
	public function setScheduleId(int $newScheduleId) {
		// base case: if the schedule id is null, this a new schedule without mySQL assigned id
		if($newScheduleId === null) {
			$this->scheduleId = null;
			return;
		}

		// verify the schedule id is positive
		if($newScheduleId <= 0) {
			throw(new \RangeException("schedule id is not positive"));
		}

		// convert and store the schedule id
		$this->scheduleId = $newScheduleId;
	}

	/**
	 * accessor method for scheduleTeam id
	 *
	 * @return int value of scheduleTeam id
	 **/
	public function getScheduleTeamId() {
		return($this->scheduleTeamId);
	}

	/**
	 * mutator method for scheduleTeam id
	 *
	 * @param int $newScheduleTeamId new value of scheduel team id
	 * @throws \RangeException if $newScheduleTeamId is not positive
	 * @throws \TypeError if $newScheduleTeamId is not an integer
	 **/
	public function setScheduleTeamId(int $newScheduleTeamId) {
		// verify the scheduleTeam id is positive
		if($newScheduleTeamId <= 0) {
			throw(new \RangeException("team id is not positive"));
		}

		// convert and store the schedule team id
		$this->scheduleTeamId = $newScheduleTeamId;
	}

	/**
	 * accessor method for scheduleLocation
	 *
	 * @return string value of schedule location
	 **/
	public function getScheduleLocation() {
		return($this->scheduleLocation);
	}

	/**
	 * mutator method for schedulelocation
	 *
	 * @param string $newScheduleLocation new value of schedule location
	 * @throws \InvalidArgumentException if $newScheduleLocation is not a string of insecure
	 * @throws \RangeException if $newScheduleLocation is > 64 characters
	 * @throws \TypeError if $newSchedulelocation is not a string
	 **/
	public function setScheduleLocation(string $newScheduleLocation) {
		// verify the schedule location is secure
		$newScheduleLocation = trim($newScheduleLocation);
		$newScheduleLocation = filter_var($newScheduleLocation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newScheduleLocation) === true) {
			throw(new \InvalidArgumentException("schedule location is empty or insecure"));
		}

		// verify the schedule location will fit in the database
		if(strlen($newScheduleLocation) > 64) {
			throw(new \RangeException("schedule location is too large"));
		}

		// store the schedule location
		$this->scheduleLocation = $newScheduleLocation;
	}

	/**
	 * accessor method for schedule starting position
	 *
	 * @return string vlaue of schedule starting position
	 **/
	public function getScheduleStartingPosition() {
		return($this->scheduleStartingPosition);
	}

	/**
	 * mutator method for schedule starting position
	 *
	 * @param string $newScheduleStartingPosition new value of schedule starting position
	 * @throws \InvalidArgumentException if $newScheduleStartingPosition is not a string or inscure
	 * @throws \RangeException if $newScheduleStartingPosition is > 32 characters
	 * @throws \TypeError if $newScheduleStartingPosition is not a string
	 **/
	public function setScheduleStartingPosition(string $newScheduleStartingPosition) {
		// verify the schedule starting position is secure
		$newScheduleStartingPosition = trim($newScheduleStartingPosition);
		$newScheduleStartingPosition = filter_var($newScheduleStartingPosition, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newScheduleStartingPosition) === true) {
			throw(new \InvalidArgumentException("schedule starting position is empty or insecure"));
		}

		// verify the schedule starting position will fit the database
		if(strlen($newScheduleStartingPosition) > 32) {
			throw(new \RangeException("schedule starting position is too large"));
		}

		// store the schedule starting position
		$this->scheduleStartingPosition = $newScheduleStartingPosition;
	}

	/**
	 * accessor method for schedule time
	 *
	 * @return \DateTime value of schedule time
	 **/
	public function getScheduleTime() {
		return($this->scheduleTime);
	}

	/**
	 * mutator method for schedule time
	 *
	 * @param \DateTime|String|null $newScheduleTime date as a DateTime object or string
	 * @throws \InvalidArgumentException if $newScheduleTime is not a valid object or string
	 * @throws \RangeException if $newScheduleTime is a date that does not exist
	 **/
	public function setScheduleTime($newScheduleTime = null) {
		// base case: if the date is null, use the current date and time
		if($newScheduleTime === null) {
			$this->ScheduleTime = new \DateTime();
			return;
		}

		// store the schedule time
		try {
			$newScheduleTime = $this->validateDate($newScheduleTime);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->scheduleTime = $newScheduleTime;
	}

	/**
	 *  inserts the schedule into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo id not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// enforce the scheduleId is null (dont insert if already exists)
		if($this->scheduleId !== null) {
			throw(new \PDOException("not a new schedule"));
		}

		// create a query template
		$query = "INSERT INTO schedule(scheduleTeamId, scheduleLocation, scheduleStartingPosition, scheduleTime) VALUES(:scheduleTeamId, :scheduleLocation, :scheduleStartingPosition, :scheduleTime)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->scheduleTime->format("Y-m-d H:i:s");
		$parameters = ["scheduleTeamId" => $this->scheduleTeamId, "scheduleLocation" => $this->scheduleLocation, "scheduleStartingPosition" => $this->scheduleStartingPosition, "scheduleTime" =>$formattedDate];
		$statement->execute($parameters);

		// update the nul schedule Id with what mySQL just gave us
		$this->scheduleId = intval($pdo->lastInsertId());
	}

	/**
	 *  deletes the schedule from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
		// enforece the schedule id is not null (dont delete a schedule that hasnet been insterted)
		if($this->scheduleId === null) {
			throw(new \PDOException("unable to delete a schedule that does not exist"));
		}

		// create query template
		$query = "DELETE FROM schedule WHERE scheduleId = :scheduleId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["scheduleId" => $this->scheduleId];
		$statement->execute($parameters);
	}

	/**
	 * updates the schedule in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) {
		// enforce the scheduleId is not null ( dont update a schedule that hasn't been inserted)
		if($this->scheduleId === null) {
			throw(new \PDOException("unable to update a schedule that does not exist"));
		}

		// create query template
		$query = "UPDATE schedule SET scheduleTeamId = :scheduleTeamId, schedulelocation = :scheduleLocation, scheduleStartingPosition = :scheduleStartingPosition, scheduleTime = :scheduleTime WHERE scheduleId = :scheduleId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->scheduleTime->format("Y-m-d H:i:s");
		$parameters = ["scheduleTeamId" => $this->scheduleTeamId, "scheduleLocation" => $this->scheduleLocation, "scheduleStartingPosition" => $this->scheduleStartingPosition, "scheduleTime" => $formattedDate, "scheduleId" => $this->scheduleId];
		$statement->execute($parameters);
	}
	/**
	 * gets schedule by schedule location
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $scheduleLocation schedule location to search for
	 * @return \SplFixedArray SplFixedArray of schedules found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getScheduleByScheduleLocation(\PDO $pdo, string $scheduleLocation) {
		// sanitize the description before searching
		$scheduleLocation = trim($scheduleLocation);
		$scheduleLocation = filter_var($scheduleLocation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($scheduleLocation) === true) {
			throw(new \PDOException("schedule content is invalid"));
		}

		// create query template
		$query = "SELECT scheduleId, scheduleTeamId, scheduleLocation, scheduleStartingPosition, scheduleTime FROM schedule WHERE scheduleLocation LIKE :scheduleLocation";
		$statement = $pdo->prepare($query);

		// bind the schedule location to the place holder in the template
		$scheduleLocation = "%$scheduleLocation%";
		$parameters = array("scheduleLocation" => $scheduleLocation);
		$statement->execute($parameters);

		// build an array of schedules
		$schedules = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$schedule = new Schedule($row["scheduleId"], $row["scheduleTeamId"], $row["scheduleLocation"], $row["scheduleStartingPosition"], $row["scheduleTime"]);
				$schedules[$schedules->key()] = $schedule;
				$schedules->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($schedules);
	}

	/**
	 * gets the schedule by schedule starting position
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $scheduleStartingPosition schedule starting position to search for
	 * @return \SplFixedArray SplFixedArray of schedules found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getScheduleByScheduleStartingPosition(\PDO $pdo, string $scheduleStartingPosition) {
		// sanitize the description before searching
		$scheduleStartingPosition = trim($scheduleStartingPosition);
		$scheduleStartingPosition = filter_var($scheduleStartingPosition, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($scheduleStartingPosition) === true) {
			throw(new \PDOException("schedule starting position is invalid"));
		}

		// create query template
		$query = "SELECT scheduleId, scheduleTeamId, scheduleLocation, scheduleStartingPosition, scheduleTime FROM schedule WHERE scheduleStartingPosition LIKE :scheduleStartingPosition";
		$statement = $pdo->prepare($query);

		// bind the schedule starting position to the place holder in the template
		$scheduleStartingPosition = "%scheduleStartingPosition%";
		$parameters = array("scheduleStartingPosition" => $scheduleStartingPosition);
		$statement->execute($parameters);

		// build an array of schedules
		$schedules = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$schedule = new Schedule($row["scheduleId"], $row["scheduleTeamId"], $row["scheduleLocation"], $row["scheduleStartingPosition"], $row["scheduleTime"]);
				$schedules[$schedules->key()] = $schedule;
				$schedules->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($schedules);
	}

	/**
	 * gets the schedule by scheduleId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $scheduleId schedule id to search for
	 * @return Schedule|null Schedule found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not correct data type
	 **/
	public static function getScheduleByScheduleId(\PDO $pdo, int $scheduleId) {
		// sanitize the scheduleId before searching
		if($scheduleId <= 0) {
			throw(new \PDOException("schedule id is not positive"));
		}

		// create query template
		$query = "SELECT scheduleId, scheduleTeamId, scheduleLocation, scheduleStartingPosition, scheduleTime FROM schedule WHERE scheduleId LIKE :scheduleId";
		$statement = $pdo->prepare($query);

		// bind the schedule id to the place holder in the template
		$parameters = array("scheduleId" => $scheduleId);
		$statement->execute($parameters);

		// grab the schedule from mySQL
		try {
			$schedule = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$schedule = new Schedule($row["scheduleId"], $row["scheduleTeamId"], $row["scheduleLocation"], $row["scheduleStartingPosition"], $row["scheduleTime"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($schedule);
	}

	/**
	 * gets all schedules
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of schedules found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllSchedules(\PDO $pdo) {
		// create query template
		$query = "SELECT scheduleId, scheduleTeamId, scheduleLocation, scheduleStartingPosition, scheduleTime FROM schedule";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of schedules
		$schedules = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$schedule = new Schedule($row["scheduleId"], $row["scheduleTeamId"], $row["scheduleLocation"], $row["scheduleStartingPosition"], $row["scheduleTime"]);
				$schedules[$schedules->key()] = $schedule;
				$schedules->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($schedules);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["scheduleTime"] = intval($this->scheduleTime->format("U")) * 1000;
		return($fields);
	}
}