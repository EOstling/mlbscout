<?php
namespace Edu\Cnm\MlbScout\Test;

use Edu\Cnm\MlbScout\{
	FavoritePlayer, Player, User, Team
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
	 * @throws \PDOException
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

		// create and insert a Player that a user can favorite
		$this->player = new Player(null, $this->team->getTeamId(), $this->user->getUserId(), "L", "yes", "playerFirstName", "active", "75", "Denver", "playerLastName", "left fl", "R", "180");
		$this->player->insert($this->getPDO());
	}
	/**
	 * test inserting a valid Favorite Player and verify that the actual mySQL data matches
	 **/
	public function testInsertValidFavoritePlayer() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favoritePlayer");
		// create a new Favorite Player and insert to into mySQL
		$favoritePlayer = new FavoritePlayer($this->player->getPlayerId(), $this->user->getUserId());
		$favoritePlayer->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFavoritePlayer = FavoritePlayer::getFavoritePlayerByFavoritePlayerPlayerIdAndFavoritePlayerUserId($this->getPDO(), $this->player->getPlayerId(), $this->user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favoritePlayer"));
		$this->assertEquals($pdoFavoritePlayer->getPlayerId(), $this->player->getPlayerId());
		$this->assertEquals($pdoFavoritePlayer->getUserId(), $this->user->getUserId());
	}
	/**
	 * test creating Favorite Player
	 *
	 * @expectedException \TypeError
	 **/
	public function testInsertInvalidFavoritePlayer() {
		// create a favorite player without foreign keys
		$favoritePlayer = new FavoritePlayer(null, null, null);
	}
	/**
	 * test creating a Favorite Player and then deleting it
	 **/
	public function testDeleteValidFavoritePlayer() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favoritePlayer");
		// create a new Favorite and insert to into mySQL
		$favoritePlayer = new FavoritePlayer($this->player->getPlayerId(), $this->user->getUserId());
		$favoritePlayer->insert($this->getPDO());
		// delete the Favorite Player from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favoritePlayer"));
		$favoritePlayer->delete($this->getPDO());
		// grab the data from mySQL and enforce the Player does not exist
		$pdoFavoritePlayer = FavoritePlayer::getFavoritePlayerByFavoritePlayerPlayerIdAndFavoritePlayerUserId($this->getPDO(), $this->player->getPlayerId(), $this->user->getUserId());
		$this->assertNull($pdoFavoritePlayer);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("favoritePlayer"));
	}
	/**
	 * test inserting a Favorite player and regrabbing it from mySQL
	 **/
	public function testGetValidFavoritePlayerByFavoritePlayerPlayerIdAndFavoritePlayerUserId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favoritePlayer");

		// create a new Favorite Player and insert to into mySQL
		$favoritePlayer = new FavoritePlayer($this->player->getPlayerId(), $this->user->getUserId());
		$favoritePlayer->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFavoritePlayer = FavoritePlayer::getFavoritePlayerByFavoritePlayerPlayerIdAndFavoritePlayerUserId($this->getPDO(), $this->player->getPlayerId(), $this->user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favoritePlayer"));
		$this->assertEquals($pdoFavoritePlayer->getFavoritePlayerPlayerId(), $this->player->getFavoritePlayerPlayerId());
		$this->assertEquals($pdoFavoritePlayer->getFavoritePlayerUserId(), $this->user->getFavoritePlayerUserId());
	}
	/**
	 * test grabbing a Favorite Player that does not exist
	 **/
	public function testGetInvalidFavoritePlayerByFavoritePlayerPlayerIdAndFavoritePlayerUserId() {
		// grab a player id and user id that exceeds the maximum allowable player id and user id
		$favoritePlayer = FavoritePlayer::getFavoritePlayerByFavoritePlayerPlayerIdAndFavoritePlayerUserId($this->getPDO(), MlbScoutTest::INVALID_KEY, MlbScoutTest::INVALID_KEY);
		$this->assertNull($favoritePlayer);
	}
	/**
	 * test grabbing a Favorite Player by player id
	 **/
	public function testGetValidFavoritePlayerByFavoritePlayerPlayerId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favoritePlayer");
		// create a new Favorite Player and insert to into mySQL
		$favoritePlayer = new FavoritePlayer($this->player->getPlayerId(), $this->user->getUserId());
		$favoritePlayer->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = FavoritePlayer::getFavoritePlayerByFavoritePlayerPlayerId($this->getPDO(), $this->player->getPlayerId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favoritePlayer"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\MlbScout\\FavoritePlayer", $results);
		// grab the result from the array and validate it
		$pdoFavoritePlayer = $results[0];
		$this->assertEquals($pdoFavoritePlayer->getPlayerId(), $this->player->getPlayerId());
		$this->assertEquals($pdoFavoritePlayer->getUserId(), $this->user->getUserId());
	}
	/**
	 * test grabbing a Favorite Player by a player id that does not exist
	 **/
	public function testGetInvalidFavoritePlayerByFavoritePlayerPlayerId() {
		// grab a player id that exceeds the maximum allowable player id
		$favoritePlayer = FavoritePlayer::getFavoritePlayerByFavoritePlayerPlayerId($this->getPDO(), MlbScoutTest::INVALID_KEY);
		$this->assertCount(0, $favoritePlayer);
	}
	/**
	 * test grabbing a Favorite Player by user id
	 **/
	public function testGetValidFavoritePlayerByFavoritePlayerUserId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favoritePlayer");
		// create a new Favorite Player and insert to into mySQL
		$favoritePlayer = new FavoritePlayer($this->player->getPlayerId(), $this->user->getUserId());
		$favoritePlayer->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = FavoritePlayer::getFavoritePlayerByFavoritePlayerUserId($this->getPDO(), $this->user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favoritePlayer"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\MlbScout\\FavoritePlayer", $results);
		// grab the result from the array and validate it
		$pdoFavoritePlayer = $results[0];
		$this->assertEquals($pdoFavoritePlayer->getPlayerId(), $this->player->getPlayerId());
		$this->assertEquals($pdoFavoritePlayer->getUserId(), $this->user->getUserId());
	}
	/**
	 * test grabbing a Favorite Player by a user id that does not exist
	 **/
	public function testGetInvalidFavoritePlayerByFavoritePlayerUserId() {
		// grab a player id that exceeds the maximum allowable user id
		$favoritePlayer = FavoritePlayer::getFavoritePlayerByFavoritePlayerUserId($this->getPDO(), MlbScoutTest::INVALID_KEY);
		$this->assertCount(0, $favoritePlayer);
	}
}