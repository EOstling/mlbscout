<?php
namespace  Edu\Cnm\MlbScout\Test;

use Edu\Cnm\MlbScout\{AccessLevel, User};


/**
 * Full Unit test for Api Call Class.
 *	@see apiCall class
 * @author Eliot Robert Ostling <it.treugott@gmail.com>
 **/

require_once("MlbScoutTest.php");


require_once(dirname(__DIR__) . "/php/classes/autoload.php");

class ApiCallTest extends MlbScoutTest {

	/**
	 * @var string $VALID_ApiCallBrowser
	 *
	 */
	protected $VALID_ApiCallBrowser = "Safari";
	/**
	 * @var null $VALID_ApiCallDateTime
	 */
	protected $VALID_ApiCallDateTime = null;
	/**
	 * @var string$VALID_ApiCallHttpVerb
	 */
	protected $VALID_ApiCallHttpVerb = "GET";
	/**
	 * @var string $VALID_ApiCallHttpVerb2
	 */
	protected $VALID_ApiCallHttpVerb2= "POST";
	/**
	 * @var string $VALID_ApiCallIP
	 */
	protected $VALID_ApiCallIP = "127.0.0.1";
	/**
	 * @var string $VALID_ApiCallQueryString
	 */
	protected $VALID_ApiCallQueryString = "TestString";
	/**
	 * @var string $VALID_ApiCallPayload
	 */
	protected $VALID_ApiCallPayload = "TestPayload";
	/**
	 * @var string $VALID_ApiCallUrl
	 */
	protected $VALID_ApiCallUrl = "google.com";
	/**
	 * @var null $VALID_ApiCallUserId
	 */
	protected $VALID_ApiCallUserId = null;
	/**
	 * @var int $hash
	 */
	private $hash;
	/**
	 * @var int $salt
	 */
	private $salt;
	/**
	 * @var string $user
	 */
	private $user;
	/**
	 * @var int $accessLevel
	 * AccessLevel
	 */
	protected $accessLevel= null;

	//Creating the setup objects before testing
	/**
	 * Setup() function
	 */

	public final function setUp() {
		//setup method first
		parent::setUp();
		//Create state variables of string & integer
		$this->accessLevel = new AccessLevel(null, "accessLevelName");
		$this->accessLevel->insert($this->getPDO());
		$this->salt = bin2hex(random_bytes(32));
		$this->hash = hash_pbkdf2("sha512", "123456", $this->salt, 4096);
		$this->user = new User(null, $this->accessLevel->getAccessLevelId(), null, "userEmail@foo.com",
			"Tyrion", $this->hash, "Lannister", "8675309", $this->salt);
		$this->user->insert($this->getPDO());
		$this->ApiCallDateTime = new \DateTime();
	}

	/**
	 *Testing a valid apicall id
	 */

	public function testInsertValidApiCall() {

		/**
		 * count the number of rows and save it for later
		 **/
		$numRows = $this->getConnection()->getRowCount("apiCall");
		// create a Datetime and insert it into mySQL
		$apiCall = new ApiCall (null, $this->VALID_ApiCallUserId , $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			$this->VALID_ApiCallUrl);
			$apiCall->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoApiCall = ApiCall::getApiCallbyUserId($this->getPDO(), $apiCall->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("apiCall"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->VALID_ApiCallUserId->getUser());
		$this->assertEquals($pdoApiCall->getQuery(), $this->VALID_ApiCallQueryString);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_ApiCallDateTime);
		$this->assertEquals($pdoApiCall->getUrl(), $this->VALID_ApiCallUrl);
		$this->assertEquals($pdoApiCall->getHttPVerb(), $this->VALID_ApiCallHttpVerb);
		$this->assertEquals($pdoApiCall->getBrowser(), $this->VALID_ApiCallBrowser);
		$this->assertEquals($pdoApiCall->getIP(), $this->VALID_ApiCallIP);
		$this->assertEquals($pdoApiCall->getPayload(), $this->VALID_ApiCallPayload);
	}

	/**
	 * test inserting a DateTime that already exists
	 *
	 * @expectedException \PDOException
	 **/

	public function testInsertInvalidApiCall() {
		// create a DateTime with a non null Date id and watch it fail
		$apiCall = new ApiCall(MlbScoutTest::INVALID_KEY, $this->VALID_ApiCallUserId, $this->VALID_ApiCallBrowser ,
			$this->VALID_ApiCallDateTime, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallUserId, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallPayload, $this->VALID_ApiCallUrl);

		$apiCall->insert($this->getPDO());
		// try to insert a second time and watch it fail
		$apiCall->insert($this->getPDO());
	}

	/**
	 *Testing a valid ApiCall
	 */

