<?php

/**
 * Full Unit test for Api Call Class.
 *	@see apiCall class
 * @author Eliot Robert Ostling <it.treugott@gmail.com>
 **/

require_once("MlbScoutTest.php");

//require_once(apiClass(__DIR__) . "/mlbscout/php/classes/apiCall/autoload.php");

class apiClass extends MlbScoutTest {
	/**
	 * @var null
	 * Content2
	 */
	protected $VALID_APICLASSCONTENT2=null;
	/**
	 * @var null
	 * Content
	 */
	protected $VALID_APICLASSCONTENT=null;
	/**
	 * Timestamp of the API Date time; this starts as null and is assigned later
	 * @var DateTime $VALID_APIDATETIME
	 **/
	protected $VALID_APIDATETIME = null;
	/**
	 * Content for Query String
	 * @var string $VALID_APIQUERYCONTENT
	 **/
	protected $VALID_APIQUERY = "PHPUnit test passing";
	/**
	 * Valid URL
	 * @var string $VALID_APIURL
	 */
	protected $VALID_APIURL;
	/**
	 * Valid HttpVerb
	 * @var null
	 */
	protected $VALID_APIHTTPVERB=null;
	/**
	 * Valid Browser
	 * @var
	 */
	protected $VALID_APIBROWSER;
	/**
	 * Checking for valid IP
	 * @var
	 */
	protected $VALID_APIIP;
	/**
	 * Checking for payload
	 * @var
	 */
	protected $VALID_APIPAYLOAD;
	/**
	 * @var USER null
	 */
	protected $VALID_ApiUserId=null;


	//Creating the setup objects before testing

	public final function setUp(){
		//setup method first
		parent::setUp();
		//Create state variables of string & integer
		$this->ApiUser = new ApiUser(null, "@phpunit", "test@phpunit.de", "+12125551212");
		$this->ApiUser->insert($this->getPDO());
		//Timestamp of Test being ran
		$this->VALID_APIDATETIME = new \DateTime();
	}

