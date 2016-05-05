<?php
namespace Edu\Cnm\Llaudick\Mlbscout\Test;

// grab the project test parameters
require_once("MlbScoutTest.php");

// grab the class under scrutiny
require_once(player.php(__DIR__) . "/MlbScoutTest/php/classes/player/autoload.php");

/**
 * Full PHPUnit test for the player class
 *
 *
 *
 * @see player
 * @author Lucas Laudick <llaudick@cnm.edu>
 **/
class playerTest extends MlbScoutTest {
	/**
	 * player batting
	 * @var string $VALID_PLAYERBATTING
	 **/
	protected $VALID_PLAYERBATTING = "PHPUnit test passing";
	/**
	 * player batting left, right or switch
	 * @var string $VALID_PLAYERBATTING2
	 **/
	protected $VALID_PLAYERBATTING2 = "PHPUnit test still passing";
	/**
	 * player commitment to another school or team
	 * @var string $VALID_PLAYERCOMMITMENT
	 **/
	protected $VALID_PLAYERCOMMITMENT = "PHPUnit test passing";
	/**
	 * player commitment to another school or team  updated player
	 * @var string $VALID_PLAYERCOMMITMENT2
	 **/
	protected $VALID_PLAYERCOMMITMENT2 ="PHPUnit test still passing";
	/**
	 * players first name
	 * @var string $VALID_FIRSTNAME
	 **/
	protected $VALID_PLAYERFIRSTNAME = "PHPUnit test is passing";
	/**
	 * first name of updated player
	 * @var string $VALID_PLAYERFIRSTNAME2
	 **/
	protected $VALID_PLAYERFIRSTNAME2 = "PHPUnit test is still passing";
	/**
	 * players health status
	 * @var string $VALID_PLAYERHEALTHSTATUS
	 **/
	protected $VALID_PLAYERHEALTHSTATUS = "PHPUnit test is passing";
	/**
	 * health status of the updated player
	 * @var string $VALID_PLAYERHEALTHSTATUS2
	 **/
	protected $VALID_PLAYERHEALTHSTATUS2 = "PHPUnit test is still passing";
	/**
	 * players height
	 * @var int $VALID_PLAYERHEIGHT
	 **/
	protected $VALID_PLAYERHEIGHT = "PHPUnit test is passing";
	/**
	 * height of the updated player
	 * @var int $VALID_PLAYERHEIGHT2
	 **/
	protected $VALID_PLAYERHEIGHT2 = "PHPUnit test is still passing";
	/**
	 * player home town
	 * @var string $VALID_PLAYERHOMETOWN
	 **/
	protected $VALID_PLAYERHOMETOWN ="PHPUnit test is passing";
	/**
	 * home town of updated player
	 * @var string $VALID_PLAYERHOMETOWN2
	 **/
	protected $VALID_PLAYERHOMETOWN2 = "PHPUnit test is still passing";
	/**
	 * last name of player
	 * @var string $VALID_PLAYERLASTNAME
	 **/
	protected $VALID_PLAYERLASTNAME = "PHPUnit test is passing";
	/**
	 * last name of updated player
	 * @var string $VALID_PLAYERLASTNAME2
	 **/
	protected $VALID_PLAYERLASTNAME2 = "PHPUnit test is still passing";
	/**
	 * players position
	 * @var string $VALID_PLAYERPOSITION
	 **/
	protected $VALID_PLAYERPOSITION = "PHPUnit test is passing";
	/**
	 * updated players position
	 * @var string $VALID_PLAYERPOSITION2
	 **/
	protected $VALID_PLAYERPOSITION2 = "PHPUnit test is still passing";
	/**
	 * players thorwing hand
	 * @var string $VALID_PLAYERTHROWINGHAND
	 **/
	protected $VALID_PLAYERTHROWINGHAND = "PHPUnit test is passing";
	/**
	 * updated players throwing hand
	 * @var string $VALID_PLAYERTHROWINGHAND2
	 **/
	protected $VALID_PLAYERTHROWINGHAND2 ="PHPUnit test is still passing";
	/**
	 * players weight
	 * @var int $VALID_PLAYERWEIGHT
	 **/
	protected $VALID_PLAYERWEIGHT = "PHPUnit test is passing";
	/**
	 * players updated weight
	 * @var int $VALID_PLAYERWEIGHT2
	 **/
	protected $VALID_PLAYERWEIGHT2 = "PHPUnit test is still passing";
	/**
	 * playerTeam who the players play for; this is for foreign key relations
	 * @var Team PlayerTeam
	 **/
	protected $playerTeam = null;
	/**
	 * playerUser created the player; this is for foreign key relations
	 * @var User playerUser
	 **/
	protected $playerUser = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a playerUser to own the test playerUser
		$this->playerUser = new User(null, "MlbScoutTest", "test@phpunit.de");
		$this->playerTeam = new Team(null, "MlbScoutTest", "test@phpunit.de");
		$this->playerUser->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Player and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPlayer() {
		// count the number of rows and save it for lastInsertId
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new player and insert it into mySQL
		$player = new Player(null,$this->playerTeam->getPlayerTeamId(), $this->playerUser->getplayerUserId(), $this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPlayer = Player::getPlayerbyPlayerId($this->getPDO(), $player->getPlayerId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertEquals($pdoPlayer->getPlayerTeam(), $this->player->playerTeamId());
		$this->assertEquals($pdoPlayer->getPlayerUserId(), $this->player->playerUserId());
		$this->assertEquals($pdoPlayer->getPlayerBatting(). $this->VALID_PLAYERBATTING);
		$this->assertEquals($pdoPlayer->getPlayerCommitment(), $this->VALID_PLAYERCOMMITMENT);
		$this->assertEquals($pdoPlayer->getPlayerFirstName(), $this->VALID_PLAYERFIRSTNAME);
		$this->assertEquals($pdoPlayer->getPlayerHealthStatus(), $this->VALID_PLAYERHEALTHSTATUS);
		$this->assertEquals($pdoPlayer->getPlayerHeight(), $this->VALID_PLAYERHEIGHT);
		$this->assertEquals($pdoPlayer->getPlayerHomeTown(), $this->VALID_PLAYERHOMETOWN);
		$this->assertEquals($pdoPlayer->getPlayerLastName(), $this->VALID_PLAYERLASTNAME);
		$this->assertEquals($pdoPlayer->getPlayerPosition(), $this->VALID_PLAYERPOSITION);
		$this->assertEquals($pdoPlayer->getPlayerThrowingHand(), $this->VALID_PLAYERTHROWINGHAND);
		$this->assertEquals($pdoPlayer->getPlayerWeight(), $this->VALID_PLAYERWEIGHT);
	}
	/**
	 * test inserting a player that already exists
	 *
	 * @expectedException PDOException
	 */
	public function testInsertInvalidPlayer() {
		// create a player with a non null player id and watch it fail
		$player = new Player(MlbScoutTest::INVALID_KEY, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());
	}

	/**
	 * test inserting a Player, editing it, and then updating it
	 **/
	public function testUpdateValidPlayer() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new player and insert into mySQL
		$player = new Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(), $this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// edit the player and update it in mySQL
		$player->setPlayerBatting($this->VALID_PLAYERBATTING2);
		$player->setPlayerCommitment($this->VALID_PLAYERCOMMITMENT2);
		$player->setPlayerFirstName($this->VALID_PLAYERFIRSTNAME2);
		$player->setPlayerHealthStatus($this->VALID_PLAYERHEALTHSTATUS2);
		$player->setPlayerHeight($this->VALID_PLAYERHEIGHT2);
		$player->setPlayerhomeTown($this->VALID_PLAYERHOMETOWN2);
		$player->setPlayerLastName($this->VALID_PLAYERLASTNAME2);
		$player->setPlayerPosition($this->VALID_PLAYERPOSITION2);
		$player->setPlayerThrowingHand($this->VALID_PLAYERTHROWINGHAND2);
		$player->setPlayerWeight($this->VALID_PLAYERWEIGHT2);
		$player->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPlayer = Player::getPlayerbyPlayerId($this->getPDO(), $player->getPlayerId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertEquals($pdoPlayer->getPlayerTeam(), $this->player->playerTeamId());
		$this->assertEquals($pdoPlayer->getPlayerUserId(), $this->player->playerUserId());
		$this->assertEquals($pdoPlayer->getPlayerBatting(). $this->VALID_PLAYERBATTING);
		$this->assertEquals($pdoPlayer->getPlayerCommitment(), $this->VALID_PLAYERCOMMITMENT);
		$this->assertEquals($pdoPlayer->getPlayerFirstName(), $this->VALID_PLAYERFIRSTNAME);
		$this->assertEquals($pdoPlayer->getPlayerHealthStatus(), $this->VALID_PLAYERHEALTHSTATUS);
		$this->assertEquals($pdoPlayer->getPlayerHeight(), $this->VALID_PLAYERHEIGHT);
		$this->assertEquals($pdoPlayer->getPlayerHomeTown(), $this->VALID_PLAYERHOMETOWN);
		$this->assertEquals($pdoPlayer->getPlayerLastName(), $this->VALID_PLAYERLASTNAME);
		$this->assertEquals($pdoPlayer->getPlayerPosition(), $this->VALID_PLAYERPOSITION);
		$this->assertEquals($pdoPlayer->getPlayerThrowingHand(), $this->VALID_PLAYERTHROWINGHAND);
		$this->assertEquals($pdoPlayer->getPlayerWeight(), $this->VALID_PLAYERWEIGHT);
   }

	/**
	 * test updating a player that already exists
	 *
	 * @expectedException
	 */
	public function testUpdatedInvalidPlayer() {
		// create a player wiht a non null player id and watch it fail
		$player = new Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->update($this->getPDO());
	}

	/**
	 * test creating a player and then deleting it
	 */
	public function testDeleteValidPlayer() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new player and insert it into mySQL
		$player = new player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// delete the player form mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$player->delete($this->getPDO);

		// grab the data from mySQL and enforce the Player does not exist
		$pdoPlayer = Player::getPlayerByPlayerId($this->getPDO(), $player->getPlayerId());
		$this->assertNull($pdoPlayer);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("player"));
	}

