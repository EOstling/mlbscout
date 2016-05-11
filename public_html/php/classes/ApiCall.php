<?php
namespace Edu\Cnm\MlbScout;
class ApiCall implements \JsonSerializable {
	use \Edu\Cnm\MlbScout\ValidateDate;
	/**
	 * ApiCall ID this is the Primary key
	 * @var INT $apiCallId
	 */
	private $apiCallId;
	/**
	 * User Id this is the Foreign key
	 * @var INT $apiCallUserId
	 */

	private $apiCallUserId;
	/**
	 *
	 */
	private $apiCallBrowser;

	private $apiCallDateTime;

	private $apiCallHttpVerb;

	private $apiCallIp;

	private $apiCallQueryString;

	private $apiCallPayload;

	private $apiCallURL;


	public function __construct(int $newApiCallId, int $newApiCallUserId, string $newApiCallBrowser,
										 \DateTime $newApiCallDateTime, string $newApiCallHttpVerb, string $newApiCallIp,
										 string $newApiCallQueryString, string $newApiCallPayload, string $newApiCallURL) {
		try {
			$this->setapiCallId($newApiCallId);
			$this->setApiCallUserId($newApiCallUserId);
			$this->setApiCallBrowser($newApiCallBrowser);
			$this->setApiCallDateTime($newApiCallDateTime);
			$this->setApicallHttpVerb($newApiCallHttpVerb);
			$this->setApiCallip($newApiCallIp);
			$this->setApiCallQueryString($newApiCallQueryString);
			$this->setApiCallPayload($newApiCallPayload);
			$this->setApiCallURL($newApiCallURL);

		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}


	}

//ApiCallId
	public function getApiCallId() {
		return ($this->apiCallId);
	}

	public function setApicallId(int $newApiCallId) {
		if($newApiCallId === null) {
			$this->apiCallId = null;
			return;
		}
		$this->apiCallId = $newApiCallId;
	}
	public function getApiCallUserId() {
		return ($this->apiCallUserId);
	}

	public function setApiCallUserId(int $newApiCallUserId) {
		if($newApiCallUserId <= 0) {
			throw(new \RangeException("profile id is not positive"));
		}
		$this->apiCallUserId = $newApiCallUserId;

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
		if(strlen($newApiCallBrowser) > 128) {
			throw(new\RangeException("Browser is out of my range"));
		}
		$this->getApiCallBrowser = $newApiCallBrowser;

	}

//DateTime
	public function getApiCallDateTime() {
		return ($this->apiCallDateTime);
	}

	public function setApiCallDateTime($newApiCallDateTime = null) {

		if($newApiCallDateTime !== null) {
			$this->apiCallDateTime = $this->validateDate($newApiCallDateTime);
		}

		if($newApiCallDateTime === null) {
			$this->ApiCallDateTime = new \DateTime();
			return;
		}
	}

	public function getApiCallHttpVerb() {
		return ($this->apiCallHttpVerb);
	}

