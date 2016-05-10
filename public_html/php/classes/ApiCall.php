<?php
class ApiCall {
	Use \Edu\Cnm\MlbScout\ValidateDate;
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
	private $apiCallIp;
	/**
	 * @var String()
	 **/
	private $apiCallPayload;

	public function __construct(int $newApiCallId, $newApiCallDateTime, string $newApiCallQueryString,
										 int $newApiCallUserId, string $newApiCallURL, string $newApiCallHttpVerb, string $newApiCallBrowser,
										 string $newApiCallIp, string $newApiCallPayload) {
		try {
			$this->setapiCallId($newApiCallId);
			$this->setApiCallDateTime($newApiCallDateTime);
			$this->setApiCallQueryString($newApiCallQueryString);
			$this->setApiCallUserId($newApiCallUserId);
			$this->setApiCallURL($newApiCallURL);
			$this->setApicallHttpVerb($newApiCallHttpVerb);
			$this->setApiCallBrowser($newApiCallBrowser);
			$this->setApiCallip($newApiCallIp);
			$this->setApiCallPayload($newApiCallPayload);

		} catch(UnexpectedValueException $exception) {
			// rethrow to the USER
			throw(new UnexpectedValueException("Unable to construct API", 0, $exception));
		}
	}

//ApiCallId
	public function getApiCallId() {
		return($this->apiCallId);
	}

	public function setApicallId(int $newApiCallId) {

		$this->apiCallId = $newApiCallId;
	}

	public function getApiCallUserId() {
		return ($this->apiCallUserId);
	}

	public function setApiCallUserId(int $newApiCallUserId) {

		$this->apiCallUserId = $newApiCallUserId;

	}

//DateTime
	public function getApiCallDateTime() {
		return ($this->apiCallDateTime);
	}

	public function setApiCallDateTime($newApiCallDateTime = null) {

		if($newApiCallDateTime !== null){
			$this->apiCallDateTime = $this->validateDate($newApiCallDateTime);
		}

		if($newApiCallDateTime === null) {
			$this->ApiCallDateTime = new \DateTime();
			return;
		}
	}

	public function getApiCallQueryString() {
		return ($this->callQueryString);
	}

