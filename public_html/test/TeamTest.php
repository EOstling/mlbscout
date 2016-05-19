<?php
namespace Edu\Cnm\MlbScout\TeamTest\Test;

use Edu\Cnm\MlbScout\Team;
use Edu\Cnm\MlbScout\Test\MlbScoutTest;

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
	protected $VALID_TEAMTYPE2 = "PHPUnit test still passing";

	/**
	 * test inserting a valid Team and verify that the actual mySQL data matches
	 */
	public function testInsertValidTeam() {
		// count the number of rows and save it for later
		$numRows= $this->getConnection()->getRowCount("team");

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
		$team = new Team(MlbScoutTest::INVALID_KEY, $this->VALID_TEAMNAME, $this->VALID_TEAMTYPE);
		$team->insert($this->getPDO());
	}

	/**
	 * test inserting a Team, editing it, and then updating it
	 */
	public function testUpdateValidTeam() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("team");

		// create a new Team and insert to into mySQL
		$team = new Team(null, $this->VALID_TEAMNAME, $this->VALID_TEAMTYPE);
		$team->insert($this->getPDO());

		// edit the Team and update it in mySQL
		$team->setTeamName($this->VALID_TEAMNAME2);
		$team->setTeamType($this->VALID_TEAMTYPE2);
		$team->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTeam = Team::getTeamByTeamId($this->getPDO(), $team->getTeamId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("team"));
		$this->assertEquals($pdoTeam->getTeamName(), $this->VALID_TEAMNAME2);
		$this->assertEquals($pdoTeam->getTeamType(), $this);
	}

	/**
	 * test updating a Team that already exists
	 *
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidTeam() {
		// create a Team with a non null team id and watch it fail
		$team = new Team(null, $this->VALID_TEAMNAME, $this->VALID_TEAMTYPE);
		$team->update($this->getPDO());
	}

	/**
	 * test creating a Team and then deleting
	 */
	public function testDeleteValidTeam() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("team");

		// create a new Team and insert into mySQL
		$team = new Team(null, $this->VALID_TEAMNAME, $this->VALID_TEAMTYPE);
		$team->insert($this->getPDO());

		// delete the Team from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("team"));
		$team->delete($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTeam = Team::getTeamByTeamId($this->getPDO(), $team->getTeamId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("team"));
		$this->assertEquals($pdoTeam->getTeamName(), $this->VALID_TEAMNAME);
		$this->assertEquals($pdoTeam->getTeamType(), $this->VALID_TEAMTYPE);
	}
	/**
	 * test deleting a Team that does not exist
	 *
	 * @expectedException
	 */
	public function testDeleteInvalidTeam() {
		// create a Team and try to delete it without actually inserting it
		$team = new Team(null, $this->VALID_TEAMNAME, $this->VALID_TEAMTYPE);
		$team->delete($this->getPDO());
	}

	/**
	 * test inserting a Team and regrabbing it from mySQL
	 */
	public function testGetValidTeamByTeamId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("team");

		// create a new Team and insert into mySQL
		$team = new Team(null, $this->VALID_TEAMNAME, $this->VALID_TEAMTYPE);
		$team->insert($this->getPDO());

		// grab the data from mySQL
		$pdoTeam = Team::getTeamByTeamId($this->getPDO(), $team->getTeamId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("team"));
		$this->assertEquals($pdoTeam->getTeamName(), $this->VALID_TEAMNAME);
		$this->assertEquals($pdoTeam->getTeamType(), $this->VALID_TEAMTYPE);
	}

	/**
	 * test grabbing a Team that does not exist
	 */
	public function testGetInvalidTeamByTeamId() {
		// grab a team id that exceeds the maximum allowable team id
		$team = Team::getTeamByTeamId($this->getPDO(), MlbScoutTest::INVALID_KEY);
		$this->assertNull($team);
	}

	/**
	 * test grabbing a Team by team name
	 */
	public function testGetValidTeamByTeamName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("team");

		// create a new Team and insert to into mySQL
		$team = new Team(null, $this->VALID_TEAMNAME, $this->VALID_TEAMTYPE);
		$team->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Team::getTeamByTeamName($this->getPDO(), $team->getTeamName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("team"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstanceOf("Edu\\Cnm\\MlbScout\\Team", $results);

		// grab the results from the array and validate it
		$pdoTeam = $results[0];
		$this->assertEquals($pdoTeam->getTeamName(), $this->VALID_TEAMNAME);
		$this->assertEquals($pdoTeam->getTeamType(), $this->VALID_TEAMTYPE);
	}

	/**
	 * test grabbing a Team by content that does not exist
	 */
	public function testGetInvalidTeamByTeamName() {
		// grab a team by searching for name that does not exist
		$team = Team::getTeamByTeamName($this->getPDO(), "you shall not pass");
		$this->assertCount(0, $team);
	}

	/**
	 * test grabbing all Teams
	 */
	public function testGetAllValidTeams() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("team");

		// create a new Team and insert to into mySQL
		$team = new Team(null, $this->VALID_TEAMNAME, $this->VALID_TEAMTYPE);
		$team->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Team::getAllTeams($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("team"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\MlbScout\\Team", $results);

		// grab the result from the array and validate it
		$pdoTeam = $results[0];
		$this->assertEquals($pdoTeam->getTeamName(), $this->VALID_TEAMNAME);
		$this->assertEquals($pdoTeam->getTeamType(), $this->VALID_TEAMTYPE);
	}



}
