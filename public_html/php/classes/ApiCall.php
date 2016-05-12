<?php
namespace Edu\Cnm\MlbScout;
require_once("autoload.php");

class ApiCall implements \JsonSerializable {
	use ValidateDate;
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
	 *Browser of the client
	 * @var string.
	 */
	private $apiCallBrowser;
	/**
	 * Time stamp of when the client connected
	 * @var \DateTime $apiCallDateTime
	 */
	private $apiCallDateTime;
	/**
	 * Gives PUT, POST, DELETE, UPDATE for authorized users
	 * @var string
	 */

	private $apiCallHttpVerb;
	/**
	 * The Clients IP
	 * @var $apiCallIp string;
	 */

	private $apiCallIp;
	/**
	 * The Content of the Clients String
	 * @var string
	 */

	private $apiCallQueryString;
	/**
	 * Content of the payload
	 * @var string
	 */

	private $apiCallPayload;
	/**
	 * The clients URL
	 * @var string
	 */

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
		$this->apiCallBrowser = $newApiCallBrowser;

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
			$this->apiCallDateTime = new \DateTime();
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
		$this->apiCallHttpVerb = $newApiCallHttpVerb;

	}


	public function getApiCallIp($userIp =false) {
		if($userIp === TRUE){
			return($this->apiCallIp);
		}
		return (inet_ntop($this->apiCallIp));
	}

	public function setApiCallIp(string $newApiCallIp) {
		$newApiCallIp = trim($newApiCallIp);
		$newApiCallIp = filter_var($newApiCallIp, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(empty($newApiCallIp) === TRUE) {
			throw(new\InvalidArgumentException("Api IP can't be empty"));
		}
		if(inet_pton($newApiCallIp)!==FALSE){
			$this->apiCallIp = $newApiCallIp;
		}else if(inet_ntop($newApiCallIp)!==FALSE){
			$this->apiCallIp = $newApiCallIp;
		}



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


		$this->apiCallQueryString = $newApiCallQueryString;
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
		$this->apiCallPayload = $newApiCallPayload;


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
		$this->apiCallURL = $newApiCallURL;

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
		$parameters = ["apiCallUserId" => $this->apiCallUserId, "apiCallDateTime" => $formattedDate, "apiCallQueryString" => $this->apiCallQueryString,
			"apiCallURL" => $this->apiCallURL, "apiCallHttpVerb" => $this->apiCallHttpVerb, "apiCallBrowser" => $this->apiCallBrowser,
			"apicallIP" => $this->apiCallIp, "apiCallPayload" => $this->apiCallPayload];
		$statement->execute($parameters);
		//Give me the lastInsert Id:
		$this->apiCallId	 = intval($pdo->lastInsertId());
	}

	public function delete(\Pdo $pdo) {

		if($this->apiCallUserId === null) {
			throw(new \PDOException("Well we can't delte something that isn't there now can we"));
		}
		//Delete By primary key
		$query = "DELETE FROM apiCall where apiCallId = :apiCallId";
		$statement = $pdo->prepare($query);
		$parameters = ["apiCallId" => $this->apiCallId];
		$statement->execute($parameters);

	}

	public function update(\Pdo $pdo) {
		if($this->apiCallId === null) {
			throw(new \PDOException("Well we can't update anything that doesn't exist now can we"));
		}

		$query = "UPDATE ApiCall SET apiCallId = :apiCallId, apiCallUserId = :apiCallUserId, apiCallBrowser=:apiCallBrowser,
								apiCallDateTime= :apiCallDateTime, apiCallHttpVerb= :apiCallHttpVerb,apiCallIP= :apiCallIp,
								apiCallQueryString= :apiCallQueryString, apiCallPayload= :apiCallPayload, apiCallURL= :apiCallURL";

		$statement = $pdo->prepare($query);
		//Bind the variable members
		$formattedDate = $this->apiCallDateTime->format("Y-m-d H:i:s");
		$parameters = ["apiCallUserId" => $this->apiCallUserId, "apiCallDateTime" => $formattedDate, "apiCallQueryString" => $this->apiCallQueryString,
			"apiCallURL" => $this->apiCallURL, "apiCallHttpVerb" => $this->apiCallHttpVerb, "apiCallBrowser" => $this->apiCallBrowser,
			"apicallIP" => $this->apiCallIp, "apiCallPayload" => $this->apiCallPayload];
		$statement->execute($parameters);

	}





	public function getApiCallByApiCallId(\PDO $pdo, string $ApiCallId) {
		if($ApiCallId <= 0) {
			throw(new \PDOException("User Id isn't positive"));
		}

		// create query template
		$query = "SELECT apiCallId, apiCallUserId, apiCallBrowser, apiCallDateTime,apiCallHttpVerb,apicallIP, apiCallQueryString,apiCallPayload, apiCallURL FROM apiCall WHERE apiCallId = :apiCallId";
		$statement = $pdo->prepare($query);
// bind the UserId to the place holder in the template
		$parameters = array("CallId" => $ApiCallId);
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

	public function getApiCallByUserId(\Pdo $pdo, string $ApiUserId) {
		$ApiUserId = trim($ApiUserId);
		$ApiUserId = filter_var($ApiUserId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($ApiUserId) === true) {
			throw(new \PDOException("User Id is invalid"));
		}
		$query = "SELECT apiCallId, apiCallUserId, apiCallDateTime, apiCallHttpVerb, apicallIP, apiCallQueryString,apiCallPayload, apiCallURL FROM apiCall WHERE apiCallBrowser = :apiCallBrowser";
		$statement = $pdo->prepare($query);
// bind the  to the place holder in the template
		$parameters = array("UserId" => $ApiUserId);
		$statement->execute($parameters);

		$ApiUserId = "%$ApiUserId%";
		$parameters = array("UserId" => $ApiUserId);
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

	public function getAllApiCall(\Pdo $pdo){
		$query = "SELECT apiCallId, apiCallUserId, apiCallBrowser, apiCallDateTime, apiCallHttpVerb, apiCallQueryString, apiCallPayload, apiCallURL FROM apiCall WHERE apiCallId = :apiCallId";
		$statement = $pdo->prepare($query);
		$statement->execute();
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

	}


	public function jsonSerialize() {
	$fields = get_object_vars($this);
	return ($fields);
	}
}