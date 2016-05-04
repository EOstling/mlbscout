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
	 * Timestamp of the API Date time; this starts as null and is assigned later
	 * @var DateTime $VALID_APIDATETIME
	 **/
	protected $VALID_APIDATETIME = null;
	/**
	 * Content for Query String
	 * @var string $VALID_APIQUERYCONTENT
	 **/
	protected $VALID_APIQUERYCONTENT = "PHPUnit test passing";
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

	public function testInsertValidAPIDATETIME(){
		/**
		 count the number of rows and save it for later
		**/

		$numRows = $this->getConnection()->getRowCount("tweet");

		// create a Datetime and insert it into mySQL
		$apiCall = new apiCall (null,$this->VALID_APIDATETIME, $this->APIQUERYCONTENT,
										$this->APIURL,$this->APIHTTPVERB, $this->APIBROWSER,
										$this->APIIP,$this->APIPAYLOAD,$this->ApiUserId);

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoApiCall = apicall::getDateTimebyUserId($this->getPDO(), $tweet->getTweetId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertEquals($pdoTweet->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
		$this->assertEquals($pdoTweet->getTweetDate(), $this->VALID_TWEETDATE);
	}

































}


