	/**
	 * test deleting a player that does not exist
	 *
	 * @expecedException PDOException
	 */
	public function testDeleteInvalidPlayer() {
		// create a player and try to delete it without actually inserting it
		$player = new Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);;
		$player->delete($this->getPDO());
	}

	/**
	 * test inserting a player and regrabbing it from mySQL
	 */
	public function testGetValidPlayerByPlayerId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new player and insert into mySQL
		$player= new Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPlayer = Player::getPlayerbyPlayerId($this->getPDO(), $player->getPlayerId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertEquals($pdoPlayer->getPlayerTeam(), $this->player->playerTeamId());
		$this->assertEquals($pdoPlayer->getPlayerUserId(), $this->player->playerUserId());
		$this->assertEquals($pdoPlayer->getPlayerBatting(). $this->VALID_PLAYERBATTING);
		$this->assertEquals($pdoPlayer->getPlayerCommitment(), $this->VALID_PLAYERCOMMITMENT);
		$this->assertEquals($pdoPlayer->getPlayerFirstName(), $this->VALID_PLAYERFIRSTNAME);
		$this->assertEquals($pdoPlayer->getPlayerHealthStatus(), $this->VALID_PLAYERHEALTHSTATUS);
		$this->assertEquals($pdoPlayer->getPlayerHeight(), $this->VALID_PLAYERHEIGHT);
		$this->assertEquals($pdoPlayer->getPlayerHomeTown(), $this->VALID_PLAYERHOMETOWN);
		$this->assertEquals($pdoPlayer->getPlayerLastName(), $this->VALID_PLAYERLASTNAME);
		$this->assertEquals($pdoPlayer->getPlayerPosition(), $this->VALID_PLAYERPOSITION);
		$this->assertEquals($pdoPlayer->getPlayerThrowingHand(), $this->VALID_PLAYERTHROWINGHAND);
		$this->assertEquals($pdoPlayer->getPlayerWeight(), $this->VALID_PLAYERWEIGHT);
	}

	/**
	 * test grabbing a player that does not exist
	 */
	public function testGetInvalidPlayerByPlayerId() {
		// grab a playerUser id that exceeds the maximum allowable playerUser id
		$player = Player::GetPlayerByPlayerId($this->getPDO(), MlbScoutTest::INVALID_KEY);
		$this->assertNull($player);
	}

	/**
	 * test grabbing a player by playerBatting
	 */
	public function testGetValidPlayerByPlayerBatting() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new player and insert it into mySQL
		$player = new Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Player::getPlayerByPlayerId($this->getPDO(), $player->getPlayerBatting());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertCount(1, $results);
		$this->assertContainsOnyInstancesOf("Edu\\Cnm\\Llaudick\\MlbScout\\Player", $results);

		// grab the result from the array and validate it
		$pdoPlayer = $results[0];
		$this->assertEquals($pdoPlayer->getPlayerUserId(), $this->playerUser->getPlayerUserId());
		$this->assertEquals($pdoPlayer->getPlayerBatting(), $this->VALID_PLAYERBATTING);
		$this->assertEquals($pdoPlayer->getPlayerCommitment(), $this->VALID_PLAYERCOMMITMENT);
		$this->assertEquals($pdoPlayer->getPlayerFirstName(), $this->VALID_PLAYERFIRSTNAME);
		$this->assertEquals($pdoPlayer->getPlayerHealthStatus(), $this->VALID_PLAYERHEALTHSTATUS);
		$this->assertEquals($pdoPlayer->getPlayerHeight(), $this->VALID_PLAYERHEIGHT);
		$this->assertEquals($pdoPlayer->getPlayerHomeTown(), $this->VALID_PLAYERHOMETOWN);
		$this->assertEquals($pdoPlayer->getPlayerLastName(), $this->VALID_PLAYERLASTNAME);
		$this->assertEquals($pdoPlayer->getPlayerPosition(), $this->VALID_PLAYERPOSITION);
		$this->assertEquals($pdoPlayer->getPlayerThrowingHand(), $this->VALID_PLAYERTHROWINGHAND);
		$this->assertEquals($pdoPlayer->getPlayerWeight(), $this->VALID_PLAYERWEIGHT);
	}

	/**
	 * test grabbing a player by batting that does not exist
	 */
	public function testGetInvalidPlayerByPlayerBatting() {
		// grab a player by searching for batting that does not exist
		$player = Player::getPlayerByPlayerBatting($this->getPDO(), "nothing will be found");
		$this->assertCount(0, $player);
	}

	/**
	 * test grabbing a player by playerCommitment
	 */
	public function testGetValidPlayerByPlayerCommitment() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new player and insert it into mySQL
		$player = new Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Player::getPlayerByPlayerId($this->getPDO(), $player->getPlayerCommitment());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertCount(1, $results);
		$this->assertContainsOnyInstancesOf("Edu\\Cnm\\Llaudick\\MlbScout\\Player", $results);

		// grab the result from the array and validate it
		$pdoPlayer = $results[0];
		$this->assertEquals($pdoPlayer->getPlayerUserId(), $this->playerUser->getPlayerUserId());
		$this->assertEquals($pdoPlayer->getPlayerBatting(), $this->VALID_PLAYERBATTING);
		$this->assertEquals($pdoPlayer->getPlayerCommitment(), $this->VALID_PLAYERCOMMITMENT);
		$this->assertEquals($pdoPlayer->getPlayerFirstName(), $this->VALID_PLAYERFIRSTNAME);
		$this->assertEquals($pdoPlayer->getPlayerHealthStatus(), $this->VALID_PLAYERHEALTHSTATUS);
		$this->assertEquals($pdoPlayer->getPlayerHeight(), $this->VALID_PLAYERHEIGHT);
		$this->assertEquals($pdoPlayer->getPlayerHomeTown(), $this->VALID_PLAYERHOMETOWN);
		$this->assertEquals($pdoPlayer->getPlayerLastName(), $this->VALID_PLAYERLASTNAME);
		$this->assertEquals($pdoPlayer->getPlayerPosition(), $this->VALID_PLAYERPOSITION);
		$this->assertEquals($pdoPlayer->getPlayerThrowingHand(), $this->VALID_PLAYERTHROWINGHAND);
		$this->assertEquals($pdoPlayer->getPlayerWeight(), $this->VALID_PLAYERWEIGHT);
	}

	/**
	 * test grabbing a player by commitment that does not exist
	 */
	public function testGetInvalidPlayerByPlayercommitment() {
		// grab a player by searching for Commitment that does not exist
		$player = Player::getPlayerByPlayerCommitment($this->getPDO(), "nothing will be found");
		$this->assertCount(0, $player);
	}

	/**
	 * test grabbing a player by playerFirstName
	 */
	public function testGetValidPlayerByPlayerFirstName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new player and insert it into mySQL
		$player = new Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Player::getPlayerByPlayerId($this->getPDO(), $player->getPlayerFirstName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertCount(1, $results);
		$this->assertContainsOnyInstancesOf("Edu\\Cnm\\Llaudick\\MlbScout\\Player", $results);

		// grab the result from the array and validate it
		$pdoPlayer = $results[0];
		$this->assertEquals($pdoPlayer->getPlayerUserId(), $this->playerUser->getPlayerUserId());
		$this->assertEquals($pdoPlayer->getPlayerBatting(), $this->VALID_PLAYERBATTING);
		$this->assertEquals($pdoPlayer->getPlayerCommitment(), $this->VALID_PLAYERCOMMITMENT);
		$this->assertEquals($pdoPlayer->getPlayerFirstName(), $this->VALID_PLAYERFIRSTNAME);
		$this->assertEquals($pdoPlayer->getPlayerHealthStatus(), $this->VALID_PLAYERHEALTHSTATUS);
		$this->assertEquals($pdoPlayer->getPlayerHeight(), $this->VALID_PLAYERHEIGHT);
		$this->assertEquals($pdoPlayer->getPlayerHomeTown(), $this->VALID_PLAYERHOMETOWN);
		$this->assertEquals($pdoPlayer->getPlayerLastName(), $this->VALID_PLAYERLASTNAME);
		$this->assertEquals($pdoPlayer->getPlayerPosition(), $this->VALID_PLAYERPOSITION);
		$this->assertEquals($pdoPlayer->getPlayerThrowingHand(), $this->VALID_PLAYERTHROWINGHAND);
		$this->assertEquals($pdoPlayer->getPlayerWeight(), $this->VALID_PLAYERWEIGHT);
	}

	/**
	 * test grabbing a player by First Name that does not exist
	 */
	public function testGetInvalidPlayerByPlayerFirstName() {
		// grab a player by searching for First Name that does not exist
		$player = Player::getPlayerByPlayerFirstName($this->getPDO(), "nothing will be found");
		$this->assertCount(0, $player);
	}

	/**
	 * test grabbing a player by playerHealthStatus
	 */
	public function testGetValidPlayerByPlayerHealthStatus() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new player and insert it into mySQL
		$player = new Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Player::getPlayerByPlayerId($this->getPDO(), $player->getPlayerHealthStatus());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertCount(1, $results);
		$this->assertContainsOnyInstancesOf("Edu\\Cnm\\Llaudick\\MlbScout\\Player", $results);

		// grab the result from the array and validate it
		$pdoPlayer = $results[0];
		$this->assertEquals($pdoPlayer->getPlayerUserId(), $this->playerUser->getPlayerUserId());
		$this->assertEquals($pdoPlayer->getPlayerBatting(), $this->VALID_PLAYERBATTING);
		$this->assertEquals($pdoPlayer->getPlayerCommitment(), $this->VALID_PLAYERCOMMITMENT);
		$this->assertEquals($pdoPlayer->getPlayerFirstName(), $this->VALID_PLAYERFIRSTNAME);
		$this->assertEquals($pdoPlayer->getPlayerHealthStatus(), $this->VALID_PLAYERHEALTHSTATUS);
		$this->assertEquals($pdoPlayer->getPlayerHeight(), $this->VALID_PLAYERHEIGHT);
		$this->assertEquals($pdoPlayer->getPlayerHomeTown(), $this->VALID_PLAYERHOMETOWN);
		$this->assertEquals($pdoPlayer->getPlayerLastName(), $this->VALID_PLAYERLASTNAME);
		$this->assertEquals($pdoPlayer->getPlayerPosition(), $this->VALID_PLAYERPOSITION);
		$this->assertEquals($pdoPlayer->getPlayerThrowingHand(), $this->VALID_PLAYERTHROWINGHAND);
		$this->assertEquals($pdoPlayer->getPlayerWeight(), $this->VALID_PLAYERWEIGHT);
	}

	/**
	 * test grabbing a player by Health Status that does not exist
	 */
	public function testGetInvalidPlayerByPlayerHealthStatus() {
		// grab a player by searching for Health Status that does not exist
		$player = Player::getPlayerByPlayerHealthStatus($this->getPDO(), "nothing will be found");
		$this->assertCount(0, $player);
	}

	/**
	 * test grabbing a player by playerHeight
	 */
	public function testGetValidPlayerByPlayerHeight() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new player and insert it into mySQL
		$player = new Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Player::getPlayerByPlayerId($this->getPDO(), $player->getPlayerHeight());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertCount(1, $results);
		$this->assertContainsOnyInstancesOf("Edu\\Cnm\\Llaudick\\MlbScout\\Player", $results);

		// grab the result from the array and validate it
		$pdoPlayer = $results[0];
		$this->assertEquals($pdoPlayer->getPlayerUserId(), $this->playerUser->getPlayerUserId());
		$this->assertEquals($pdoPlayer->getPlayerBatting(), $this->VALID_PLAYERBATTING);
		$this->assertEquals($pdoPlayer->getPlayerCommitment(), $this->VALID_PLAYERCOMMITMENT);
		$this->assertEquals($pdoPlayer->getPlayerFirstName(), $this->VALID_PLAYERFIRSTNAME);
		$this->assertEquals($pdoPlayer->getPlayerHealthStatus(), $this->VALID_PLAYERHEALTHSTATUS);
		$this->assertEquals($pdoPlayer->getPlayerHeight(), $this->VALID_PLAYERHEIGHT);
		$this->assertEquals($pdoPlayer->getPlayerHomeTown(), $this->VALID_PLAYERHOMETOWN);
		$this->assertEquals($pdoPlayer->getPlayerLastName(), $this->VALID_PLAYERLASTNAME);
		$this->assertEquals($pdoPlayer->getPlayerPosition(), $this->VALID_PLAYERPOSITION);
		$this->assertEquals($pdoPlayer->getPlayerThrowingHand(), $this->VALID_PLAYERTHROWINGHAND);
		$this->assertEquals($pdoPlayer->getPlayerWeight(), $this->VALID_PLAYERWEIGHT);
	}

	/**
	 * test grabbing a player by Height that does not exist
	 */
	public function testGetInvalidPlayerByPlayerHeight() {
		// grab a player by searching for Height that does not exist
		$player = Player::getPlayerByPlayerHeight($this->getPDO(), "nothing will be found");
		$this->assertCount(0, $player);
	}

	/**
	 * test grabbing a player by playerHomeTown
	 */
	public function testGetValidPlayerByPlayerHomeTown() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new player and insert it into mySQL
		$player = new Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Player::getPlayerByPlayerId($this->getPDO(), $player->getPlayerHomeTown());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertCount(1, $results);
		$this->assertContainsOnyInstancesOf("Edu\\Cnm\\Llaudick\\MlbScout\\Player", $results);

		// grab the result from the array and validate it
		$pdoPlayer = $results[0];
		$this->assertEquals($pdoPlayer->getPlayerUserId(), $this->playerUser->getPlayerUserId());
		$this->assertEquals($pdoPlayer->getPlayerBatting(), $this->VALID_PLAYERBATTING);
		$this->assertEquals($pdoPlayer->getPlayerCommitment(), $this->VALID_PLAYERCOMMITMENT);
		$this->assertEquals($pdoPlayer->getPlayerFirstName(), $this->VALID_PLAYERFIRSTNAME);
		$this->assertEquals($pdoPlayer->getPlayerHealthStatus(), $this->VALID_PLAYERHEALTHSTATUS);
		$this->assertEquals($pdoPlayer->getPlayerHeight(), $this->VALID_PLAYERHEIGHT);
		$this->assertEquals($pdoPlayer->getPlayerHomeTown(), $this->VALID_PLAYERHOMETOWN);
		$this->assertEquals($pdoPlayer->getPlayerLastName(), $this->VALID_PLAYERLASTNAME);
		$this->assertEquals($pdoPlayer->getPlayerPosition(), $this->VALID_PLAYERPOSITION);
		$this->assertEquals($pdoPlayer->getPlayerThrowingHand(), $this->VALID_PLAYERTHROWINGHAND);
		$this->assertEquals($pdoPlayer->getPlayerWeight(), $this->VALID_PLAYERWEIGHT);
	}

	/**
	 * test grabbing a player by HomeTown that does not exist
	 */
	public function testGetInvalidPlayerByPlayerHomeTown() {
		// grab a player by searching for HomeTown that does not exist
		$player = Player::getPlayerByPlayerHomeTown($this->getPDO(), "nothing will be found");
		$this->assertCount(0, $player);
	}

	/**
	 * test grabbing a player by playerLastName
	 */
	public function testGetValidPlayerByPlayerLastName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new player and insert it into mySQL
		$player = new Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Player::getPlayerByPlayerId($this->getPDO(), $player->getPlayerLastName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertCount(1, $results);
		$this->assertContainsOnyInstancesOf("Edu\\Cnm\\Llaudick\\MlbScout\\Player", $results);

		// grab the result from the array and validate it
		$pdoPlayer = $results[0];
		$this->assertEquals($pdoPlayer->getPlayerUserId(), $this->playerUser->getPlayerUserId());
		$this->assertEquals($pdoPlayer->getPlayerBatting(), $this->VALID_PLAYERBATTING);
		$this->assertEquals($pdoPlayer->getPlayerCommitment(), $this->VALID_PLAYERCOMMITMENT);
		$this->assertEquals($pdoPlayer->getPlayerFirstName(), $this->VALID_PLAYERFIRSTNAME);
		$this->assertEquals($pdoPlayer->getPlayerHealthStatus(), $this->VALID_PLAYERHEALTHSTATUS);
		$this->assertEquals($pdoPlayer->getPlayerHeight(), $this->VALID_PLAYERHEIGHT);
		$this->assertEquals($pdoPlayer->getPlayerHomeTown(), $this->VALID_PLAYERHOMETOWN);
		$this->assertEquals($pdoPlayer->getPlayerLastName(), $this->VALID_PLAYERLASTNAME);
		$this->assertEquals($pdoPlayer->getPlayerPosition(), $this->VALID_PLAYERPOSITION);
		$this->assertEquals($pdoPlayer->getPlayerThrowingHand(), $this->VALID_PLAYERTHROWINGHAND);
		$this->assertEquals($pdoPlayer->getPlayerWeight(), $this->VALID_PLAYERWEIGHT);
	}

	/**
	 * test grabbing a player by LastName that does not exist
	 */
	public function testGetInvalidPlayerByPlayerLastName() {
		// grab a player by searching for LastName that does not exist
		$player = Player::getPlayerByPlayerLastName($this->getPDO(), "nothing will be found");
		$this->assertCount(0, $player);
	}

	/**
	 * test grabbing a player by playerPosition
	 */
	public function testGetValidPlayerByPlayerPosition() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new player and insert it into mySQL
		$player = new Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Player::getPlayerByPlayerId($this->getPDO(), $player->getPlayerPosition());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertCount(1, $results);
		$this->assertContainsOnyInstancesOf("Edu\\Cnm\\Llaudick\\MlbScout\\Player", $results);

		// grab the result from the array and validate it
		$pdoPlayer = $results[0];
		$this->assertEquals($pdoPlayer->getPlayerUserId(), $this->playerUser->getPlayerUserId());
		$this->assertEquals($pdoPlayer->getPlayerBatting(), $this->VALID_PLAYERBATTING);
		$this->assertEquals($pdoPlayer->getPlayerCommitment(), $this->VALID_PLAYERCOMMITMENT);
		$this->assertEquals($pdoPlayer->getPlayerFirstName(), $this->VALID_PLAYERFIRSTNAME);
		$this->assertEquals($pdoPlayer->getPlayerHealthStatus(), $this->VALID_PLAYERHEALTHSTATUS);
		$this->assertEquals($pdoPlayer->getPlayerHeight(), $this->VALID_PLAYERHEIGHT);
		$this->assertEquals($pdoPlayer->getPlayerHomeTown(), $this->VALID_PLAYERHOMETOWN);
		$this->assertEquals($pdoPlayer->getPlayerLastName(), $this->VALID_PLAYERLASTNAME);
		$this->assertEquals($pdoPlayer->getPlayerPosition(), $this->VALID_PLAYERPOSITION);
		$this->assertEquals($pdoPlayer->getPlayerThrowingHand(), $this->VALID_PLAYERTHROWINGHAND);
		$this->assertEquals($pdoPlayer->getPlayerWeight(), $this->VALID_PLAYERWEIGHT);
	}

	/**
	 * test grabbing a player by Position that does not exist
	 */
	public function testGetInvalidPlayerByPlayerPosition() {
		// grab a player by searching for Position that does not exist
		$player = Player::getPlayerByPlayerPosition($this->getPDO(), "nothing will be found");
		$this->assertCount(0, $player);
	}

	/**
	 * test grabbing a player by playerThrowingHand
	 */
	public function testGetValidPlayerByPlayerThrowingHand() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new player and insert it into mySQL
		$player = new Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Player::getPlayerByPlayerId($this->getPDO(), $player->getPlayerThrowingHand());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertCount(1, $results);
		$this->assertContainsOnyInstancesOf("Edu\\Cnm\\Llaudick\\MlbScout\\Player", $results);

		// grab the result from the array and validate it
		$pdoPlayer = $results[0];
		$this->assertEquals($pdoPlayer->getPlayerUserId(), $this->playerUser->getPlayerUserId());
		$this->assertEquals($pdoPlayer->getPlayerBatting(), $this->VALID_PLAYERBATTING);
		$this->assertEquals($pdoPlayer->getPlayerCommitment(), $this->VALID_PLAYERCOMMITMENT);
		$this->assertEquals($pdoPlayer->getPlayerFirstName(), $this->VALID_PLAYERFIRSTNAME);
		$this->assertEquals($pdoPlayer->getPlayerHealthStatus(), $this->VALID_PLAYERHEALTHSTATUS);
		$this->assertEquals($pdoPlayer->getPlayerHeight(), $this->VALID_PLAYERHEIGHT);
		$this->assertEquals($pdoPlayer->getPlayerHomeTown(), $this->VALID_PLAYERHOMETOWN);
		$this->assertEquals($pdoPlayer->getPlayerLastName(), $this->VALID_PLAYERLASTNAME);
		$this->assertEquals($pdoPlayer->getPlayerPosition(), $this->VALID_PLAYERPOSITION);
		$this->assertEquals($pdoPlayer->getPlayerThrowingHand(), $this->VALID_PLAYERTHROWINGHAND);
		$this->assertEquals($pdoPlayer->getPlayerWeight(), $this->VALID_PLAYERWEIGHT);
	}

	/**
	 * test grabbing a player by batting that does not exist
	 */
	public function testGetInvalidPlayerByPlayerThrowingHand() {
		// grab a player by searching for ThrowingHand that does not exist
		$player = Player::getPlayerByPlayerThrowingHand($this->getPDO(), "nothing will be found");
		$this->assertCount(0, $player);
	}

	/**
	 * test grabbing a player by playerWeight
	 */
	public function testGetValidPlayerByPlayerWeight() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new player and insert it into mySQL
		$player = new Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Player::getPlayerByPlayerId($this->getPDO(), $player->getPlayerWeight());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertCount(1, $results);
		$this->assertContainsOnyInstancesOf("Edu\\Cnm\\Llaudick\\MlbScout\\Player", $results);

		// grab the result from the array and validate it
		$pdoPlayer = $results[0];
		$this->assertEquals($pdoPlayer->getPlayerUserId(), $this->playerUser->getPlayerUserId());
		$this->assertEquals($pdoPlayer->getPlayerBatting(), $this->VALID_PLAYERBATTING);
		$this->assertEquals($pdoPlayer->getPlayerCommitment(), $this->VALID_PLAYERCOMMITMENT);
		$this->assertEquals($pdoPlayer->getPlayerFirstName(), $this->VALID_PLAYERFIRSTNAME);
		$this->assertEquals($pdoPlayer->getPlayerHealthStatus(), $this->VALID_PLAYERHEALTHSTATUS);
		$this->assertEquals($pdoPlayer->getPlayerHeight(), $this->VALID_PLAYERHEIGHT);
		$this->assertEquals($pdoPlayer->getPlayerHomeTown(), $this->VALID_PLAYERHOMETOWN);
		$this->assertEquals($pdoPlayer->getPlayerLastName(), $this->VALID_PLAYERLASTNAME);
		$this->assertEquals($pdoPlayer->getPlayerPosition(), $this->VALID_PLAYERPOSITION);
		$this->assertEquals($pdoPlayer->getPlayerThrowingHand(), $this->VALID_PLAYERTHROWINGHAND);
		$this->assertEquals($pdoPlayer->getPlayerWeight(), $this->VALID_PLAYERWEIGHT);
	}

	/**
	 * test grabbing a player by batting that does not exist
	 */
	public function testGetInvalidPlayerByPlayerWeight() {
		// grab a player by searching for Weight that does not exist
		$player = Player::getPlayerByPlayerWeight($this->getPDO(), "nothing will be found");
		$this->assertCount(0, $player);
	}

	/**
	 * test grabbing all players
	 */
	public function testGetAllValidPlayers() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("player");

		// create a new Player and insert it into mySQL
		$player = Player(null, $this->playerTeam->getPlayerTeamId(), $this->playerUser->getPlayerUserId(),$this->VALID_PLAYERBATTING, $this->VALID_PLAYERCOMMITMENT, $this->VALID_PLAYERFIRSTNAME, $this->VALID_PLAYERHEALTHSTATUS, $this->VALID_PLAYERHEIGHT, $this->VALID_PLAYERHOMETOWN, $this->VALID_PLAYERLASTNAME, $this->VALID_PLAYERPOSITION, $this->VALID_PLAYERTHROWINGHAND, $this->VALID_PLAYERWEIGHT);
		$player->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Player::getPlayerByPlayerId($this->getPDO(), $player->getPlayerWeight());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("player"));
		$this->assertCount(1, $results);
		$this->assertContainsOnyInstancesOf("Edu\\Cnm\\Llaudick\\MlbScout\\Player", $results);

		// grab the result from the array and validate it
		$pdoPlayer = $results[0];
		$this->assertEquals($pdoPlayer->getPlayerUserId(), $this->playerUser->getPlayerUserId());
		$this->assertEquals($pdoPlayer->getPlayerBatting(), $this->VALID_PLAYERBATTING);
		$this->assertEquals($pdoPlayer->getPlayerCommitment(), $this->VALID_PLAYERCOMMITMENT);
		$this->assertEquals($pdoPlayer->getPlayerFirstName(), $this->VALID_PLAYERFIRSTNAME);
		$this->assertEquals($pdoPlayer->getPlayerHealthStatus(), $this->VALID_PLAYERHEALTHSTATUS);
		$this->assertEquals($pdoPlayer->getPlayerHeight(), $this->VALID_PLAYERHEIGHT);
		$this->assertEquals($pdoPlayer->getPlayerHomeTown(), $this->VALID_PLAYERHOMETOWN);
		$this->assertEquals($pdoPlayer->getPlayerLastName(), $this->VALID_PLAYERLASTNAME);
		$this->assertEquals($pdoPlayer->getPlayerPosition(), $this->VALID_PLAYERPOSITION);
		$this->assertEquals($pdoPlayer->getPlayerThrowingHand(), $this->VALID_PLAYERTHROWINGHAND);
		$this->assertEquals($pdoPlayer->getPlayerWeight(), $this->VALID_PLAYERWEIGHT);
	}
}