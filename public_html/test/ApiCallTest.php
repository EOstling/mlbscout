<?php

/**
 * Full Unit test for Api Call Class.
 *	@see apiCall class
 * @author Eliot Robert Ostling <it.treugott@gmail.com>
 **/

require_once("MlbScoutTest.php");

//require_once(apiClass(__DIR__) . "/mlbscout/php/classes/apiCall/autoload.php");

class apiClass extends MlbScoutTest {

	protected $VALID_ApiCallId = null;

	protected $VALID_ApiCallBrowser = null;

	protected $VALID_ApiCallDateTime = null;

	protected $VALID_ApiCallHttpVerb = null;

	protected $VALID_ApiCallIP = null;

	protected $VALID_ApiCallQueryString = null;

	protected $VALID_ApiCallPayload = null;

	protected $VALID_ApiCallURL = null;

	protected $VALID_ApiCallUserId = null;


	//Creating the setup objects before testing

	/**
	 *Creating dependant objects
	 */
	public final function setUp() {
		//setup method first
		parent::setUp();
		//Create state variables of string & integer
		$this->User = new apiUser(null, "userAccessLevelId", "userActivationToken", "userEmail,userFirstName,userHash,userLastName
			userPassword,userPhoneNumber,userSalt,userUpdate");
		$this->User->insert($this->getPDO());
		//Timestamp of Test being ran
		$this->VALID_ApiDateTime = new \DateTime();
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
		$apiCall = new apiCall (null, $this->VALID_ApiCallBrowser, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallURL, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallBrowser,
			$this->VALID_ApiCallIP, $this->VALID_ApiCallPayload, $this->ApiCallUserId);

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiUser"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->VALID_ApiCallId->getUser());
		$this->assertEquals($pdoApiCall->getQuery(), $this->VALID_ApiCallQueryString);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_ApiCallDateTime);
		$this->assertEquals($pdoApiCall->getUrl(), $this->VALID_ApiCallURL);
		$this->assertEquals($pdoApiCall->getHTTPVerb(), $this->VALID_ApiCallHttpVerb);
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
		$apiCall = new apiCall(MlbScoutTest::INVALID_KEY, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallURL, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallBrowser,
			$this->ApiCallIp, $this->VALID_ApiCallPayload, $this->ApiCallUserId);
		$apiCall->insert($this->getPDO());
	}

	/**
	 *Testing a valid ApiCall
	 */
	public function testUpdateValidApiCall() {

		$numRows = $this->getConnection()->getRowCount("ApiCallId");
		$apiCall = new apiCall(null, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallURL, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallBrowser,
			$this->ApiCallIp, $this->VALID_ApiCallPayload, $this->ApiCallUserId);
		$apiCall->insert($this->getPDO());

// edit the ApiCall and update it in mySQL
		$apiCall->setQueryString($this->VALID_ApiCallQueryString);
		$apiCall->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getUserId());
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
	 * Give an invalid ApiCall
	 */
	public function testUpdateInvalidApiCall() {
		// create an api call  with a non null id and watch it fail
		$apiCall = new apiCall(null, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallURL, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallBrowser,
			$this->VALID_ApiCallIP, $this->VALID_ApiCallPayload, $this->VALID_ApiCallId);
		$apiCall->update($this->getPDO());
	}

