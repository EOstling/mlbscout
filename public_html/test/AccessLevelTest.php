<?php
namespace Edu\Cnm\MlbScout\Test;

// grab the project test paramaters
use Edu\Cnm\MlbScout\AccessLevel;
use Edu\Cnm\MlbScout\User;

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
	protected $VALID_ACCESSLEVLENAME = "Scout";
	/**
	 * Access Level Name
	 * @var string $VALID_ACCESSLEVLENAME2
	 */
	protected $VALID_ACCESSLEVELNAME2 = "Couch";
	/**
	 * @var User Hash
	 */
	private $hash;
	/**
	 * @var User Salt
	 */
	private $salt;
	/**
	 * @var  User Password
	 */
	private $password="hello";
	/**
	 * User that holds the Access Level; this is for foreign key relations
	 * @var Users user
	 */
	private $user;

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() {
		// run the default setUP() method first
		parent::setUp();
		
		//create and insert a User to own the test Access Level
		$this->salt = bin2hex(random_bytes(32));
		$this->hash = hash_pbkdf2("sha512",$this->password, $this->salt,4096);
		$this->user = new User(null, "userAccessLevelId", "userActivationToken", "userEmail","userFirstName","userHash","userLastName",
			"userPassword","userPhoneNumber","userSalt","userUpdate");
		$this->user->insert($this->getPDO());
	}

	/**
	 * test inserting a Access Level that already exist
	 *
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidAccessLevel() {
		// create a Access Level with a non null access level id and watch it fail
		$accessLevel = new AccessLevel(MlbScoutTest::INVALID_KEY, $this->user->getUserId(), $this->VALID_ACCESSLEVLENAME);
		$accessLevel->insert($this->getPDO());
	}
	/**
	 * test inserting a Access Level, editing it, and then updating it
	 */
	public function testUpdateValidTweet() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("AccessLevel");

		// create a new AccessLevel and insert it into mySQL
		$accessLevel->setAccessLevelName($this->VALID_ACCESSLEVELNAME2);
		$accessLevel->update($this->getPDO());

		// grab th data from mySQL and enforce the fields match our expectations
		$pdoAccessLevel = AccessLevel::getAccessLevelByAccessLevelId($this->getPDO(), $accessLevel->getAccessLevelId());
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("accessLevel"));
		$this->assertEquals($pdoAccessLevel->getAccessLevelId(), $this->user->getAccessLevelId());
		$this->assertEquals($pdoAccessLevel->getAccessLevelName(), $this->VALID_ACCESSLEVELNAME2);
	}

	/**
	 * test updating a Access Level that already exists
	 * 
	 * @expectedException \PDOException
	 */
	
	
	/**
	 * test creating a Access Level and then deleting it
	 *
	 */
	public function testDeleteValidTweet() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("accessLevel");

		// create a new Access Level and insert into mySQL
		$accessLevel = new AccessLevel(null, $this->user->getUserId(), $this->VALID_ACCESSLEVLENAME);
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
	 * test deleting
	 */


}