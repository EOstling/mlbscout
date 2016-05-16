<?php
namespace Edu\Cnm\MlbScout\Test;

// grab the project test paramaters
use Edu\Cnm\MlbScout\{AccessLevel};

require_once("MlbScoutTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Access Level Class
 * 
 * This is a complete PHPUnit test of the Access Level Class. It is complete because *All* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 * 
 * @see AccessLevel
 * @author Jared Padilla <jaredpadilla16@gmail.com>
 */
class AccessLevelTest extends MlbScoutTest {
	/**
	 * Access Level Name
	 * @var string $VALID_ACCESSLEVELNAME
	 */
	protected $VALID_ACCESSLEVELNAME = "Scout";
	/**
	 * Access Level Name
	 * @var string $VALID_ACCESSLEVELENAME2
	 */
	protected $VALID_ACCESSLEVELNAME2 = "Coach";

	/**
	 * test inserting a valid Access Level and verify that the actual mySQL data matches
	 */
	public function testInsertValidAccessLevel() {
		// count the number of rows and save it for later
		$numRows = $this ->getConnection()->getRowCount("accessLevel");

		// create a new Access Level and insert it into mySQL
		$accessLevel = new AccessLevel(null, $this->VALID_ACCESSLEVELNAME);
		$accessLevel->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAccessLevel = AccessLevel::getAccessLevelByAccessLevelId($this->getPDO(), $accessLevel->getAccessLevelId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("accessLevel"));
		$this->assertEquals($pdoAccessLevel->getAccessLevelName(), $this->VALID_ACCESSLEVELNAME);
	}

	/**
	 * test inserting a Access Level that already exist
	 *
	 * @expectedException /PDOException
	 */
	public function testInsertInvalidAccessLevel() {
		// create a Access Level with a non null access level id and watch it fail
		$accessLevel = new AccessLevel(MlbScoutTest::INVALID_KEY, $this->VALID_ACCESSLEVELNAME);
		$accessLevel->insert($this->getPDO());
	}

	/**
	 * test inserting a Access Level, editing it, and then updating it
	 */
	public function testUpdateValidAccessLevel() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("accessLevel");

		// create a new Access Level and insert it into mySQL
		$accessLevel = new AccessLevel(null, $this->VALID_ACCESSLEVELNAME);
		$accessLevel->insert($this->getPDO());

		// edit the Access Level and update it in mySQL
		$accessLevel->setAccessLevelName($this->VALID_ACCESSLEVELNAME2);
		$accessLevel->update($this->getPDO());

		// grab th data from mySQL and enforce the fields match our expectations
		$pdoAccessLevel = AccessLevel::getAccessLevelByAccessLevelId($this->getPDO(), $accessLevel->getAccessLevelId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("accessLevel"));
		$this->assertEquals($pdoAccessLevel->getAccessLevelName(), $this->VALID_ACCESSLEVELNAME2);
	}

	/**
	 * test updating a Access Level that already exists
	 * 
	 * @expectedException /PDOException
	 */
	public function testUpdateInvalidAccessLevel() {
		// create a Access Level with a non null Access Level id and watch it fail
		$accessLevel = new AccessLevel(MlbScoutTest::INVALID_KEY, $this->VALID_ACCESSLEVELNAME);
		$accessLevel->insert($this->getPDO());
		$accessLevel->update($this->getPDO());
	}
	
	/**
	 * test creating a Access Level and then deleting it
	 *
	 */
	public function testDeleteValidAccessLevel() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("accessLevel");

		// create a new Access Level and insert into mySQL
		$accessLevel = new AccessLevel(null, $this->VALID_ACCESSLEVELNAME);
		$accessLevel->insert($this->getPDO());

		// delete the Access Level from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("accessLevel"));
		$accessLevel->delete($this->getPDO());
		
		// grab the data from mySQL and enforce the Access Level does not exist
		$pdoAccessLevel = AccessLevel::getAccessLevelByAccessLevelId($this->getPDO(), $accessLevel->getAccessLevelId());
		$this->assertNull($pdoAccessLevel);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("accessLevel"));
	}
	
	/**
	 * test deleting a Access Level that does not exist
	 * 
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidAccessLevel() {
		// create a Access Level and try to delete it without actually inserting it
		$accessLevel = new AccessLevel(null, $this->VALID_ACCESSLEVELNAME);
		$accessLevel->delete($this->getPDO());
	}
	
	/**
	 * test inserting a Access Level and regrabbing it from mySQL
	 */
	public function testGetValidAccessLevelByAccessLevelId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("accessLevel");
		
		// create a new Access Level and insert it into mySQL
		$accessLevel = new AccessLevel(null, $this->VALID_ACCESSLEVELNAME);
		$accessLevel->insert($this->getPDO());
		
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoAccessLevel = AccessLevel::getAccessLevelByAccessLevelId($this->getPDO(), $accessLevel->getAccessLevelId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("accessLevel"));
		$this->assertEquals($pdoAccessLevel->getAccessLevelName(), $this->VALID_ACCESSLEVELNAME);
	}

	/**
	 * test grabbing a Access Level that does not exist
	 */
	public function testGetInvalidAccessLevelByAccessLevelId() {
		// grab a access level id that exceeds the maximum allowable access level id
		$accessLevel = AccessLevel::getAccessLevelByAccessLevelId($this->getPDO(), MlbScoutTest::INVALID_KEY);
		$this->assertNull($accessLevel);
	}

	/**
	 * test grabbing a Access Level by access level name
	 */
	public function testGetValidAccessLevelByAccessLevelName() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("accessLevel");

		// create a new Access Level and insert it into mySQL
		$accessLevel = new AccessLevel(null, $this->VALID_ACCESSLEVELNAME);
		var_dump($accessLevel);
		$accessLevel->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = AccessLevel::getAccessLevelByAccessLevelName($this->getPDO(), $accessLevel->getAccessLevelName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("accessLevel"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\MlbScout\\AccessLevel", $results);

		// grab the result from the array and validate it
		$pdoAccessLevel = $results[0];
		$this->assertEquals($pdoAccessLevel->getAccessLevelName(), $this->VALID_ACCESSLEVELNAME);
	}

	/**
	 * test grabbing a Access Level by Access Level Name that does not exist
	*/
	public function testGetInvalidAccessLevelByAccessLevelName() {
		// grab a access level by searching for a Name that does not exist
		$accessLevel = AccessLevel::getAccessLevelByAccessLevelName($this->getPDO(), "MLB Scout that Couches both MLB College and High School teams");
		$this->assertCount(0, $accessLevel);
		}


	/**
	 * test grabbing all Access Levels
	 */
	public function testGetAllValidAccessLevels () {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("accessLevel");

		// create a new Access Level and insert it into mySQL
		$accessLevel = new AccessLevel(null, $this->VALID_ACCESSLEVELNAME);
		$accessLevel->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = AccessLevel::getAllAccessLevels($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("accessLevel"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\MlbScout\\AccessLevel", $results);

		// grab the result from the array and validate it
		$pdoAccessLevel =$results[0];
		$this->assertEquals($pdoAccessLevel->getAccessLevelName(), $this->VALID_ACCESSLEVELNAME);
	}
}