	/**
	 *
	 */
	public function testInsertValidApiCall(){
			/**
			 count the number of rows and save it for later
			**/

		$numRows = $this->getConnection()->getRowCount("ApiCall");

		// create a Datetime and insert it into mySQL
		$apiCall = new apiCall (null,$this->VALID_APIDATETIME, $this->APIQUERYCONTENT,
										$this->APIURL,$this->APIHTTPVERB, $this->APIBROWSER,
										$this->APIIP,$this->APIPAYLOAD,$this->ApiUserId);

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiUser"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->UserId->getUserId());
		$this->assertEquals($pdoApiCall->getQuery(), $this->VALID_APICALL);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_APIDATETIME);
		$this->assertEquals($pdoApiCall->getUrl(),$this->VALID_APIURL);
		$this->assertEquals($pdoApiCall->getHTTPVerb(),$this->VALID_APIHTTPVERB);
		$this->assertEquals($pdoApiCall->getBrowser(),$this->VALID_APIBROWSER);
		$this->assertEquals($pdoApiCall->getIP(),$this->VALID_APIIP);
		$this->assertEquals($pdoApiCall->getPayload(),$this->VALID_APIPAYLOAD);
	}
	/**
	 * test inserting a DateTime that already exists
	 *
	 * @expectedException PDOException
	 **/
		public function testInsertInvalidApiCall(){
			// create a DateTime with a non null Date id and watch it fail
			$apiCall = new apiCall(MlbScoutTest::INVALID_KEY, $this->VALID_APIDATETIME, $this->APIQUERY,
											$this->APIURL,$this->APIHTTPVERB, $this->APIBROWSER,
											$this->APIIP,$this->APIPAYLOAD,$this->ApiUserId);
			$apiCall->insert($this->getPDO());
		}

		public function testUpdateValidApiCall(){

			$numRows = $this->getConnection()->getRowCount("ApiCallId");
			$apiCall = new apiCall(null,$this->VALID_APIDATETIME, $this->APIQUERY,
											$this->APIURL,$this->APIHTTPVERB, $this->APIBROWSER,
											$this->APIIP,$this->APIPAYLOAD,$this->ApiUserId);
			$apiCall->insert($this->getPDO());

// edit the ApiCall and update it in mySQL
			$apiCall->setQueryContent($this->VALID_APIQUERYCONTENT2);
			$apiCall->update($this->getPDO());

			// grab the data from mySQL and enforce the fields match our expectations
			$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getUserId());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiUserId"));
			$this->assertEquals($pdoApiCall->getUserId(), $this->UserId->getUserId());
			$this->assertEquals($pdoApiCall->getVALID_APICALLCONTENT2(), $this->VALID_APICALLCONTENT2);
			$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_APIDATETIME);
			$this->assertEquals($pdoApiCall->getUrl(),$this->VALID_APIURL);
			$this->assertEquals($pdoApiCall->getHTTPVerb(),$this->VALID_APIHTTPVERB);
			$this->assertEquals($pdoApiCall->getBrowser(),$this->VALID_APIBROWSER);
			$this->assertEquals($pdoApiCall->getIP(),$this->VALID_APIIP);
			$this->assertEquals($pdoApiCall->getQueryContent(),$this->VALID_APIQUERYCONTENT);
			$this->assertEquals($pdoApiCall->getPayload(),$this->VALID_APIPAYLOAD);

		}

		public function testUpdateInvalidApiCall() {
		// create a Tweet with a non null tweet id and watch it fail
		$apiCall = new apiCall(null, $this->VALID_APIDATETIME, $this->APIQUERYCONTENT,
										$this->APIURL,$this->APIHTTPVERB, $this->APIBROWSER,
										$this->APIIP,$this->APIPAYLOAD,$this->ApiUserId );
		$apiCall->update($this->getPDO());
	}

	public function testDeleteValidApiCall() {

		$numRows = $this->getConnection()->getRowCount("ApiCall");
		$apiCall = new apiCall(null, $this->VALID_APIDATETIME, $this->APIQUERY,
										$this->APIURL, $this->APIHTTPVERB, $this->APIBROWSER,
										$this->APIIP, $this->APIPAYLOAD, $this->ApiUserId);
		$apiCall->insert($this->getPDO());

		// delete the ApiCall from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiCall"));
		$apiCall->delete($this->getPDO());

		// grab the data from mySQL and enforce the ApiCall does not exist
		$pdoApiCall = apiCall::getApiCallByUserId($this->getPDO(), $apiCall->getApiCallId());
		$this->assertNull($pdoApiCall);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("ApiCall"));

	}


	public function testDeleteInvalidApiCall() {
		// create a ApiCall and try to delete it without actually inserting it
		$ApiCall = new ApiCall(null,$this->VALID_APIDATETIME, $this->APIQUERYCONTENT,
										$this->APIURL,$this->APIHTTPVERB, $this->APIBROWSER,
										$this->APIIP,$this->APIPAYLOAD,$this->ApiUserId );
		$ApiCall->delete($this->getPDO());
	}

	public function testGetValidApiCallbyCallId(){
		$numRows = $this->getConnection()->getRowCount("ApiCallCallId");
		//Create a new ApiCall and insert into mySQL

		$apiCall = new apiCall(null,$this->VALID_APIDATETIME, $this->APIQUERY,
										$this->APIURL,$this->APIHTTPVERB, $this->APIBROWSER,
										$this->APIIP,$this->APIPAYLOAD,$this->ApiUserId);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getCallId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiCallId"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->UserId->getUserId());
		$this->assertEquals($pdoApiCall->getVALID_APICALLCONTENT2(), $this->VALID_APICALLCONTENT2);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_APIDATETIME);
		$this->assertEquals($pdoApiCall->getUrl(),$this->VALID_APIURL);
		$this->assertEquals($pdoApiCall->getHTTPVerb(),$this->VALID_APIHTTPVERB);
		$this->assertEquals($pdoApiCall->getBrowser(),$this->VALID_APIBROWSER);
		$this->assertEquals($pdoApiCall->getIP(),$this->VALID_APIIP);
		$this->assertEquals($pdoApiCall->getQueryContent(),$this->VALID_APIQUERYCONTENT);
		$this->assertEquals($pdoApiCall->getPayload(),$this->VALID_APIPAYLOAD);
	}

	public function testGetInvalidApiCallbyCallId(){

//Stub Method yo

	}



	public function testGetValidApiCallbyUserId(){
		$numRows = $this->getConnection()->getRowCount("ApiCallUserId");
		$apiCall = new apiCall(null,$this->VALID_APIDATETIME, $this->APIQUERY,
										$this->APIURL,$this->APIHTTPVERB, $this->APIBROWSER,
										$this->APIIP,$this->APIPAYLOAD,$this->ApiUserId);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getCallId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiCallUserId"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->UserId->getUserId());
		$this->assertEquals($pdoApiCall->getVALID_APICALLCONTENT2(), $this->VALID_APICALLCONTENT2);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_APIDATETIME);
		$this->assertEquals($pdoApiCall->getUrl(),$this->VALID_APIURL);
		$this->assertEquals($pdoApiCall->getHTTPVerb(),$this->VALID_APIHTTPVERB);
		$this->assertEquals($pdoApiCall->getBrowser(),$this->VALID_APIBROWSER);
		$this->assertEquals($pdoApiCall->getIP(),$this->VALID_APIIP);
		$this->assertEquals($pdoApiCall->getQueryContent(),$this->VALID_APIQUERYCONTENT);
		$this->assertEquals($pdoApiCall->getPayload(),$this->VALID_APIPAYLOAD);
	}

	public function testGetInvalidApiCallbyUserId(){


		//Stub method
	}

	public function testGetValidApiCallByDateTime(){

		$numRows = $this->getConnection()->getRowCount("ApiCallDateTime");
		$apiCall = new apiCall(null,$this->VALID_APIDATETIME, $this->APIQUERY,
			$this->APIURL,$this->APIHTTPVERB, $this->APIBROWSER,
			$this->APIIP,$this->APIPAYLOAD,$this->ApiUserId);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getCallId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiCallDateTime"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->UserId->getUserId());
		$this->assertEquals($pdoApiCall->getVALID_APICALLCONTENT2(), $this->VALID_APICALLCONTENT2);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_APIDATETIME);
		$this->assertEquals($pdoApiCall->getUrl(),$this->VALID_APIURL);
		$this->assertEquals($pdoApiCall->getHTTPVerb(),$this->VALID_APIHTTPVERB);
		$this->assertEquals($pdoApiCall->getBrowser(),$this->VALID_APIBROWSER);
		$this->assertEquals($pdoApiCall->getIP(),$this->VALID_APIIP);
		$this->assertEquals($pdoApiCall->getQueryContent(),$this->VALID_APIQUERYCONTENT);
		$this->assertEquals($pdoApiCall->getPayload(),$this->VALID_APIPAYLOAD);
	}

	public function testGetInvalidApiCallByDateTime(){

		//Stub method yo
	}


	public function testGetValidApiCallByQueryString(){
		$numRows = $this->getConnection()->getRowCount("ApiCallQueryString");
		//Create a new ApiCall and insert into mySQL
		$apiCall = new apiCall(null,$this->VALID_APIDATETIME, $this->APIQUERY,
			$this->APIURL,$this->APIHTTPVERB, $this->APIBROWSER,
			$this->APIIP,$this->APIPAYLOAD,$this->ApiUserId);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getCallId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiCallQueryString"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->UserId->getUserId());
		$this->assertEquals($pdoApiCall->getVALID_APICALLCONTENT2(), $this->VALID_APICALLCONTENT2);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_APIDATETIME);
		$this->assertEquals($pdoApiCall->getUrl(),$this->VALID_APIURL);
		$this->assertEquals($pdoApiCall->getHTTPVerb(),$this->VALID_APIHTTPVERB);
		$this->assertEquals($pdoApiCall->getBrowser(),$this->VALID_APIBROWSER);
		$this->assertEquals($pdoApiCall->getIP(),$this->VALID_APIIP);
		$this->assertEquals($pdoApiCall->getQueryContent(),$this->VALID_APIQUERYCONTENT);
		$this->assertEquals($pdoApiCall->getPayload(),$this->VALID_APIPAYLOAD);
	}

	public function testGetInvalidApiCallByQueryString(){
		//Stub method
		//#stubhub
	}

	public function testGetValidApiCallURL(){
		$numRows = $this->getConnection()->getRowCount("ApiCallQueryString");
		//Create a new ApiCall and insert into mySQL
		$apiCall = new apiCall(null,$this->VALID_APIDATETIME, $this->APIQUERY,
			$this->APIURL,$this->APIHTTPVERB, $this->APIBROWSER,
			$this->APIIP,$this->APIPAYLOAD,$this->ApiUserId);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getCallId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiCallQueryString"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->UserId->getUserId());
		$this->assertEquals($pdoApiCall->getVALID_APICALLCONTENT2(), $this->VALID_APICALLCONTENT2);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_APIDATETIME);
		$this->assertEquals($pdoApiCall->getUrl(),$this->VALID_APIURL);
		$this->assertEquals($pdoApiCall->getHTTPVerb(),$this->VALID_APIHTTPVERB);
		$this->assertEquals($pdoApiCall->getBrowser(),$this->VALID_APIBROWSER);
		$this->assertEquals($pdoApiCall->getIP(),$this->VALID_APIIP);
		$this->assertEquals($pdoApiCall->getQueryContent(),$this->VALID_APIQUERYCONTENT);
		$this->assertEquals($pdoApiCall->getPayload(),$this->VALID_APIPAYLOAD);
	}



	public function testGetInvalidApiCallURL(){

		//stub method
	}

	public function testGetValidApiCallHTTPVerb(){
		$numRows = $this->getConnection()->getRowCount("ApiCallQueryString");
		//Create a new ApiCall and insert into mySQL
		$apiCall = new apiCall(null,$this->VALID_APIDATETIME, $this->APIQUERY,
			$this->APIURL,$this->APIHTTPVERB, $this->APIBROWSER,
			$this->APIIP,$this->APIPAYLOAD,$this->ApiUserId);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl

		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getCallId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiCallQueryString"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->UserId->getUserId());
		$this->assertEquals($pdoApiCall->getVALID_APICALLCONTENT2(), $this->VALID_APICALLCONTENT2);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_APIDATETIME);
		$this->assertEquals($pdoApiCall->getUrl(),$this->VALID_APIURL);
		$this->assertEquals($pdoApiCall->getHTTPVerb(),$this->VALID_APIHTTPVERB);
		$this->assertEquals($pdoApiCall->getBrowser(),$this->VALID_APIBROWSER);
		$this->assertEquals($pdoApiCall->getIP(),$this->VALID_APIIP);
		$this->assertEquals($pdoApiCall->getQueryContent(),$this->VALID_APIQUERYCONTENT);
		$this->assertEquals($pdoApiCall->getPayload(),$this->VALID_APIPAYLOAD);

	}

	public function tetsGetInvalidApiCallBrowswer(){
		//stub method

	}

	public function testGetValidApiCallIP(){

	}

	public function testGetInvalidApiCallIP(){

		//stub method
	}

	public function testGetValidApiCallPayload(){
		$numRows = $this->getConnection()->getRowCount("ApiCallPayload");
		//Create a new ApiCall and insert into mySQL
		$apiCall = new apiCall(null,$this->VALID_APIDATETIME, $this->APIQUERY,
			$this->APIURL,$this->APIHTTPVERB, $this->APIBROWSER,
			$this->APIIP,$this->APIPAYLOAD,$this->ApiUserId);
		$apiCall->insert($this->getPDO());
		//Grab data from mySQl
		$pdoApiCall = apicall::getApicallbyUserId($this->getPDO(), $apiCall->getCallId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ApiCallPayload"));
		$this->assertEquals($pdoApiCall->getUserId(), $this->UserId->getUserId());
		$this->assertEquals($pdoApiCall->getVALID_APICALLCONTENT2(), $this->VALID_APICALLCONTENT2);
		$this->assertEquals($pdoApiCall->getDateTime(), $this->VALID_APIDATETIME);
		$this->assertEquals($pdoApiCall->getUrl(),$this->VALID_APIURL);
		$this->assertEquals($pdoApiCall->getHTTPVerb(),$this->VALID_APIHTTPVERB);
		$this->assertEquals($pdoApiCall->getBrowser(),$this->VALID_APIBROWSER);
		$this->assertEquals($pdoApiCall->getIP(),$this->VALID_APIIP);
		$this->assertEquals($pdoApiCall->getQueryContent(),$this->VALID_APIQUERYCONTENT);
		$this->assertEquals($pdoApiCall->getPayload(),$this->VALID_APIPAYLOAD);

	}

	public function testGetInvalidApiCallPayload(){

		//stub method
	}

	//public function testGetValid























}


