	public function setApiCallQueryString(string $newApiCallQueryString) {
		$newApiCallQueryString = trim($newApiCallQueryString);
		$newApiCallQueryString = filter_var($newApiCallQueryString, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(empty($newApiCallQueryString) === true) {
			throw(new \InvalidArgumentException("Api query string can't be empty"));
		}


		if(strlen($newApiCallQueryString) > 128) {
			throw(new \RangeException("Api Call Query string is too long"));
		}


		$this->getApiCallQueryString = $newApiCallQueryString;
	}


	public function getApiCallURL() {
		return ($this->apiCallURL);
	}

	public function setApiCallURL(string $newApiCallURL) {
		$newApiCallURL = trim($newApiCallURL);
		$newApiCallURL = filter_var($newApiCallURL, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(empty($newApiCallURL) === TRUE) {
			throw(new\InvalidArgumentException("Api call Url can't be empty"));
		}
			if(strlen($newApiCallURL) > 128) {
				throw(new\RangeException("URL is too long"));
			}
			$this->getApiCallURL = $newApiCallURL;

	}

	public function getApiCallHttpVerb() {
		return ($this->apiHttpVerb);
	}

	public function setApiCallHttpVerb(string $newApiCallHttpVerb) {

		$verb = $newApiCallHttpVerb;
		if($verb !== "GET" && $verb !== "POST" && $verb !== "PUT" && $verb!=="DELETE"){
			throw(new\InvalidArgumentException("Api Verb must be Get, Put, Post or Delete"));

		}
		$this->ApiCallHttpVerb=$newApiCallHttpVerb;

	}


	public function getApiCallBrowser() {
		return ($this->apiCallBrowser);
	}

	public function setApiCallBrowser(string $newApiCallBrowser) {
		$newApiCallBrowser = trim($newApiCallBrowser);
		$newApiCallBrowser = filter_var($newApiCallBrowser, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(empty($newApiCallBrowser) === TRUE) {
			throw(new\InvalidArgumentException("Api Browser can't be empty"));
		}
			if( strlen( $newApiCallBrowser ) > 128) {
				throw(new\RangeException("Browser is out of my range"));
			}
			$this->getApiCallBrowser = $newApiCallBrowser;



	}

	public function getApiCallIp() {
		return ($this->apiCallIp);
	}

	public function setApiCallIp(string $newApiCallIp) {
		$newApiCallIp = trim($newApiCallIp);
		$newApiCallIp = filter_var($newApiCallIp, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(empty($newApiCallIp) === TRUE) {
			throw(new\InvalidArgumentException("Api IP can't be empty"));
		}
			if(strlen($newApiCallIp) > 128) {
				throw(new\RangeException("Browser is out of my range"));
			}
			$this->getApiCallIp = $newApiCallIp;


	}


	public function getApiCallPayload() {
		return ($this->apiCallPayload);
	}

	public function setApiCallPayload(int $newApiCallPayload) {
		$newApiCallPayload = trim($newApiCallPayload);
		$newApiCallPayload = filter_var($newApiCallPayload, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(empty($newApiCallPayload) === TRUE) {
			throw(new\InvalidArgumentException("Payload cant be empty"));
		}
			if(strlen($newApiCallPayload) > 128) {
				throw(new\RangeException(""));
			}
			$this->getApiCallPayload = $newApiCallPayload;


	}

	public function insert(\Pdo $pdo){
		if ($this->apiCallId!==null){
			throw(new\PDOException("This is incorrect"));
		}
		//Lets create $query;
		$query = "INSERT INTO apiCall(apiCallUserId, apiCallDateTime, apiCallQueryString, apiCallURL, apiCallHttpVerb, apiCallBrowser, apicallIP, apiCallPayload)
 					 VALUES(:apiCallId, :apiCallUserId, :apiCallDateTime, :apiCallQueryString, :apiCallURL, :apiCallHttpVerb, :apiCallBrowser, :apicallIP, :apiCallPayload)";
		$statement = $pdo->prepare($query);
		//Bind the data
		$formattedDate = $this->apiCallDateTime->format("Y-m-d H:i:s");
		$parameters = ["apiCallUserId" => $this->apiCallUserId, "apiCallDateTime" => $this->apiCallDateTime, "apiCallQueryString" => $this->setApiCallQueryString,
							"apiCallURL"=>$this->apiCallURL,"apiCallHttpVerb"=>$this->apiHttpVerb,"apiCallBrowser"=>$this->apiCallBrowser,
							"apicallIP"=>$this->apiCallIp,"apiCallPayload"=>$this->apiCallPayload];
		$statement->execute($parameters);
		//Give me the lastInsert Id:
		$this->apiCall = intval($pdo->lastInsertId());
	}

	public function delete(\Pdo $pdo){

		if($this->apiCallUserId === null){
			throw(new \PDOException("Well we can't delte something that isn't there now can we"));
		}
		$query = "DELETE FROM ApiCall where apiCallId = :apiCallId";
		$statement = $pdo->prepare($query);
		$parameters = ["apiCallId" => $this->apiCallId];
		$statement->execute($parameters);

	}

	public function update(\Pdo $pdo){
		if($this->apiCallId === null){
			throw(new \PDOException("Well we can't update anything that doesn't exist now can we"));
		}
		$query = "UPDATE apiCall SET apiCallId = :apiCallId, apiCallUserId = :apiCallUserId, apiCallURL = :apiCallURL,
					apiCallBrowser = :apiCallBrowser, apicallIP = :apiCallIp,";
		$statement = $pdo->prepare($query);
		//Bind the variable members
		$formattedDate = $this->apiCallDateTime->format("Y-m-d H:i:s");
		$parameters = ["apiCallUserId" => $this->apiCallUserId, "apiCallDateTime" => $this->apiCallDateTime, "apiCallQueryString" => $this->setApiCallQueryString,
			"apiCallURL"=>$this->apiCallURL,"apiCallHttpVerb"=>$this->apiHttpVerb,"apiCallBrowser"=>$this->apiCallBrowser,
			"apicallIP"=>$this->apiCallIp,"apiCallPayload"=>$this->apiCallPayload];
		$statement->execute($parameters);

	}
}