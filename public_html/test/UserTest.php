<?php
namespace Edu\Cnm\MlbScout;

use Edu\Cnm\MlbScout\Test\MlbScoutTest;
use Edu\Cnm\MlbScout\{AccessLevel};

// grab the project test parameters
require_once("MlbScoutTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * Full PHPUnit test for the User class
 * 
 * This is a complete PHPUnit test of the User class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 * 
 * @see User
 * @author Jared Padilla <JaredPadilla16@gmail.com>
 */
Class UserTest extends MlbScoutTest {
	/**
	 * activation token of the user
	 * @var string $VALID_USERACTIVATIONTOKEN
	 */
	protected $VALID_USERACTIVATIONTOKEN = null;
	/**
	 * activation token of the user
	 * @var string $VALID_USERACTIVATIONTOKEN2
	 */
	protected $VALID_USERACTIVATIONTOKEN2 = null;
	/**
	 * email of the user
	 * @var string $VALID_USEREMAIL
	 */
	protected $VALID_USEREMAIL = "foo@bar.com";
	/**
	 * email of the user
	 * @var string $VALID_USEREMAIL2
	 */
	protected $VALID_USEREMAIL2 = "bar@foo.com";
	/**
	 * first name of the user
	 * @var string $VALID_USERFIRSTNAME
	 */
	protected $VALID_USERFIRSTNAME = "Diego";
	/**
	 * first name of the user
	 * @var string $VALID_USERFIRSTNAME2
	 */
	protected $VALID_USERFIRSTNAME2 = "Juan";
	/**
	 * last name of user
	 * @var string $VALID_USERLASTNAME
	 */
	public $VALID_USERLASTNAME = "Padilla";
	/**
	 * last name of user
	 * #var sting $VALID_USERLASTNAME2
	 */
	public $VALID_USERLASTNAME2 = "Martinez";
	/**
	 * phone number of user
	 * @var int $VALID_USERPHONENUMBER
	 */
	public $VALID_USERPHONENUMBER = "5051234567";
	/**
	 * phone number of user
	 * @var int $VALID_USERPHONENUMBER2
	 */
	public $VALID_USERPHONENUMBER2 = "5057654321";
	/**
	 * @var User Hash
	 */
	private $hash;
	/**
	 * @var User Salt
	 */
	private $salt;
	/**
	 * user accesss level
	 * @var AccessLevel $accessLevel
	 */
	protected $accessLevel;

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() {
		// run the default setUp method first
		parent::setUp();

		//create and insert a User to own the account
		$this->accessLevel = new AccessLevel(null, "accessLevelName");
		$this->accessLevel->insert($this->getPDO());
		$this->VALID_USERACTIVATIONTOKEN = bin2hex(random_bytes(16));
		$this->salt = bin2hex(random_bytes(32));
		$this->hash = hash_pbkdf2("sha512", "123456", $this->salt, 4096);
	}

	/**
	 * test inserting a valid User and verify that the actual mySQL data matches
	 */
	public function testInsertValidUser() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		//create a new User and insert to into mySQL
		$user = new User(null, $this->accessLevel->getAccessLevelId(), $this->VALID_USERACTIVATIONTOKEN, $this->VALID_USEREMAIL, $this->VALID_USERFIRSTNAME, $this->hash, $this->VALID_USERLASTNAME, $this->VALID_USERPHONENUMBER, $this->salt);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserAccessLevelId(), $this->accessLevel->getAccessLevelId());
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_USERACTIVATIONTOKEN);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_USEREMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_USERFIRSTNAME);
		$this->assertEquals($pdoUser->getUserHash(), $this->hash);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_USERLASTNAME);
		$this->assertEquals($pdoUser->getUserPhoneNumber(), $this->VALID_USERPHONENUMBER);
		$this->assertEquals($pdoUser->getUserSalt(), $this->salt);

	}

	/**
	 * test inserting a User that already exist
	 *
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidUser() {
		// create a User with a non null user id and watch it fail
		$user = new User(null, $this->accessLevel->getAccessLevelId(), $this->VALID_USERACTIVATIONTOKEN, $this->VALID_USEREMAIL, $this->VALID_USERFIRSTNAME, $this->hash, $this->VALID_USERLASTNAME, $this->VALID_USERPHONENUMBER, $this->salt);
		$user->insert($this->getPDO());
	}

	/**
	 * test inserting a User, editing it, and then updating it
	 */
	public function testUpdateValidUser() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		//create a new User and insert to into mySQL
		$user = new User(null, $this->accessLevel->getAccessLevelId(), $this->VALID_USERACTIVATIONTOKEN, $this->VALID_USEREMAIL, $this->VALID_USERFIRSTNAME, $this->hash, $this->VALID_USERLASTNAME, $this->VALID_USERPHONENUMBER, $this->salt);
		$user->insert($this->getPDO());

		// edit the User and update it in mySQL
		$user->setUserActivationToken($this->VALID_USERACTIVATIONTOKEN);
		$user->setUserEmail($this->VALID_USEREMAIL);
		$user->setUserFirstName($this->VALID_USERFIRSTNAME);
		$user->setUserHash($this->hash);
		$user->setUserLastName($this->VALID_USERLASTNAME);
		$user->setUserPhoneNumber($this->VALID_USERPHONENUMBER);
		$user->setUserSalt($this->salt);
		$user->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserAccessLevelId(), $this->accessLevel->getAccessLevelId());
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_USERACTIVATIONTOKEN);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_USEREMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_USERFIRSTNAME);
		$this->assertEquals($pdoUser->getUserHash(), $this->hash);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_USERLASTNAME);
		$this->assertEquals($pdoUser->getUserPhoneNumber(), $this->VALID_USERPHONENUMBER);
		$this->assertEquals($pdoUser->getUserSalt(), $this->salt);
	}

	/**
	 * test updating a User that already exist
	 *
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidUser() {
		// create a User with a non null user id and watch it fail
		$user = new User(null, $this->accessLevel->getAccessLevelId(), $this->VALID_USERACTIVATIONTOKEN, $this->VALID_USEREMAIL, $this->VALID_USERFIRSTNAME, $this->hash, $this->VALID_USERLASTNAME, $this->VALID_USERPHONENUMBER, $this->salt);
		$user->update($this->getPDO());
	}

	/**
	 * test creating a User and then deleting it
	 */
	public function testDeleteValidUser() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		//create a new User and insert to into mySQL
		$user = new User(null, $this->accessLevel->getAccessLevelId(), $this->VALID_USERACTIVATIONTOKEN, $this->VALID_USEREMAIL, $this->VALID_USERFIRSTNAME, $this->hash, $this->VALID_USERLASTNAME, $this->VALID_USERPHONENUMBER, $this->salt);
		$user->insert($this->getPDO());

		// delete the User from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$user->delete($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertnull($pdoUser);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("user"));
	}

	/**
	 * test deleting a User that does not exist
	 *
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidUser() {
		// create a User and try to delete it without actually inserting it
		$user = new User(null, $this->accessLevel->getAccessLevelId(), $this->VALID_USERACTIVATIONTOKEN, $this->VALID_USEREMAIL, $this->VALID_USERFIRSTNAME, $this->hash, $this->VALID_USERLASTNAME, $this->VALID_USERPHONENUMBER, $this->salt);
		$user->delete($this->getPDO());
	}

	/**
	 * test inserting a User and regrabbing it from mySQL
	 */
	public function testGetValidUserByUserAccessLevelId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		//create a new User and insert to into mySQL
		$user = new User(null, $this->accessLevel->getAccessLevelId(), $this->VALID_USERACTIVATIONTOKEN, $this->VALID_USEREMAIL, $this->VALID_USERFIRSTNAME, $this->hash, $this->VALID_USERLASTNAME, $this->VALID_USERPHONENUMBER, $this->salt);
		$user->delete($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = User::getUserByUserAccessLevelId($this->getPDO(), $user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertCount(1, $results);
		$this->asserContainsOnlyInstancesOf("Edu\\Cnm\\MlbScout\\User", $results);

		// grab the result from the array and validate it
		$pdoUser = $results[0];
		$this->assertEquals($pdoUser->getUserAccessLevelId(), $this->accessLevel->getAccessLevelId());
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_USERACTIVATIONTOKEN);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_USEREMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_USERFIRSTNAME);
		$this->assertEquals($pdoUser->getUserHash(), $this->hash);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_USERLASTNAME);
		$this->assertEquals($pdoUser->getUserPhoneNumber(), $this->VALID_USERPHONENUMBER);
		$this->assertEquals($pdoUser->getUserSalt(), $this->salt);
	}
	/**
	 * test inserting a User and regrabbing it from mySQL
	 */
	public function testGetValidUserByUserId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		//create a new User and insert to into mySQL
		$user = new User(null, $this->accessLevel->getAccessLevelId(), $this->VALID_USERACTIVATIONTOKEN, $this->VALID_USEREMAIL, $this->VALID_USERFIRSTNAME, $this->hash, $this->VALID_USERLASTNAME, $this->VALID_USERPHONENUMBER, $this->salt);
		$user->delete($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertCount(1, $results);
		$this->asserContainsOnlyInstancesOf("Edu\\Cnm\\MlbScout\\User", $results);

		// grab the result from the array and validate it
		$pdoUser = $results[0];
		$this->assertEquals($pdoUser->getUserAccessLevelId(), $this->accessLevel->getAccessLevelId());
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_USERACTIVATIONTOKEN);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_USEREMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_USERFIRSTNAME);
		$this->assertEquals($pdoUser->getUserHash(), $this->hash);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_USERLASTNAME);
		$this->assertEquals($pdoUser->getUserPhoneNumber(), $this->VALID_USERPHONENUMBER);
		$this->assertEquals($pdoUser->getUserSalt(), $this->salt);
	}

	/**
	 * test grabbing a User that does not exist
	 */
	public function testGetInvalidUserByUserId() {
		// grab a user id that exceeds the maximum allowable user id
		$user = User::getUserByUserId($this->getPDO(), MlbScoutTest::INVALID_KEY);
		$this->assertNull($user);
	}

	/**
	 * test grabbing a User by user email
	 */
	public function testGetValidUserByUserEmail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		//create a new User and insert to into mySQL
		$user = new User(null, $this->accessLevel->getAccessLevelId(), $this->VALID_USERACTIVATIONTOKEN, $this->VALID_USEREMAIL, $this->VALID_USERFIRSTNAME, $this->hash, $this->VALID_USERLASTNAME, $this->VALID_USERPHONENUMBER, $this->salt);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = User::getUserByUserEmail($this->getPDO(), $user->getUserEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\MlbScout\\User", $results);

		//grab the result from the array and validate it
		$pdoUser = $results[0];
		$this->assertEquals($pdoUser->getUserAccessLevelId(), $this->accessLevel->getAccessLevelId());
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_USERACTIVATIONTOKEN);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_USEREMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_USERFIRSTNAME);
		$this->assertEquals($pdoUser->getUserHash(), $this->hash);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_USERLASTNAME);
		$this->assertEquals($pdoUser->getUserPhoneNumber(), $this->VALID_USERPHONENUMBER);
		$this->assertEquals($pdoUser->getUserSalt(), $this->salt);
	}

	/**
	 * test grabbing a User by email that does not exist
	 */
	public function testGetInvalidUserByUserEmail() {
		// grab a User by searching for email that does not exist
		$user = User::getUserByUserEmail($this->getPDO(), "if nothing is what you seek, you have found what you are looking for");
		$this->assertCount(0, $user);
	}


	/**
	 * test grabbing all Users
	 */
	public function testGetAllValidUsers() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		//create a new User and insert to into mySQL
		$user = new User(null, $this->accessLevel->getAccessLevelId(), $this->VALID_USERACTIVATIONTOKEN, $this->VALID_USEREMAIL, $this->VALID_USERFIRSTNAME, $this->hash, $this->VALID_USERLASTNAME, $this->VALID_USERPHONENUMBER, $this->salt);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = User::getAllUsers($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\MlbScout\\User", $results);

		//grab the result from the array and validate it
		$pdoUser = $results[0];
		$this->assertEquals($pdoUser->getUserAccessLevelId(), $this->accessLevel->getAccessLevelId());
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_USERACTIVATIONTOKEN);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_USEREMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_USERFIRSTNAME);
		$this->assertEquals($pdoUser->getUserHash(), $this->hash);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_USERLASTNAME);
		$this->assertEquals($pdoUser->getUserPhoneNumber(), $this->VALID_USERPHONENUMBER);
		$this->assertEquals($pdoUser->getUserSalt(), $this->salt);
	}


}

