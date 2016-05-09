<?php
class apiCall {
	use ValidateDate;
	/*
	 * @var INT Primary key
	 */
	private $apiCallId;
	/*
	 * @varINT DateTime
	 */
	private $apiCallDateTime;
	/*
	 * @var INT Query
	 */
	private $callQueryString;
	/*
	 * @var INT
	 */
	private $apiCallUserId;
	/*
	 * @varINT
	 */
	private $apiCallUrl;
	/*
	 * @var string
	 */
	private $apiHttpVerb;
	/*
	 * @var string
	 */
	private $apiCallBrowser;
	/*
	 * @var string
	 */
	private $apiCallip;
	/*
	 * @var VarBinary()
	 */
	private $apiCallPayload;

	public function __construct( int $newApiCallId, TIMESTAMP $newApiCallDateTime, string $newApiCallQueryString,
										int $newApiCallUserId,string  $newApiCallUrl, string $newApiGET,string $newApiPOST,string $newApiPUT,
										string $newApiDELETE,string $newApiCallBrowser,
										int $newApiCallip, string $newApiCallPayload) {
		try {
			$this->setApicallId($newApiCallId);
			$this->setApiCallDateTime($newApiCallDateTime);
			$this->setApiCallQueryString($newApiCallQueryString);
			$this->setApiCallUserId($newApiCallUserId);
			$this->setApiCallUrl($newApiCallUrl);
			$this->setApiGET($newApiGET);
			$this->setApiPOST($newApiPOST);
			$this->setApiPUT($newApiPUT);
			$this->setApiDELETE($newApiDELETE);
			$this->setApiCallBrowser($newApiCallBrowser);
			$this->setApiCallip($newApiCallip);
			$this->setApiCallPayload($newApiCallPayload);

		} catch(UnexpectedValueException $exception) {
			// rethrow to the USER
			throw(new UnexpectedValueException("Unable to construct API", 0, $exception));
		}
	}
//ApiCallId
	public function getApicallId(){
	return($this->ApicallId);
}
	public function setApicallId(int $newApiCallId){
		$newApiCallId = filter_var($newApiCallId, FILTER_VALIDATE_INT);
		if($newApiCallId === false) {
			throw(new UnexpectedValueException("Apicall id is not a valid integer"));
		}

		// convert and store the profile id
		$this->ApicallId = intval($newApiCallId);
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

		}



}}