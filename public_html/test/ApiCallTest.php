<?php
namespace Edu\Cnm\MlbScout\Test;
// grab the project test parameters
use Edu\Cnm\MlbScout\{ApiCall,AccessLevel,User};

require_once("MlbScoutTest.php");
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");
/**
 * Full Unit test for Api Call Class.
 *	@see ApiCall
 * @author Eliot Robert Ostling <it.treugott@gmail.com>
 **/
class ApiCallTest extends MlbScoutTest {
	/**
	 * @var string $VALID_ApiCallBrowser
	 *
	 **/
	protected $VALID_ApiCallBrowser = "Safari";
	/**
	 * @var null $VALID_ApiCallDateTime
	 **/
	protected $VALID_ApiCallDateTime = null;
	/**
	 * @var string $VALID_ApiCallHttpVerb
	 **/
	protected $VALID_ApiCallHttpVerb = "GET";
	/**
	 * @var string $VALID_ApiCallHttpVerb2
	 **/
	protected $VALID_ApiCallHttpVerb2 = "POST";
	/**
	 * @var string $VALID_ApiCallIP
	 **/
	protected $VALID_ApiCallIP = "127.0.0.1";
	/**
	 * @var string $VALID_ApiCallQueryString
	 **/
	protected $VALID_ApiCallQueryString = "TestString";
	/**
	 * @var string $VALID_ApiCallPayload
	 **/
	protected $VALID_ApiCallPayload = "TestPayload";
	/**
	 * @var string $VALID_ApiCallUrl
	 **/
	protected $VALID_ApiCallUrl = "google.com";
	/**
	 * @var int $hash
	 **/
	private $hash;
	/**
	 * @var int $salt
	 **/
	private $salt;
	/**
	 * @var User $user
	 **/
	private $user;
	/**
	 * @var AccessLevel $accessLevel
	 * AccessLevel
	 **/
	protected $accessLevel = null;
	//Creating the setup objects before testing
	/**
	 * Setup() function
	 **/
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
		$this->VALID_ApiCallDateTime = new \DateTime();
	}

	/**
	 *Testing a valid $ApiCall id
	 **/
	public function testInsertValidApiCall() {
		$numRows = $this->getConnection()->getRowCount("apiCall");
		// create a Datetime and insert it into mySQL
		$apiCall = new ApiCall(null, $this->user->getUserId(), $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload, $this->VALID_ApiCallUrl);
		$apiCall->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoApiCall = ApiCall::getApiCallByApiCallId($this->getPDO(), $apiCall->getApiCallId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("apiCall"));
		$this->assertEquals($pdoApiCall->getApiCallUserId(), $this->user->getUserId());
		$this->assertEquals($pdoApiCall->getApiCallQueryString(), $this->VALID_ApiCallQueryString);
		$this->assertEquals($pdoApiCall->getApiCallDateTime(), $this->VALID_ApiCallDateTime);
		$this->assertEquals($pdoApiCall->getApiCallUrl(), $this->VALID_ApiCallUrl);
		$this->assertEquals($pdoApiCall->getApiCallHttpVerb(), $this->VALID_ApiCallHttpVerb);
		$this->assertEquals($pdoApiCall->getApiCallBrowser(), $this->VALID_ApiCallBrowser);
		$this->assertEquals($pdoApiCall->getApiCallIP(), $this->VALID_ApiCallIP);
		$this->assertEquals($pdoApiCall->getApiCallPayload(), $this->VALID_ApiCallPayload);

	}

	/**
	 * Test insert invalid API call
	 *
	 * @expectedException \InvalidArgumentException
	 **/
	public function testInsertInvalidApiCall() {
		$apiCall = new ApiCall(MlbScoutTest::INVALID_KEY, $this->user->getUserId(), $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload, $this->VALID_ApiCallUrl);
		$apiCall->insert($this->getPDO());
		// try to insert a second time and watch it fail
		$apiCall->insert($this->getPDO());
	}

	/**
	 *Testing a valid ApiCall
	 **/
	public function testUpdateValidApiCall() {
		$numRows = $this->getConnection()->getRowCount("apiCall");
		$apiCall = new ApiCall(null, $this->user->getUserId(), $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload, $this->VALID_ApiCallUrl);
		$apiCall->insert($this->getPDO());
		// edit the ApiCall and update it in mySQL
		$apiCall->setApiCallBrowser($this->VALID_ApiCallBrowser);
		$apiCall->setApiCallDateTime($this->VALID_ApiCallDateTime);
		$apiCall->setApiCallHttpVerb($this->VALID_ApiCallHttpVerb2);
		$apiCall->setApiCallIP($this->VALID_ApiCallIP);
		$apiCall->setApiCallQueryString($this->VALID_ApiCallQueryString);
		$apiCall->setApiCallPayload($this->VALID_ApiCallPayload);
		$apiCall->setApiCallUrl($this->VALID_ApiCallUrl);
		$apiCall->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoApiCall = ApiCall::getApiCallByApiCallId($this->getPDO(), $apiCall->getApiCallId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("apiCall"));
		$this->assertEquals($pdoApiCall->getApiCallUserId(), $this->user->getUserId());
		$this->assertEquals($pdoApiCall->getApiCallQueryString(), $this->VALID_ApiCallQueryString);
		$this->assertEquals($pdoApiCall->getApiCallDateTime(), $this->VALID_ApiCallDateTime);
		$this->assertEquals($pdoApiCall->getApiCallUrl(), $this->VALID_ApiCallUrl);
		//Send in Httpverb2
		$this->assertEquals($pdoApiCall->getApiCallHttpVerb(), $this->VALID_ApiCallHttpVerb2);
		$this->assertEquals($pdoApiCall->getApiCallBrowser(), $this->VALID_ApiCallBrowser);
		$this->assertEquals($pdoApiCall->getApiCallIP(), $this->VALID_ApiCallIP);
		$this->assertEquals($pdoApiCall->getApiCallPayload(), $this->VALID_ApiCallPayload);
	}

	/**
	 * Give an invalid ApiCall
	 * @expectedException \PDOException
	 *
	 **/
	public function testUpdateInvalidApiCall() {
		$apiCall = new ApiCall (null, $this->user->getUserId(), $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime,
			$this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			$this->VALID_ApiCallUrl);
		$apiCall->update($this->getPDO());
	}

	/**
	 * Delete by primary key by testing a valid ApiCall
	 **/
	public function testDeleteValidApiCall() {
		$numRows = $this->getConnection()->getRowCount("apiCall");
		$apiCall = new ApiCall(null, $this->user->getUserId(), $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			$this->VALID_ApiCallUrl);
		$apiCall->insert($this->getPDO());
		// delete the ApiCall from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("apiCall"));
		$apiCall->delete($this->getPDO());
		// grab the data from mySQL and enforce the ApiCall does not exist
		$pdoApiCall = apiCall::getApiCallByApiCallId($this->getPDO(), $apiCall->getApiCallid());
		$this->assertNull($pdoApiCall);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("apiCall"));
	}

	/**
	 * Test invalid delete Invalid ApiCall
	 **/
	public function testDeleteInvalidApiCall() {
		// create a ApiCall and try to delete it without actually inserting it
		$ApiCall = new ApiCall(null, $this->user->getUserId(), $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			$this->VALID_ApiCallUrl);
		$ApiCall->delete($this->getPDO());
	}

	/**
	 *testing valid call id
	 **/
	public function testGetValidApiCallByCallId() {
		$numRows = $this->getConnection()->getRowCount("apiCall");
		//Create a new ApiCall and insert into mySQL
		$apiCall = new ApiCall(null, $this->user->getUserId(), $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			$this->VALID_ApiCallUrl);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCall = ApiCall::getApiCallByApiCallId($this->getPDO(), $apiCall->getApiCallId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("apiCall"));
		$this->assertEquals($pdoApiCall->getApiCallUserId(), $this->user->getUserId());
		$this->assertEquals($pdoApiCall->getApiCallQueryString(), $this->VALID_ApiCallQueryString);
		$this->assertEquals($pdoApiCall->getApiCallDateTime(), $this->VALID_ApiCallDateTime);
		$this->assertEquals($pdoApiCall->getApiCallUrl(), $this->VALID_ApiCallUrl);
		$this->assertEquals($pdoApiCall->getApiCallHTTPVerb(), $this->VALID_ApiCallHttpVerb);
		$this->assertEquals($pdoApiCall->getApiCallBrowser(), $this->VALID_ApiCallBrowser);
		$this->assertEquals($pdoApiCall->getApiCallIP(), $this->VALID_ApiCallIP);
		$this->assertEquals($pdoApiCall->getApiCallPayload(), $this->VALID_ApiCallPayload);
	}

	/**
	 * Testing invalid api call id
	 **/
	public function testGetInvalidApiCallByApiCallId() {
		//Grab an invalid Call Id that exceeds
		$apiCall = ApiCall::getApiCallByApiCallId($this->getPDO(), MlbScoutTest::INVALID_KEY);
		$this->assertNull($apiCall);
	}

	/**
	 * @throws \Exception
	 * @throws \PDOException
	 **/
	public function testGetValidApiCallByApiCallUserId(){
		$numRows = $this->getConnection()->getRowCount("apiCall");
		$apiCall = new ApiCall(null, $this->user->getUserId(), $this->VALID_ApiCallBrowser, $this->VALID_ApiCallDateTime
			, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallIP, $this->VALID_ApiCallQueryString, $this->VALID_ApiCallPayload,
			$this->VALID_ApiCallUrl);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCalls = ApiCall::getApiCallByApiCallUserId($this->getPDO(), $apiCall->getApiCallUserId());
		foreach($pdoApiCalls as $pdoApiCall) {
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("apiCall"));
			$this->assertEquals($pdoApiCall->getApiCallUserId(), $this->user->getUserId());
			$this->assertEquals($pdoApiCall->getApiCallQueryString(), $this->VALID_ApiCallQueryString);
			$this->assertEquals($pdoApiCall->getApiCallDateTime(), $this->VALID_ApiCallDateTime);
			$this->assertEquals($pdoApiCall->getApiCallUrl(), $this->VALID_ApiCallUrl);
			$this->assertEquals($pdoApiCall->getApiCallHTTPVerb(), $this->VALID_ApiCallHttpVerb);
			$this->assertEquals($pdoApiCall->getApiCallBrowser(), $this->VALID_ApiCallBrowser);
			$this->assertEquals($pdoApiCall->getApiCallIP(), $this->VALID_ApiCallIP);
			$this->assertEquals($pdoApiCall->getApiCallPayload(), $this->VALID_ApiCallPayload);
		}
	}

	/**
	 *
	 */
	public function testGetInvalidApiCallByUserId(){
		$apiCall = ApiCall::getApiCallByApiCallUserId($this->getPDO(), "nothing will be found");
		$this->assertCount(0, $apiCall);

	}

}
