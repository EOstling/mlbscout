<?php
namespace Edu\Cnm\MlbScout\FavoritePlayerTest\Test;

use Edu\Cnm\MlbScout\{
	Player, User, Team
};
use Edu\Cnm\MlbScout\AccessLevel;
use Edu\Cnm\MlbScout\Test\MlbScoutTest;

// grab the project test parameters
require_once("MlbScoutTest.php");

// grab the classes under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * Full PHPUnit test for the favorite player class
 *
 * This is a complete PHPUnit test of the MlbScout favorite player class
 * It is a complete test because ALL mySQL/PDO methods are tested for invalid and valid inputs
 *
 * @see FavoritePlayer
 * @author Francisco Garcia <fgarcia132@cnm.edu
 */
class FavoritePlayerTest extends MlbScoutTest {
	/**
	 * playerId
	 * @var string $VALID_PLAYERID
	 */
	protected $VALID_PLAYERID = "PHPUnit test passing";
	/**
	 * userId
	 * @var string $VALID_USERID
	 */
	protected $VALID_USERID = "PHPUnit test passing";
	/**
	 * userAccessLevel access level for the users;
	 * @var AccessLevel
	 */
	protected $accessLevel = null;
	/**
	 * User that favorited the player; this is for foreign key relations
	 */
	protected $user = null;
	/**
	 * @var User Hash
	 */
	private $hash;
	/**
	 * @var User Salt
	 */
	private $salt;
	/**
	 * Player that was favorited; this is for foreign key relations
	 * @var Player $player
	 */
	protected $player = null;

	/**
	 * Team for player; this is for foreign key relations
	 * @var Team $team
	 */
	protected $team = null;

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a User to favorite a player
		$this->accessLevel = new AccessLevel(null, "accessLevelName");
		$this->accessLevel->insert($this->getPDO());
		$this->salt = bin2hex(random_bytes(32));
		$this->hash = hash_pbkdf2("sha512", "123456", $this->salt, 4096);
		$this->user = new User(null, $this->accessLevel->getAccessLevelId(), null, "userEmail@foo.com", "userFirstName", $this->hash, "userLastName", "8675309", $this->salt);
		$this->user->insert($this->getPDO());
		$this->team = new Team(null, "teamName", "teamType");
		$this->team->insert($this->getPDO());

	}

	/**
	 * test inserting a valid User and verify that the mySQL data matches
	 */
	public function testInsertValidUser() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		// create a new User and insert to into mySQL
		$user = new User(null, $this->user->getUserId(), $this->team->getTeamId);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $this->user->getUserId());
	}

	/**
	 * Test inserting a User that already exists
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidUser() {
		// create a User with a non null user id and watch it fail
		$user = new User(MlbScoutTest::INVALID_KEY, $this->user->getUserId(), $this->player->getPlayerId());
		$user->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Player and verify that the mySQL data matches
	 */
	public function testInsertValidPlayer() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new Player and insert to into mySQL
		$player = new Player(null, $this->player->getPlayerId(), $this->VALID_PLAYERID, $this->VALID_USERID);
		$this->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPlayer = Player::getPlayerByPlayerId($this->getPDO(), $player->getPlayerId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertEquals($pdoPlayer->getPlayerId(), $this->player->getPlayerId());
	}

	/**
	 * test inserting a Player that already exists
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidPlayer() {
		// create a Player with a non null player id and watch it fail
		$player = new Player(MlbScoutTest::INVALID_KEY, $this->player->getPlayerId(), $this->user->getUserId());
		$player->insert($this->getPDO());
	}


}