	public function setApiCallHttpVerb(string $newApiCallHttpVerb) {

		$verb = $newApiCallHttpVerb;
		if($verb !== "GET" && $verb !== "POST" && $verb !== "PUT" && $verb !== "DELETE") {
			throw(new\InvalidArgumentException("Api Verb must be Get, Put, Post or Delete"));

		}
		$this->ApiCallHttpVerb = $newApiCallHttpVerb;

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


	public function getApiCallQueryString() {
		return ($this->apiCallQueryString);
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
			throw(new\RangeException("Too long"));
		}
		$this->getApiCallPayload = $newApiCallPayload;


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


	public function insert(\Pdo $pdo) {
		if($this->apiCallId !== null) {
			throw(new\PDOException("This is incorrect"));
		}
		//Lets create $query;
		$query = "INSERT INTO apiCall( apiCallUserId, apiCallBrowser,apiCallHttpVerb,apiCallIP,apiCallQueryString,apiCallPayload,apiCallURL )VALUES(:apiCallUserId, :apiCallBrowser,:apiCallHttpVerb, :apiCallIP, :apiCallQueryString, :apiCallPayload, :apiCallURL)";
		$statement = $pdo->prepare($query);
		//Bind the data

		$formattedDate = $this->apiCallDateTime->format("Y-m-d H:i:s");
		$parameters = ["apiCallUserId" => $this->apiCallUserId, "apiCallDateTime" => $this->apiCallDateTime, "apiCallQueryString" => $this->apiCallQueryString,
			"apiCallURL" => $this->apiCallURL, "apiCallHttpVerb" => $this->apiCallHttpVerb, "apiCallBrowser" => $this->apiCallBrowser,
			"apicallIP" => $this->apiCallIp, "apiCallPayload" => $this->apiCallPayload];
		$statement->execute($parameters);
		//Give me the lastInsert Id:
		$this->apiCall = intval($pdo->lastInsertId());
	}

	public function delete(\Pdo $pdo) {

		if($this->apiCallUserId === null) {
			throw(new \PDOException("Well we can't delte something that isn't there now can we"));
		}
		$query = "DELETE FROM ApiCall where apiCallId = :apiCallId";
		$statement = $pdo->prepare($query);
		$parameters = ["apiCallId" => $this->apiCallId];
		$statement->execute($parameters);

	}

	public function update(\Pdo $pdo) {
		if($this->apiCallId === null) {
			throw(new \PDOException("Well we can't update anything that doesn't exist now can we"));
		}
		$query = "UPDATE ApiCall SET apiCallId = :apiCallId, apiCallUserId = :apiCallUserId, apiCallURL = :apiCallURL,
					apiCallBrowser = :apiCallBrowser, apicallIP = :apiCallIp,";
		$statement = $pdo->prepare($query);
		//Bind the variable members
		$formattedDate = $this->apiCallDateTime->format("Y-m-d H:i:s");
		$parameters = ["apiCallUserId" => $this->apiCallUserId, "apiCallDateTime" => $this->apiCallDateTime, "apiCallQueryString" => $this->setApiCallQueryString,
			"apiCallURL" => $this->apiCallURL, "apiCallHttpVerb" => $this->apiCallHttpVerb, "apiCallBrowser" => $this->apiCallBrowser,
			"apicallIP" => $this->apiCallIp, "apiCallPayload" => $this->apiCallPayload];
		$statement->execute($parameters);

	}

	public function getApiCallByApiUserId(\PDO $pdo, string $ApiUserId) {
		if($ApiUserId <= 0) {
			throw(new \PDOException("User Id isn't positive"));
		}

		// create query template
		$query = "SELECT apiCallId, apiCallUserId, apiCallBrowser, apiCallDateTime,apiCallHttpVerb,apicallIP, apiCallQueryString,apiCallPayload, apiCallURL FROM apiCall WHERE apiCallId = :apiCallId";
		$statement = $pdo->prepare($query);
// bind the UserId to the place holder in the template
		$parameters = array("UserId" => $ApiUserId);
		$statement->execute($parameters);

		try {
			$apiCall = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$apiCall = new \apiClass($row["UserId"], $row["CallId"], $row["Browser"], $row["ApiDateTime"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($apiCall);
	}

	public function getApiCallByApiBrowser(\Pdo $pdo, string $ApiBrowser) {
		$ApiBrowser = trim($ApiBrowser);
		$ApiBrowser = filter_var($ApiBrowser, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($ApiBrowser) === true) {
			throw(new \PDOException("Browser is invalid"));
		}
		$query = "SELECT apiCallId, apiCallUserId, apiCallDateTime, apiCallHttpVerb, apicallIP, apiCallQueryString,apiCallPayload, apiCallURL FROM apiCall WHERE apiCallBrowser = :apiCallBrowser";
		$statement = $pdo->prepare($query);
// bind the  to the place holder in the template
		$parameters = array("Browser" => $ApiBrowser);
		$statement->execute($parameters);

		$ApiBrowser = "%$ApiBrowser%";
		$parameters = array("ApiBrowser" => $ApiBrowser);
		$statement->execute($parameters);

		// build an array of Browsers
		$apiCalls = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$apiCall = new apiCall($row["UserId"], $row["CallId"], $row["Browser"], $row["ApiDateTime"], $row["ApiHttpVerb"], $row["ApiIp"], $row["ApiQueryString"], $row["ApiPayload"], $row["ApiURL"]);
				$apiCalls[$apiCalls->key()] = $apiCall;
				$apiCalls->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($apiCalls);

	}

	public function getApiCallByIp(\Pdo $pdo, $ApiCallIp) {

		$ApiCallIp = trim($ApiCallIp);
		$ApiCallIp = filter_var($ApiCallIp, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($ApiCallIp) === true) {
			throw(new \PDOException("Browser is invalid"));
		}
		$query = "SELECT apiCallId, apiCallUserId, apiCallBrowser, apiCallDateTime, apiCallHttpVerb, apiCallQueryString, apiCallPayload, apiCallURL FROM apiCall WHERE apiCallIp = :apiCallIp";
		$statement = $pdo->prepare($query);
// bind the  id to the place holder in the template
		$parameters = array("Ip" => $ApiCallIp);
		$statement->execute($parameters);

		$ApiCallIp = "%$ApiCallIp%";
		$parameters = array("ApiCallIp" => $ApiCallIp);
		$statement->execute($parameters);

		// build an array of IP
		$apiCalls = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$apiCall = new apiCall($row["UserId"], $row["CallId"], $row["Browser"], $row["ApiDateTime"], $row["ApiHttpVerb"], $row["ApiIp"], $row["ApiQueryString"], $row["ApiPayload"], $row["ApiURL"]);
				$apiCalls[$apiCalls->key()] = $apiCall;
				$apiCalls->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($apiCalls);

	}


	public function getApiCallByQueryString(\Pdo $pdo, $ApiCallQueryString) {

		$ApiCallQueryString = trim($ApiCallQueryString);
		$ApiCallQueryString = filter_var($ApiCallQueryString, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($ApiCallQueryString) === true) {
			throw(new \PDOException("Browser is invalid"));
		}
		$query = "SELECT apiCallId, apiCallUserId, apiCallBrowser, apiCallDateTime,apiCallHttpVerb,apicallIP, ,apiCallPayload, apiCallURL FROM apiCall WHERE apiCallQueryString = :apiCallQueryString";
		$statement = $pdo->prepare($query);
// bind the  id to the place holder in the template
		$parameters = array("Query String" => $ApiCallQueryString);
		$statement->execute($parameters);

		$ApiCallQueryString = "%$ApiCallQueryString%";
		$parameters = array("Query String" => $ApiCallQueryString);
		$statement->execute($parameters);

		// build an array of Query String
		$apiCalls = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$apiCall = new apiCall($row["UserId"], $row["CallId"], $row["Browser"], $row["ApiDateTime"], $row["ApiHttpVerb"], $row["ApiIp"], $row["ApiQueryString"], $row["ApiPayload"], $row["ApiURL"]);
				$apiCalls[$apiCalls->key()] = $apiCall;
				$apiCalls->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($apiCalls);

	}

	public function getApiCallByPayload(\Pdo $pdo, $ApiCallPayload){

		$ApiCallPayload = trim($ApiCallPayload);
		$ApiCallPayload = filter_var($ApiCallPayload, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($ApiCallPayload) === true) {
			throw(new \PDOException("Payload is invalid"));
		}
		$query = "SELECT apiCallId, apiCallUserId, apiCallBrowser, apiCallDateTime, apiCallHttpVerb, apicallIP,  apiCallQueryString, apiCallURL FROM apiCall WHERE apiCallPayload = :apiCallPayload";
		$statement = $pdo->prepare($query);
// bind the  id to the place holder in the template
		$parameters = array("Payload" => $ApiCallPayload);
		$statement->execute($parameters);

		$ApiCallPayload = "%$ApiCallPayload%";
		$parameters = array("Payload" => $ApiCallPayload);
		$statement->execute($parameters);

		// build an array of Query String
		$apiCalls = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$apiCall = new apiCall($row["UserId"], $row["CallId"], $row["Browser"], $row["ApiDateTime"], $row["ApiHttpVerb"], $row["ApiIp"], $row["ApiQueryString"], $row["ApiPayload"], $row["ApiURL"]);
				$apiCalls[$apiCalls->key()] = $apiCall;
				$apiCalls->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($apiCalls);

	}


	public function getApiCallByURL(\PDO $pdo, $ApiCallURL){


		$ApiCallURL = trim($ApiCallURL);
		$ApiCallURL = filter_var($ApiCallURL, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($ApiCallURL) === true) {
			throw(new \PDOException("URL is invalid"));
		}
		$query = "SELECT apiCallId, apiCallUserId, apiCallBrowser, apiCallDateTime, apiCallHttpVerb, apiCallQueryString, apiCallPayload, FROM apiCall WHERE apiCallURL = :apiCallURL";
		$statement = $pdo->prepare($query);
// bind the  id to the place holder in the template
		$parameters = array("URL" => $ApiCallURL);
		$statement->execute($parameters);

		$ApiCallURL = "%$ApiCallURL%";
		$parameters = array("URL" => $ApiCallURL);
		$statement->execute($parameters);

		// build an array of Query String
		$apiCalls = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$apiCall = new apiCall($row["CallId"], $row["UserId"], $row["Browser"], $row["ApiDateTime"], $row["ApiHttpVerb"], $row["ApiIp"], $row["ApiQueryString"], $row["ApiPayload"], $row["ApiURL"]);
				$apiCalls[$apiCalls->key()] = $apiCall;
				$apiCalls->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($apiCalls);

	}













	public function jsonSerialize() {
	$fields = get_object_vars($this);
	return ($fields);
	}
}