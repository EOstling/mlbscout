<?php
namespace  Edu\Cnm\MlbScout\Test;
use Edu\Cnm\MlbScout\{AccessLevel,User};
/**
 * Full Unit test for Api Call Class.
 *	@see apiCall class
 * @author Eliot Robert Ostling <it.treugott@gmail.com>
 **/

require_once("MlbScoutTest.php");


require_once(dirname(__DIR__) . "/mlbscout/php/classes/apiCall/autoload.php");

class apiClass extends MlbScoutTest {

	/**
	 * @var string
	 *
	 */
	protected $VALID_ApiCallBrowser = "Safari";
	/**
	 * @var null
	 */
	protected $VALID_ApiCallDateTime = null;
	/**
	 * @var string
	 */
	protected $VALID_ApiCallHttpVerb = "GET";
	/**
	 * @var string
	 */
	protected $VALID_ApiCallHttpVerb2= "POST";
	/**
	 * @var string
	 */
	protected $VALID_ApiCallIP = "127.0.0.1";
	/**
	 * @var string
	 */
	protected $VALID_ApiCallQueryString = "TestString";
	/**
	 * @var string
	 */
	protected $VALID_ApiCallPayload = "TestPayload";
	/**
	 * @var string
	 */
	protected $VALID_ApiCallURL = "google.com";
	/**
	 * @var null
	 */
	protected $VALID_ApiCallUserId = null;
	/**
	 * @var int
	 */
	private $hash;
	/**
	 * @var int
	 */
	private $salt;
	/**
	 * @var string
	 */
	private $user;
	/**
	 * @var int
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
			"Tyrion", $this->userHash, "Lannister" , "8675309", $this->userSalt);
		$this->user->insert($this->getPDO());
		//Timestamp of Test being ran
		$this->ApiCallDateTime = new \DateTime();
	}

	/**
	 *
	 */

