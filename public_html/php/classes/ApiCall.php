<?php
class ApiCall {

	/**
	 * @var INT Primary key
	 **/
	private $apiCallId;
	/**
	 * @varINT DateTime
	 **/
	private $apiCallDateTime;
	/**
	 * @var INT Query
	 **/
	private $callQueryString;
	/**
	 * @var INT
	 **/
	private $apiCallUserId;
	/**
	 * @varINT
	 **/
	private $apiCallURL;
	/**
	 * @var string
	 **/
	private $apiHttpVerb;
	/**
	 * @var string
	 **/
	private $apiCallBrowser;
	/**
	 * @var string
	 **/
	private $apiCallip;
	/**
	 * @var String()
	 **/
	private $apiCallPayload;

	public function __construct( int $newApiCallId, TIMESTAMP $newApiCallDateTime, string $newApiCallQueryString,
										int $newApiCallUserId,string  $newApiCallURL, string $newApiCallHttpVerb,string $newApiCallBrowser,
										string $newApiCallip, string $newApiCallPayload) {
		try {
			$this->setapiCallId($newApiCallId);
			$this->setApiCallDateTime($newApiCallDateTime);
			$this->setApiCallQueryString($newApiCallQueryString);
			$this->setApiCallUserId($newApiCallUserId);
			$this->setApiCallURL($newApiCallURL);
			$this->setApicallHttpVerb($newApiCallHttpVerb);
			$this->setApiCallBrowser($newApiCallBrowser);
			$this->setApiCallip($newApiCallip);
			$this->setApiCallPayload($newApiCallPayload);

		} catch(UnexpectedValueException $exception) {
			// rethrow to the USER
			throw(new UnexpectedValueException("Unable to construct API", 0, $exception));
		}
	}
//ApiCallId
	public function getApiCallId(){
	return($this->getapiCallId);
}
	public function setApicallId(int $newApiCallId){
		$newApiCallId = filter_var($newApiCallId, FILTER_VALIDATE_INT);
		if($newApiCallId === false) {
			throw(new UnexpectedValueException("Apicall id is not a valid integer"));
		}

		// convert and store the profile id
		$this->apiCallId = intval($newApiCallId);
	}

	public function getApiCallUserId(){
	return($this->apiCallUserId);
	}

	public function setApiCallUserId($newApiCallUserId){
		$newApiCallUserId = filter_var($newApiCallUserId, FILTER_VALIDATE_INT);
		if($newApiCallUserId === false) {
			throw(new UnexpectedValueException("User id is not a valid integer"));
		}

		// convert and store the profile id
		$this->apiCallUserId = intval($newApiCallUserId);

	}

//DateTime
	public function getApiCallDateTime(){
	return($this->apiCallDateTime);
	}

	public function setApiCallDateTime($newApiCallDateTime=null) {
		//DateTime
		if($newApiCallDateTime === null) {
			$this->ApiCallDateTime = new \DateTime();
			return;
		}
	}
	public function getApiCallQueryString(){
			return($this->callQueryString);
		}

	public function setApiCallQueryString($newApiCallQueryString){
		$newApiCallQueryString = trim($newApiCallQueryString);
		$newApiCallQueryString = filter_var($newApiCallQueryString, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(empty($newApiCallQueryString) === true) {
			throw(new \InvalidArgumentException(""));
		}

		// verify the tweet content will fit in the database

		if(strlen($newApiCallQueryString) > 128) {
			throw(new \RangeException("Range is too long"));
		}

		// store the tweet content

		$this->getApiCallQueryString = $newApiCallQueryString;
		}


	public function getApiCallURL(){
		return($this->apiCallURL);
	}
	public function setApiCallURL(string $newApiCallURL) {
		$newApiCallURL = trim($newApiCallURL);
		$newApiCallURL = filter_var($newApiCallURL, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(empty($newApiCallURL) === TRUE) {
			throw(new\InvalidArgumentException(""));

			if(strlen($newApiCallURL) > 140) {
				throw(new\RangeException("URL is too long"));
			}
			$this->getapiCallURL = $newApiCallUrl;
		}
	}
		public function getApiCallHttpVerb(){
			return($this->apiHttpVerb);
		}

		public function setApiCallHttpVerb(){


		}



















































	}