	/**
	 * Delete by primary key by testing a valid ApiCall
	 */
	public function testDeleteValidApiCall() {

		$numRows = $this->getConnection()->getRowCount("ApiCall");
		$apiCall = new apiCall(null, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallURL, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallBrowser,
			$this->VALID_ApiCallIP, $this->VALID_ApiCallPayload, $this->ApiCallUserId);
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
	 */
	public function testDeleteInvalidApiCall() {
		// create a ApiCall and try to delete it without actually inserting it
		$ApiCall = new apiCall(null, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallURL, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallBrowser,
			$this->VALID_ApiCallIP, $this->VALID_ApiCallPayload, $this->VALID_ApiCallUserId);
		$ApiCall->delete($this->getPDO());
	}

	/**
	 *
	 */
	public function testGetValidApiCallbyCallId() {
		$numRows = $this->getConnection()->getRowCount("ApiCallCallId");
		//Create a new ApiCall and insert into mySQL

		$apiCall = new apiCall(null, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallURL, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallBrowser,
			$this->VALID_ApiCallIP, $this->VALID_ApiCallPayload, $this->VALID_ApiCallUserId);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getUserId());
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


	public function testGetValidApiCallBrowser() {
		$numRows = $this->getConnection()->getRowCount("ApiCallBrowser");
		//Create a new ApiCall and insert into mySQL
		$apiCall = new apiCall(null, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallURL, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallBrowser,
			$this->VALID_ApiCallIP, $this->VALID_ApiCallPayload, $this->VALID_ApiCallUserId);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl

		$pdoApiCall = apicall::getApicallbyBrowser($this->getPDO(), $apiCall->getApiCallBrowser());
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
	public function tetsGetInvalidApiCallBrowser() {
		$apiCall = ApiCall::getApiCallByBrowser($this->getPDO(), "Invalid browser");
		$this->assertCount(0, $apiCall);
	}


	/**
	 *
	 */


	public function testGetValidApiCallByDateTime() {

		$numRows = $this->getConnection()->getRowCount("ApiCallDateTime");
		$apiCall = new apiCall(null, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallURL, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallBrowser,
			$this->VALID_ApiCallIP, $this->VALID_ApiCallPayload, $this->VALID_ApiCallUserId);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCall = apicall::getApiCallbyDateTime($this->getPDO(), $apiCall->getApiCallDateTime);
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
	public function testGetInvalidApiCallByDateTime() {

		$apiCall = ApiCall::getApiCallByDateTime($this->getPDO(), "No Time for you");
		$this->assertCount(0, $apiCall);
	}


	public function testGetValidApiCallHttpVerb() {
		$numRows = $this->getConnection()->getRowCount("ApiCallHttpVerb");
		//Create a new ApiCall and insert into mySQL
		$apiCall = new apiCall(null, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallURL, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallBrowser,
			$this->VALID_ApiCallIP, $this->VALID_ApiCallPayload, $this->VALID_ApiCallUserId);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl

		$pdoApiCall = apicall::getApicallbyHttpVerb($this->getPDO(), $apiCall->getApiCallHttpverb());
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

	public function testInvalidApiCallHttpVerb() {
		$apiCall = ApiCall::getApiCallByHttpVerb($this->getPDO(), "No");
		$this->assertCount(0, $apiCall);

	}


	public function testGetValidApiCallIP() {

	}

	/**
	 *
	 */
	public function testGetInvalidApiCallIP() {


	}


	/**
	 *
	 */
	public function testGetValidApiCallByQueryString() {
		$numRows = $this->getConnection()->getRowCount("ApiCallQueryString");
		//Create a new ApiCall and insert into mySQL
		$apiCall = new apiCall(null, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallURL, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallBrowser,
			$this->VALID_ApiCallIP, $this->VALID_ApiCallPayload, $this->VALID_ApiCallUserId);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCall = apicall::getApicallbyQueryString($this->getPDO(), $apiCall->getApiCallQueryString());
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
	public function testGetInvalidApiCallByQueryString() {
		$apiCall = ApiCall::getApiCallByQueryString($this->getPDO(), "no query string");
		$this->assertCount(0, $apiCall);
	}


	public function testGetValidApiCallPayload() {
		$numRows = $this->getConnection()->getRowCount("ApiCallPayload");
		//Create a new ApiCall and insert into mySQL
		$apiCall = new apiCall(null, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallURL, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallBrowser,
			$this->VALID_ApiCallIP, $this->VALID_ApiCallPayload, $this->VALID_ApiCallUserId);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getApiCallPayload());
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
	public function testGetInvalidApiCallPayload() {

		$apiCall = ApiCall::getApiCallByPayload($this->getPDO(), "There is no payload");
		$this->assertCount(0, $apiCall);
	}



	/**
	 *
	 */
	public function testGetValidApiCallURL() {
		$numRows = $this->getConnection()->getRowCount("ApiCallURL");
		//Create a new ApiCall and insert into mySQL
		$apiCall = new apiCall(null, $this->VALID_ApiCallDateTime, $this->VALID_ApiCallQueryString,
			$this->VALID_ApiCallURL, $this->VALID_ApiCallHttpVerb, $this->VALID_ApiCallBrowser,
			$this->VALID_ApiCallIP, $this->VALID_ApiCallPayload, $this->VALID_ApiCallUserId);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCall = apicall::getApicallbyURL($this->getPDO(), $apiCall->getApiCallURL());
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
	public function testGetInvalidApiCallURL() {

		$apiCall = ApiCall::getTweetByTweetContent($this->getPDO(), "Not a valid URL");
		$this->assertCount(0, $apiCall);
	}
}

