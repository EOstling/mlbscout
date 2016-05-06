<?php
namespace Edu\Cnm\MlbScout\TeamTest\Test;

use

// grab the project test parameters
use Edu\Cnm\Fgarcia132\MlbScout\Team;require_once("TeamTest.php");

// grab the class under scrutiny
require_once()

/**
 * Full PHPUnit test for Team class
 *
 * This is a complete PHPUnit test of the Team class. It is complete because All mySQL/PDO enabled methods are test for both invalid and valid inputs.
 *
 * @see Team
 * @author Francisco Garcia <fgarcia132@cnm.edu
 */
class TeamTest extends MlbScoutTest {
	/**
	 * Content of the Team
	 * @var string $VALID_TEAMCONTENT
	 */
	protected $VALID_TEAMCONTENT = "PHPUnit test passing";
	/**
	 * content of the updated Team
	 * @var string $VALID_TEAMCONTENT2
	 */
	protected $VALID_TEAMCONTENT2 = "PHPUnit test still passing";

	/**
	 * create dependent objects before running each test
	 */
	public final function

	/**
	 * test inserting a valid Team and verify that the actual mySQL data matches
	 */
	public function testInsertValidTeam() {
		// count the number of rows and save it for later
		$numRows= $this->getConnection()-getRowCount("team");

		// create a new Team and insert into mySQL
		$team = new Team(null, $this->user->getUserId), $this->VALID_TEAMCONTENT,
		$team->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTeam = Team::getTeamByTeamId($this->getPDO(), $team->getTeamId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("team"));
		$this->assertEquals($pdoTeam->getTeamId(), $this->VALID_TEAMCONTENT);
		$this->assertEquals($pdoTeam->getTeamName()), $this->VALID_TEAMCONTENT;
		$this->assertEquals($pdoTeam->getTeamType(), $this->VALID_TEAMCONTENT);
	}

	/**
	 * test inserting a Team that already exists
	 *
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidTeam() {
		// create a Team with a non null team id and watch it fail
		$team = new Team(MlbScoutTest::INVALID_KEY, $this->VALID_TEAMCONTENT);
		$team->insert($this->getPDO());
	}

	/**
	 * test inserting a Team, editing it, and then updating it
	 */
	public function testUpdateValidTeam() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("team");

		// create a new Team and insert to into mySQL
		$team = new Team(null, $this->VALID_TEAMCONTENT);
		$team->insert($this->getPDO());

		// edit the Team and update it in mySQL
		$team->setTeamContent($this->VALID_TEAMCONTENT2);
		$team->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTeam = Team::getTeamByTeamId($this->getPDO(), 4team->getTeamId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("team"));
		$this->assertEquals($pdoTeam->getTeamName(), $this->VALID_TEAMCONTENT2);
		$this->assertEquals($pdoTeam->getTeamType(), $this)
	}


}
