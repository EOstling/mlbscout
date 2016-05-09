<?php
namespace Edu\Cnm\Llaudick\MlbScout;

require_once("autoload.php");

/**
 *
 *
 * @author Lucas Laudick
 **/
class Schedule implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for this schedule; this is the primary key
	 * @var int $scheduleId
	 **/
	private $scheduleId;
	/**
	 * id of the team that has the schedue; this is the foreign key
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
	 * constructor for the scheduel
	 *
	 * @param int|Null $newSchduleId id of this schedule or null if new schedule
	 * @param int
	 *
	 *
	 *
	 *
	 **/


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
	public function setScheduleId() {
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
		return($this->$scheduleTeamId);
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
			throw(new \InvalidArgumentExceptions("schedule location is empty or insecure"));
		}

		// verify the schedule location will fit in the database
		if(strlen($newScheduleLocation) > 64) {
			throw(new \RangeException("schedule location is too large"));
		}

		// store the schedule location
		$this->scheduleLocation = $newScheduleLocation;
	}

	/**
	 * accessor method for schedule starting positio
	 */
}