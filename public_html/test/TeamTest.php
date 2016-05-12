<?php
namespace Edu\Cnm\MlbScout\TeamTest\Test;

use Edu\Cnm\MlbScout\Team;

// grab the project test parameters
require_once("MlbScoutTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");


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
	 * Name of the Team
	 * @var string $VALID_TEAMNAME
	 */
	protected $VALID_TEAMNAME = "PHPUnit test passing";
	/**
	 * Name of the updated Team
	 * @var string $VALID_TEAMNAME2
	 */
	protected $VALID_TEAMNAME2 = "PHPUnit test still passing";
	/**
	 * Type of the Team
	 * @var string $TEAM_TYPE
	 */
	protected $VALID_TEAMTYPE = "PHPUnit test passing";
	/**
	 * Name of updated Team
	 * @var string $VALID_TEAMTYPE2
	 */

	/**
	 * test inserting a valid Team and verify that the actual mySQL data matches
	 */
	public function testInsertValidTeam() {
		// count the number of rows and save it for later
		$numRows= $this->getConnection()-getRowCount("team");

		// create a new Team and insert into mySQL
		$team = new Team(null, $this->VALID_TEAMNAME, $this->VALID_TEAMTYPE);
		$team->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTeam = Team::getTeamByTeamId($this->getPDO(), $team->getTeamId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("team"));
		$this->assertEquals($pdoTeam->getTeamName(), $this->VALID_TEAMNAME);
		$this->assertEquals($pdoTeam->getTeamType(), $this->VALID_TEAMNAME);
	}

	/**
	 * test inserting a Team that already exists
	 *
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidTeam() {
		// create a Team with a non null team id and watch it fail
		$team = new Team(MlbScoutTest::INVALID_KEY, $this->VALID_TEAMNAME);
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