	public function testInsertValidApiCall() {

		/**
		 * count the number of rows and save it for later
		 **/
		$numRows = $this->getConnection()->getRowCount("ApiCall");
		// create a Datetime and insert it into mySQL
		$apiCall = new apiCall (null, $this->ApiCallUserId , $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			$this->VALID_ApiCallURL);
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiUser"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->VALID_ApiCallId->getUser());
		$this->assertEquals($pdoApiCall->getQuery(), $this->VALID_ApiCallQueryString);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_ApiCallDateTime);
		$this->assertEquals($pdoApiCall->getUrl(), $this->VALID_ApiCallURL);
		$this->assertEquals($pdoApiCall->getHttPVerb(), $this->VALID_ApiCallHttpVerb);
		$this->assertEquals($pdoApiCall->getBrowser(), $this->VALID_ApiCallBrowser);
		$this->assertEquals($pdoApiCall->getIP(), $this->VALID_ApiCallIP);
		$this->assertEquals($pdoApiCall->getPayload(), $this->VALID_ApiCallPayload);
	}

	/**
	 * test inserting a DateTime that already exists
	 *
	 * @expectedException PDOException
	 **/

	public function testInsertInvalidApiCall() {
		// create a DateTime with a non null Date id and watch it fail
		$apiCall = new apiCall(MlbScoutTest::INVALID_KEY, $this->ApiCallUserId, $this->VALID_ApiCallBrowser ,
			$this->VALID_ApiCallDateTime, $this->VALID_ApiCallHttpVerb, $this->ApiCallIp, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallPayload, $this->VALID_ApiCallURL);

		$apiCall->insert($this->getPDO());
		// try to insert a second time and watch it fail
		$apiCall->insert($this->getPDO());
	}

	/**
	 *Testing a valid ApiCall
	 */

	public function testUpdateValidApiCall() {

		$numRows = $this->getConnection()->getRowCount("ApiCallId");
		$apiCall = new apiCall(null, $this->ApiCallUserId, $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			$this->VALID_ApiCallURL);
		// edit the ApiCall and update it in mySQL
		$apiCall->setQueryString($this->VALID_ApiCallHttpVerb2);
		$apiCall->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiUser"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->VALID_ApiCallUserId->getUserId());
		$this->assertEquals($pdoApiCall->getQuery(), $this->VALID_ApiCallQueryString);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_ApiCallDateTime);
		$this->assertEquals($pdoApiCall->getUrl(), $this->VALID_ApiCallURL);
		//Send in Httpverb2
		$this->assertEquals($pdoApiCall->getHttpVerb(), $this->VALID_ApiCallHttpVerb2);
		$this->assertEquals($pdoApiCall->getBrowser(), $this->VALID_ApiCallBrowser);
		$this->assertEquals($pdoApiCall->getIP(), $this->VALID_ApiCallIP);
		$this->assertEquals($pdoApiCall->getPayload(), $this->VALID_ApiCallPayload);
	}

	/**
	 * Give an invalid ApiCall
	 *  @expectedException PDOException
	 */
	public function testUpdateInvalidApiCall() {
		$apiCall = new apiCall(null, $this->ApiCallUserId , $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			  $this->VALID_ApiCallURL);
		$apiCall->update($this->getPDO());
	}

	/**
	 * Delete by primary key by testing a valid ApiCall
	 */
	public function testDeleteValidApiCall() {

		$numRows = $this->getConnection()->getRowCount("ApiCall");
		$apiCall = new apiCall(null, $this->ApiCallUserId , $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			  $this->VALID_ApiCallURL);
		$apiCall->insert($this->getPDO());
		// delete the ApiCall from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiCall"));
		$apiCall->delete($this->getPDO());
		// grab the data from mySQL and enforce the ApiCall does not exist
		$pdoApiCall = apiCall::getApiCallByUserId($this->getPDO(), $apiCall->getApiCallId());
		$this->assertNull($pdoApiCall);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("ApiCall"));
	}

	/**
	 * Test invalid delete Invalid ApiCall
	 * @expectedException PDOException
	 */
	public function testDeleteInvalidApiCall() {
		// create a ApiCall and try to delete it without actually inserting it
		$ApiCall = new apiCall(null, $this->ApiCallUserId, $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			$this->VALID_ApiCallURL);
		$ApiCall->delete($this->getPDO());
	}

	/**
	 *
	 */
	public function testGetValidApiCallbyCallId() {
		$numRows = $this->getConnection()->getRowCount("ApiCallCallId");
		//Create a new ApiCall and insert into mySQL

		$apiCall = new apiCall(null, $this->ApiCallUserId , $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			  $this->VALID_ApiCallURL);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getCallId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiUser"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->VALID_ApiCallUserId->getUserId());
		$this->assertEquals($pdoApiCall->getQuery(), $this->VALID_ApiCallQueryString);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_ApiCallDateTime);
		$this->assertEquals($pdoApiCall->getUrl(), $this->VALID_ApiCallURL);
		$this->assertEquals($pdoApiCall->getHTTPVerb(), $this->VALID_ApiCallHttpVerb);
		$this->assertEquals($pdoApiCall->getBrowser(), $this->VALID_ApiCallBrowser);
		$this->assertEquals($pdoApiCall->getIP(), $this->VALID_ApiCallIP);
		$this->assertEquals($pdoApiCall->getPayload(), $this->VALID_ApiCallPayload);
	}

	/**
	 *
	 */
	public function testGetInvalidApiCallbyCallId() {
		//Grab an invalid Call Id that exceeds
		$ApiCall = ApiCall::getApiCallByCallId($this->getPDO(), MlbScout::INVALID_KEY);
		$this->assertNull($ApiCall);
	}

	/**
	 *
	 */
	public function testGetValidApiCallbyUserId() {
		$numRows = $this->getConnection()->getRowCount("ApiCallUserId");
		//Create a new ApiCall and insert into mySQL
		$apiCall = new apiCall(null, $this->ApiCallUserId , $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			$this->VALID_ApiCallURL);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCalls = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getUserId());
		foreach($pdoApiCalls as $pdoApiCall) {
			if($pdoApiCall->getApiCallUserId() === $apiCall->getApiCallUserId()) {
				$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiUser"));
				$this->assertEquals($pdoApiCall->getUserId(), $this->VALID_ApiCallUserId->getUserId());
				$this->assertEquals($pdoApiCall->getQuery(), $this->VALID_ApiCallQueryString);
				$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_ApiCallDateTime);
				$this->assertEquals($pdoApiCall->getUrl(), $this->VALID_ApiCallURL);
				$this->assertEquals($pdoApiCall->getHTTPVerb(), $this->VALID_ApiCallHttpVerb);
				$this->assertEquals($pdoApiCall->getBrowser(), $this->VALID_ApiCallBrowser);
				$this->assertEquals($pdoApiCall->getIP(), $this->VALID_ApiCallIP);
				$this->assertEquals($pdoApiCall->getPayload(), $this->VALID_ApiCallPayload);
			}
		}
	}

	/**
	 *
	 */
	public function testGetInvalidApiCallbyUserId() {
//Grab an invalid Call Id that exceeds
		$ApiCall = ApiCall::getApiCallByCallId($this->getPDO(), MlbScout::INVALID_KEY);
		$this->assertNull($ApiCall);
	}

}