	public function testUpdateValidApiCall() {

		$numRows = $this->getConnection()->getRowCount("apiCall");
		$apiCall = new ApiCall(null, $this->VALID_ApiCallUserId, $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			$this->VALID_ApiCallUrl);
		$apiCall->insert($this->getPDO());
		// edit the ApiCall and update it in mySQL
		$apiCall->setQueryString($this->VALID_ApiCallHttpVerb2);
		$apiCall->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoApiCall = ApiCall::getApicallbyUserId($this->getPDO(), $apiCall->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("apiCall"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->VALID_ApiCallUserId->getUserId());
		$this->assertEquals($pdoApiCall->getQuery(), $this->VALID_ApiCallQueryString);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_ApiCallDateTime);
		$this->assertEquals($pdoApiCall->getUrl(), $this->VALID_ApiCallUrl);
		//Send in Httpverb2
		$this->assertEquals($pdoApiCall->getHttpVerb(), $this->VALID_ApiCallHttpVerb2);
		$this->assertEquals($pdoApiCall->getBrowser(), $this->VALID_ApiCallBrowser);
		$this->assertEquals($pdoApiCall->getIP(), $this->VALID_ApiCallIP);
		$this->assertEquals($pdoApiCall->getPayload(), $this->VALID_ApiCallPayload);
	}

	/**
	 * Give an invalid ApiCall
	 *  @expectedException \PDOException
	 */
	public function testUpdateInvalidApiCall() {
		$apiCall = new ApiCall (null, $this->VALID_ApiCallUserId , $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			  $this->VALID_ApiCallUrl);
		$apiCall->update($this->getPDO());
	}

	/**
	 * Delete by primary key by testing a valid ApiCall
	 */
	public function testDeleteValidApiCall() {

		$numRows = $this->getConnection()->getRowCount("apiCall");
		$apiCall = new ApiCall(null, $this->VALID_ApiCallUserId , $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			  $this->VALID_ApiCallUrl);
		$apiCall->insert($this->getPDO());
		// delete the ApiCall from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("apiCall"));
		$apiCall->delete($this->getPDO());
		// grab the data from mySQL and enforce the ApiCall does not exist
		$pdoApiCall = ApiCall::getApiCallByUserId($this->getPDO(), $apiCall->getApiCallId());
		$this->assertNull($pdoApiCall);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("apiCall"));
	}

	/**
	 * Test invalid delete Invalid ApiCall
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidApiCall() {
		// create a ApiCall and try to delete it without actually inserting it
		$ApiCall = new ApiCall(null, $this->VALID_ApiCallUserId, $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			$this->VALID_ApiCallUrl);
		$ApiCall->delete($this->getPDO());
	}

	/**
	 *testing valid call id
	 */
	public function testGetValidApiCallbyCallId() {
		$numRows = $this->getConnection()->getRowCount("apiCall");
		//Create a new ApiCall and insert into mySQL

		$apiCall = new ApiCall(null, $this->VALID_ApiCallUserId , $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			  $this->VALID_ApiCallUrl);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCall = Apicall::getApiCallbyUserId($this->getPDO(), $apiCall->getCallId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("apiCall"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->VALID_ApiCallUserId->getUserId());
		$this->assertEquals($pdoApiCall->getQuery(), $this->VALID_ApiCallQueryString);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_ApiCallDateTime);
		$this->assertEquals($pdoApiCall->getUrl(), $this->VALID_ApiCallUrl);
		$this->assertEquals($pdoApiCall->getHTTPVerb(), $this->VALID_ApiCallHttpVerb);
		$this->assertEquals($pdoApiCall->getBrowser(), $this->VALID_ApiCallBrowser);
		$this->assertEquals($pdoApiCall->getIP(), $this->VALID_ApiCallIP);
		$this->assertEquals($pdoApiCall->getPayload(), $this->VALID_ApiCallPayload);
	}

	/**
	 * Testing invalid api call id
	 */
	public function testGetInvalidApiCallbyCallId() {
		//Grab an invalid Call Id that exceeds
		$ApiCall = ApiCall::getApiCallByCallId($this->getPDO(), MlbScoutTest::INVALID_KEY);
		$this->assertNull($ApiCall);
	}

	/**
	 *Getting a valid user id
	 */
	public function testGetValidApiCallbyUserId() {
		$numRows = $this->getConnection()->getRowCount("apiCall");
		//Create a new ApiCall and insert into mySQL
		$apiCall = new ApiCall(null, $this->VALID_ApiCallUserId , $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			$this->VALID_ApiCallUrl);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCalls = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getUserId());
		foreach($pdoApiCalls as $pdoApiCall) {
			if($pdoApiCall->getApiCallUserId() === $apiCall->getApiCallUserId()) {
				$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("apiCall"));
				$this->assertEquals($pdoApiCall->getUserId(), $this->VALID_ApiCallUserId->getUserId());
				$this->assertEquals($pdoApiCall->getQuery(), $this->VALID_ApiCallQueryString);
				$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_ApiCallDateTime);
				$this->assertEquals($pdoApiCall->getUrl(), $this->VALID_ApiCallUrl);
				$this->assertEquals($pdoApiCall->getHTTPVerb(), $this->VALID_ApiCallHttpVerb);
				$this->assertEquals($pdoApiCall->getBrowser(), $this->VALID_ApiCallBrowser);
				$this->assertEquals($pdoApiCall->getIP(), $this->VALID_ApiCallIP);
				$this->assertEquals($pdoApiCall->getPayload(), $this->VALID_ApiCallPayload);
			}
		}
	}

	/**
	 *Get invalid api user id
	 */
	public function testGetInvalidApiCallbyUserId() {
//Grab an invalid Call Id that exceeds
		$ApiCall = ApiCall::getApiCallByApiCallId($this->getPDO(), MlbScoutTest::INVALID_KEY);
		$this->assertNull($ApiCall);
	}

}