<?php
class apiCall {
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
	 * @var
	 */
	private $apiCallUrl;
	/*
	 * @var
	 */
	private $apiHttpVerb;
	/*
	 * @var
	 */
	private $apiCallBrowser;
	/*
	 * @var
	 */
	private $apiCallip;
	/*
	 * @var
	 */
	private $apiCallPayload;

	public function __construct( $newApiCallId, $newApiCallDateTime, $newApiCallQueryString,
										 $newApiCallUserId, $newApiCallUrl, $newApiGET, $newApiPOST, $newApiPUT,
										 $newApiDELETE, $newApiCallBrowser,
										 $newApiCallip, $newApiCallPayload) {
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
			throw(new UnexpectedValueException("Unable to construct APICALL", 0, $exception));
		}
	}
}