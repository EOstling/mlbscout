<?php
namespace Edu\Cnm\Mlbscout\Test;

// grab the project test parameters
require_once("MlbScoutTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/*
 * Full PHPUnit test for the Schedule class
 *
 *
 *
 * @see Schedule
 * @author Lucas Laudick <llaudick@cnm.edu>
 **/
class ScheduleTest extends MlbScoutTest {
	/**
	 * location of the game on the schedule
	 * @var string $VALID_SCHEDULELOCATION
	 **/
	protected $VALID_SCHEDULELOCATION = "Albuquerque";
	/**
	 * location of the updated schedule
	 * @var string $VALID_SCHEDULELOCATION2
	 **/
	protected $VALID_SCHEDULELOCATION2 = "Denver";
	/**
	 * starting positions for the schedule
	 * @var string $VALID_SCHEDULESTARTINGPOSITION
	 **/
	protected $VALID_SCHEDULESTARTINGPOSITION = "Left Field";
	/**
	 * starting positions for updated schedule
	 * @var string $VALID_SCHEDULESTARTINGPOSITION2
	 **/
	protected $VALID_SCHEDULESTARTINGPOSITION2 = "Right Field";
	/**
	 * timestamp of the schedule; this starts as null and is assigned later
	 * @var \DateTime $VALID_SCHEDULETIME
	 **/
	protected $VALID_SCHEDULETIME = null;
	/**
	 * Team that has the schedule: this is the foreign key relations
	 * @var Team
	 **/
	protected $Team = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a team to own the test schedule
		$this->team = new Team(null, "teamId", "teamName", "teamType");
		$this->team->insert($this->getPDO());

		// calculate the date
		$this->VALID_SCHEDULETIME = new \DateTime();
	}

	/**
	 * test inserting a valid Schedule and verify that the actual mySQL data matches
	 **/
	public function testInsertValidSchedule() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("schedule");

		// create a new schedule and insert it into mySQL
		$schedule = new Schedule(null, $this->team->getTeamId(), $this->VALID_SCHEDULELOCATION, $this->VALID_SCHEDULESTARTINGPOSITION, $this->VALID_SCHEDULETIME);
		$schedule->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoSchedule = Schedule::getScheduleByScheduleID($this->getPDO(), $schedule->getScheduleId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("schedule"));
		$this->assertEquals($pdoSchedule->getScheduleTeamId(), $this->team->getTeamId());
		$this->assertEquals($pdoSchedule->getScheduleLocation(), $this->VALID_SCHEDULELOCATION());
		$this->assertEquals($pdoSchedule->getScheduleStartingPosition(), $this->VALID_SCHEDULESTARTINGPOSITION());
		$this->assertEquals($pdoSchedule->getScheduleTime(), $this->VALID_SCHEDULETIME());
	}

	/**
	 * test inserting a schedule that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidSchedule() {
		// create a schedule with a non null schedule id and watch it fail
		$schedule = new Schedule(MlbScoutTest::INVALID_KEY, $this->team->getTeamId(), $this->VALID_SCHEDULELOCATION, $this->VALID_SCHEDULESTARTINGPOSITION, $this->VALID_SCHEDULETIME);
		$schedule->insert($this->getPDO());
	}

	/**
	 * test inserting a schedule, editing it, then updating it
	 **/
	public function testUpdateValidSchedule() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("schedule");

		// create a new schedule and insert it into mySQL
		$schedule = new Schedule(null, $this->team->getTeamId(), $this->VALID_SCHEDULELOCATION, $this->VALID_SCHEDULESTARTINGPOSITION, $this->VALID_SCHEDULETIME);
		$schedule->insert($this->getPDO());

		//edit the schedule and update it in mySQL
		$schedule->setScheduleLocation($this->VALID_SCHEDULELOCATION2);
		$schedule->setScheduleStartingPosition($this->VALID_SCHEDULESTARTINGPOSITION2);
		$schedule->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoSchedule = Schedule::getScheduleByScheduleID($this->getPDO(), $schedule->getScheduleId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("schedule"));
		$this->assertEquals($pdoSchedule->getScheduleTeamId(), $this->team->getTeamId());
		$this->assertEquals($pdoSchedule->getScheduleLocation(), $this->VALID_SCHEDULELOCATION());
		$this->assertEquals($pdoSchedule->getScheduleStartingPosition(), $this->VALID_SCHEDULESTARTINGPOSITION());
		$this->assertEquals($pdoSchedule->getScheduleTime(), $this->VALID_SCHEDULETIME());
	}

	/**
	 * test updating a schedule that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidSchedule() {
		// create a schedule with a non null schedule id and watch it fail
		$schedule = new Schedule(null, $this->team->getTeamId(), $this->VALID_SCHEDULELOCATION, $this->VALID_SCHEDULESTARTINGPOSITION, $this->VALID_SCHEDULETIME);
		$schedule->update($this->getPDO());
	}

	/**
	 * test creating a schedule and then deleteing it
	 **/
	public function testDeleteValidSchedule() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("schedule");

		// create a new schedule and insert it to mySQL
		$schedule = new Schedule(null, $this->team->getTeamId(), $this->VALID_SCHEDULELOCATION, $this->VALID_SCHEDULESTARTINGPOSITION, $this->VALID_SCHEDULETIME);
		$schedule->insert($this->getPDO());

		// delete the schedule from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("schedule"));
		$schedule->delete($this->getPDO());

		// grab the data from mySQL and enforce the schedule does not exist
		$pdoSchedule = Schedule::getScheduleByScheduleId($this->getPDO(), $schedule->getScheduleId());
		$this->assertNull($pdoSchedule);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("schedule"));
	}

	/**
	 * test deleting a schedule that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvaldiSchedule() {
		// create a schedule and try to delete it without actually inserting it
		$schedule = new Schedule(null, $this->team->getTeamId(), $this->VALID_SCHEDULELOCATION, $this->VALID_SCHEDULESTARTINGPOSITION, $this->VALID_SCHEDULETIME);
		$schedule->delete($this->getPDO());
	}
	/**
	 * test inserting a schedule and regrabbing it from mySQL
	 **/
	public function testGetValidScheduleByScheduleId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("schedule");

		// create a new schedule and insert to into mySQL
		$schedule = new Schedule(null, $this->team->getTeamId(), $this->VALID_SCHEDULELOCATION, $this->VALID_SCHEDULESTARTINGPOSITION, $this->VALID_SCHEDULETIME);
		$schedule->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoSchedule = Schedule::getScheduleByScheduleID($this->getPDO(), $schedule->getScheduleId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("schedule"));
		$this->assertEquals($pdoSchedule->getScheduleTeamId(), $this->team->getTeamId());
		$this->assertEquals($pdoSchedule->getScheduleLocation(), $this->VALID_SCHEDULELOCATION());
		$this->assertEquals($pdoSchedule->getScheduleStartingPosition(), $this->VALID_SCHEDULESTARTINGPOSITION());
		$this->assertEquals($pdoSchedule->getScheduleTime(), $this->VALID_SCHEDULETIME());
	}

	/**
	 * test grabbing a schedule that does not exist
	 **/
	public function testGetInvalidScheduleByScheduleId() {
		// grab a team id that exceeds the maximum allowable team id
		$schedule = Schedule::getScheduleByScheduleId($this->getPDO(), MlbScoutTest::INVALID_KEY);
		$this->assertNull($schedule);
	}

	/**
	 * test grabbing a schedule bu schedule location
	 **/
	public function testGetValidScheduleByScheduleLocation() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("schedule");

		// create a new schedule and insert to into mySQL
		$schedule = new Schedule(null, $this->team->getTeamId(), $this->VALID_SCHEDULELOCATION, $this->VALID_SCHEDULESTARTINGPOSITION, $this->VALID_SCHEDULETIME);
		$schedule->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Schedule::getScheduleByScheduleLocation($this->getPDO(), $schedule->getScheduleLocation());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("schedule"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Llaudick\\MlbScout\\Schedule", $results);

		// grab the result from the array and validate it
		$pdoSchedule = $results[0];
		$this->assertEquals($pdoSchedule->getScheduleTeamId(), $this->team->getTeamId());
		$this->assertEquals($pdoSchedule->getScheduleLocation(), $this->VALID_SCHEDULELOCATION);
		$this->assertEquals($pdoSchedule->getScheduleStartingPosition(), $this->VALID_SCHEDULESTARTINGPOSITION);
		$this->assertEquals($pdoSchedule->getScheduleTime(), $this->VALID_SCHEDULETIME);
	}

	/**
	 * test grabbing a schedule by schedule location that does not exist
	 **/
	public function testGetInvalidScheduleByScheduleLocation() {
		// grab a schedule by searchin for schedule location that does not exist
		$schedule = Schedule::getScheduleByScheduleLocation($this->getPDO(), "nothing will be found");
		$this->assertCount(0, $schedule);
	}

	/**
	 * test grabbing a schedule by schedule starting position
	 **/
	public function testGetValidScheduleByScheduleStartingPosition() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("schedule");

		// create a new schedule and insert to into mySQL
		$schedule = new Schedule(null, $this->team->getTeamId(), $this->VALID_SCHEDULELOCATION, $this->VALID_SCHEDULESTARTINGPOSITION, $this->VALID_SCHEDULETIME);
		$schedule->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Schedule::getScheduleByScheduleStartingPosition($this->getPDO(), $schedule->getScheduleStartingPosition());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("schedule"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Llaudick\\MlbScout\\Schedule", $results);

		// grab the result from the array and validate it
		$pdoSchedule = $results[0];
		$this->assertEquals($pdoSchedule->getScheduleTeamId(), $this->team->getTeamId());
		$this->assertEquals($pdoSchedule->getScheduleLocation(), $this->VALID_SCHEDULELOCATION);
		$this->assertEquals($pdoSchedule->getScheduleStartingPosition(), $this->VALID_SCHEDULESTARTINGPOSITION);
		$this->assertEquals($pdoSchedule->getScheduleTime(), $this->VALID_SCHEDULETIME);
	}

	/**
	 * test grabbing a schedule by schedule location that does not exist
	 **/
	public function testGetInvalidScheduleByScheduleStartingPosition() {
		// grab a schedule by searchin for schedule starting position that does not exist
		$schedule = Schedule::getScheduleByScheduleStartingPosition($this->getPDO(), "nothing will be found");
		$this->assertCount(0, $schedule);
	}
}