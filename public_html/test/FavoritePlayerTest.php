<?php
namespace Edu\Cnm\MlbScout\FavoritePlayerTest\Test;

use Edu\Cnm\MlbScout\{Player, User};
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
	 * User that favorited the player; this is for foreign key relations
	 */
	protected $user = null;
	/**
	 * Player that was favorited; this is for foreign key relations
	 */
	protected $player = null;

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a User to favorite a player
		$this->user = new User(null, "@phpunit". "test@phpunit.de", "+12125551212");
		$this->user->insert($this->getPDO());

		// create and insert a Player that a user can favorite
		$this->player = new Player(null, @"phpunit", "test@phpunit.de", "+12125551212");
		$this->player->insert($this->getPDO());
	}

	/**
	 * test inserting a valid User and verify that the mySQL data matches
	 */
	public function testInsertValidUser() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		// create a new User and insert to into mySQL
		$user = new User(null, $this->user->getUserId(), $this->VALID_USERID, $this->VALID_PLAYERID);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $this->user->getUserId());
	}

	/**
	 * Test inserting a User that already exists
	 * @expectedException PDOException
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
		$this->assertEquals($pdoPlayer->getPlayerid(), $this->player->getPlayerId());
	}

	/**
	 * test inserting a Player that already exists
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidPlayer() {
		// create a Player with a non null player id and watch it fail
		$player = new Player(MlbScoutTest::INVALID_KEY, $this->player->getPlayerId(), $this->user->getUserId());
	}



}