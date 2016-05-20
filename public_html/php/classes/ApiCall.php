<?php
namespace Edu\Cnm\MlbScout;

require_once("autoload.php");
class ApiCall implements \JsonSerializable {
	use ValidateDate;
	/**
	 * ApiCall ID this is the Primary key
	 * @var INT $apiCallId
	 **/
	private $apiCallId;
	/**
	 * User Id this is the Foreign key
	 * @var INT $apiCallUserId
	 **/
	private $apiCallUserId;
	/**
	 *Browser of the client
	 * @var string..
	 **/
	private $apiCallBrowser;
	/**
	 * Time stamp of when the client connected
	 * @var \DateTime $apiCallDateTime
	 **/
	private $apiCallDateTime;
	/**
	 * Gives PUT, POST, DELETE, UPDATE for authorized users
	 * @var string
	 **/
	private $apiCallHttpVerb;
	/**
	 * The Clients IP
	 * @var $apiCallIP string;
	 **/
	private $apiCallIP;
	/**
	 * The Content of the Clients String
	 * @var string
	 **/
	private $apiCallQueryString;
	/**
	 * Content of the payload
	 * @var string
	 **/
	private $apiCallPayload;
	/**
	 * The clients URL
	 * @var string
	 **/
	private $apiCallURL;
	/**
	 * ApiCall constructor.
	 * @param int|null $newApiCallId
	 * @param int $newApiCallUserId
	 * @param string $newApiCallBrowser
	 * @param \DateTime $newApiCallDateTime
	 * @param string $newApiCallHttpVerb
	 * @param string $newApiCallIp
	 * @param string $newApiCallQueryString
	 * @param string $newApiCallPayload
	 * @param string $newApiCallURL
	 * @throws \Exception
	 * @throws \TypeError
	 * @throws \InvalidArgumentException
	 * @throws \RangeException
	 **/
	public function __construct(int $newApiCallId = null, int $newApiCallUserId, string $newApiCallBrowser, $newApiCallDateTime = null, string $newApiCallHttpVerb, string $newApiCallIp, string $newApiCallQueryString, string $newApiCallPayload, string $newApiCallURL) {
		try {
			$this->setApiCallId($newApiCallId);
			$this->setApiCallUserId($newApiCallUserId);
			$this->setApiCallBrowser($newApiCallBrowser);
			$this->setApiCallDateTime($newApiCallDateTime);
			$this->setApicallHttpVerb($newApiCallHttpVerb);
			$this->setApiCallIP($newApiCallIp);
			$this->setApiCallQueryString($newApiCallQueryString);
			$this->setApiCallPayload($newApiCallPayload);
			$this->setApiCallURL($newApiCallURL);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * @return INT
	 **/
	public function getApiCallId() {
		return ($this->apiCallId);
	}
	/**
	 * @param int $newApiCallId
	 **/
	public function setApiCallId(int $newApiCallId = null) {
		if($newApiCallId === null) {
			$this->apiCallId = null;
			return;
		}
		$this->apiCallId = $newApiCallId;
	}
	/**
	 * @return INT ApiCallUserId
	 **/
	public function getApiCallUserId() {
		return($this->apiCallUserId);
	}
	/**
	 * @param int $newApiCallUserId
	 * @throws \RangeException
	 * @throws \TypeError
	 **/
	public function setApiCallUserId(int $newApiCallUserId) {
		if($newApiCallUserId <= 0) {
			throw(new \RangeException("profile id is not positive"));
		}

		$this->apiCallUserId = $newApiCallUserId;
	}
	/**
	 * @return string
	 **/
	public function getApiCallBrowser() {
		return ($this->apiCallBrowser);
	}
	/**
	 * @throws \InvalidArgumentException
	 * @throws \RangeException
	 * @param string $newApiCallBrowser
	 **/
	public function setApiCallBrowser(string $newApiCallBrowser) {
		$newApiCallBrowser = trim($newApiCallBrowser);
		$newApiCallBrowser = filter_var($newApiCallBrowser, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newApiCallBrowser) === true) {
			throw(new\InvalidArgumentException("Api Browser can't be empty"));
		}
		if(strlen($newApiCallBrowser) > 128) {
			throw(new\RangeException("Browser is out of my range"));
		}
		$this->apiCallBrowser = $newApiCallBrowser;
	}
	/**
	 * @return \DateTime
	 **/
	public function getApiCallDateTime() {
		return ($this->apiCallDateTime);
	}
	/**
	 * @param null $newApiCallDateTime
	 **/
	public function setApiCallDateTime($newApiCallDateTime = null) {
		if($newApiCallDateTime !== null) {
			$this->apiCallDateTime = $this->validateDate($newApiCallDateTime);
		}
		if($newApiCallDateTime === null) {
			$this->apiCallDateTime = new \DateTime();
			return;
		}
	}
	/**
	 * @return string
	 **/
	public function getApiCallHttpVerb() {
		return ($this->apiCallHttpVerb);
	}
	/**
	 * @throws \InvalidArgumentException
	 * @param string $newApiCallHttpVerb
	 **/
	public function setApiCallHttpVerb(string $newApiCallHttpVerb) {
		$verb = $newApiCallHttpVerb;
		if($verb !== "GET" && $verb !== "POST" && $verb !== "PUT" && $verb !== "DELETE") {
			throw(new\InvalidArgumentException("Api Verb must be Get, Put, Post or Delete"));
		}
		$this->apiCallHttpVerb = $newApiCallHttpVerb;
	}
	/**
	 * @param bool $userIp
	 * @return string
	 **/
	public function getApiCallIP(bool $userIp = false) {
		if($userIp === true){
			return($this->apiCallIP);
		}
		return (inet_ntop($this->apiCallIP));
	}
	/**
	 * @throws \InvalidArgumentException
	 * @param string $newApiCallIp
	 **/
	public function setApiCallIP(string $newApiCallIp) {
//		$newApiCallIp = trim($newApiCallIp);
//		$newApiCallIp = filter_var($newApiCallIp, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newApiCallIp) === true) {
			throw(new \InvalidArgumentException("Api IP can't be empty"));
		}

		if(@inet_pton($newApiCallIp) === false) {
			if(@inet_ntop($newApiCallIp) === false) {
				throw(new \InvalidArgumentException("Invalid IP"));
			} else {
				$this->apiCallIP = $newApiCallIp;
			}
		} else {
			$this->apiCallIP = inet_pton($newApiCallIp);
		}
	}
	/**
	 * @return string
	 **/
	public function getApiCallQueryString() {
		return ($this->apiCallQueryString);
	}
	/**
	 * @throws \InvalidArgumentException
	 * @throws \RangeException
	 * @param  $newApiCallQueryString
	 **/
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
	/**
	 * @return string
	 **/
	public function getApiCallPayload() {
		return ($this->apiCallPayload);
	}
	/**
	 * @throws \InvalidArgumentException
	 * @throws \RangeException
	 * @param  $newApiCallPayload
	 **/
	public function setApiCallPayload(string $newApiCallPayload) {
		$newApiCallPayload = trim($newApiCallPayload);
		$newApiCallPayload = filter_var($newApiCallPayload, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newApiCallPayload) === true) {
			throw(new\InvalidArgumentException("Payload cant be empty"));
		}
		if(strlen($newApiCallPayload) > 128) {
			throw(new\RangeException("Too long"));
		}
		$this->apiCallPayload = $newApiCallPayload;
	}
	/**
	 * @return string
	 **/
	public function getApiCallURL() {
		return ($this->apiCallURL);
	}
	/**
	 * @throws \InvalidArgumentException
	 * @throws \RangeException
	 * @param  string $newApiCallURL
	 **/
	public function setApiCallURL(string $newApiCallURL) {
		$newApiCallURL = trim($newApiCallURL);
		$newApiCallURL = filter_var($newApiCallURL, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newApiCallURL) === true) {
			throw(new\InvalidArgumentException("Api call Url can't be empty"));
		}
		if(strlen($newApiCallURL) > 128) {
			throw(new\RangeException("URL is too long"));
		}
		$this->apiCallURL = $newApiCallURL;
	}

	/**
	 * @param \Pdo $pdo
	 * @throws \InvalidArgumentException
	 **/
	public function insert(\Pdo $pdo) {
		if($this->apiCallId !== null) {
			throw(new \InvalidArgumentException("wat"));
		}
		//Lets create $query;
		$query = "INSERT INTO apiCall(apiCallUserId, apiCallBrowser, apiCallDateTime, apiCallHttpVerb, apiCallIP, apiCallQueryString,apiCallPayload, apiCallURL)VALUES(:apiCallUserId, :apiCallBrowser, :apiCallDateTime, :apiCallHttpVerb, :apiCallIP, :apiCallQueryString, :apiCallPayload, :apiCallURL)";
		$statement = $pdo->prepare($query);
		//Bind the data
		$formattedDate = $this->apiCallDateTime->format("Y-m-d H:i:s");
		$parameters = ["apiCallUserId" => $this->apiCallUserId, "apiCallDateTime" => $formattedDate, "apiCallQueryString" => $this->apiCallQueryString, "apiCallURL" => $this->apiCallURL, "apiCallHttpVerb" => $this->apiCallHttpVerb, "apiCallBrowser" => $this->apiCallBrowser, "apiCallIP" => $this->apiCallIP, "apiCallPayload" => $this->apiCallPayload];
		$statement->execute($parameters);
		//Give me the lastInsert Id:
		$this->apiCallId = intval($pdo->lastInsertId());
	}
	/**
	 * @throws \PDOException
	 * @param \Pdo $pdo
	 **/
	public function delete(\Pdo $pdo) {
		if($this->apiCallUserId === null) {
			throw(new \PDOException("Well we can't delete something that isn't there now can we"));
		}
		//Delete By primary key
		$query = "DELETE FROM apiCall where apiCallId = :apiCallId";
		$statement = $pdo->prepare($query);
		$parameters = ["apiCallId" => $this->apiCallId];
		$statement->execute($parameters);
	}
	/**
	 * @throws \PDOException
	 * @param \Pdo $pdo
	 **/
	public function update(\PDO $pdo) {
		if($this->apiCallId === null) {
			throw(new \PDOException("Well we can't update anything that doesn't exist now can we"));
		}
		$query = "UPDATE apiCall SET  apiCallUserId = :apiCallUserId, apiCallBrowser= :apiCallBrowser,
								apiCallDateTime = :apiCallDateTime, apiCallHttpVerb = :apiCallHttpVerb, apiCallIP= :apiCallIP,
								apiCallQueryString = :apiCallQueryString, apiCallPayload= :apiCallPayload, apiCallURL= :apiCallURL WHERE apiCallId = :apiCallId";
		$statement = $pdo->prepare($query);
		//Bind the variable members
		$formattedDate = $this->apiCallDateTime->format("Y-m-d H:i:s");
		$parameters = ["apiCallId"=>$this->apiCallId ,"apiCallUserId" => $this->apiCallUserId, "apiCallDateTime" => $formattedDate, "apiCallQueryString" => $this->apiCallQueryString,
			"apiCallURL" => $this->apiCallURL, "apiCallHttpVerb" => $this->apiCallHttpVerb, "apiCallBrowser" => $this->apiCallBrowser,
			"apiCallIP" => $this->apiCallIP, "apiCallPayload" => $this->apiCallPayload];
		$statement->execute($parameters);
	}
	/**
	 * @throws \PdoException
	 * @param \PDO $pdo
	 * @param  $apiCallId
	 * @return apiCall|null
	 **/
	public function getApiCallByApiCallId(\PDO $pdo, int $apiCallId) {
		if($apiCallId <= 0) {
			throw(new \PDOException("User Id isn't positive"));
		}
		// create query template
		$query = "SELECT apiCallId, apiCallUserId, apiCallBrowser, apiCallDateTime, apiCallHttpVerb, apiCallIP, apiCallQueryString,apiCallPayload, apiCallURL FROM apiCall WHERE apiCallId = :apiCallId";
		$statement = $pdo->prepare($query);
		// bind the UserId to the place holder in the template
		$parameters = array("apiCallId" => $apiCallId);
		$statement->execute($parameters);
		try {
			$apiCall = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$apiCall = new apiCall($row["apiCallId"], $row["apiCallUserId"], $row["apiCallBrowser"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["apiCallDateTime"]),$row["apiCallHttpVerb"],$row["apiCallIP"],$row["apiCallQueryString"],$row["apiCallPayload"], $row["apiCallURL"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($apiCall);
	}
	/**
	 *@throws \Exception
 	* @throws \PDOException
 	* @param string string $ApiCallUserId
	 * @return \SplFixedArray ApiCalls
 **/
	public function getApiCallByApiCallUserId(\Pdo $pdo, string $ApiCallUserId) {
		$ApiCallUserId = trim($ApiCallUserId);
		$ApiCallUserId = filter_var($ApiCallUserId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($ApiCallUserId) === true) {
			throw(new \PDOException("User Id is invalid"));
		}
		$query = "SELECT apiCallId, apiCallUserId, apiCallBrowser, apiCallDateTime, apiCallHttpVerb, apiCallIP, apiCallQueryString,apiCallPayload, apiCallURL FROM apiCall WHERE apiCallUserId = :userId";
		$statement = $pdo->prepare($query);
		// bind the  to the place holder in the template
		$parameters = array("userId" => $ApiCallUserId);
		$statement->execute($parameters);
		// Build an array of Browsers
		$apiCalls = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$apiCall = new apiCall($row["apiCallId"], $row["apiCallUserId"], $row["apiCallBrowser"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["apiCallDateTime"]), $row["apiCallHttpVerb"], $row["apiCallIP"], $row["apiCallQueryString"], $row["apiCallPayload"], $row["apiCallURL"]);
				$apiCalls[$apiCalls->key()] = $apiCall;
				$apiCalls->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($apiCalls);
	}
	/**
	 * @throws \PDOException
	 * @param \Pdo $pdo
	 **/
	public function getAllApiCall(\Pdo $pdo){
		$query = "SELECT apiCallId, apiCallUserId, apiCallBrowser, apiCallDateTime, apiCallHttpVerb, apiCallIP, apiCallQueryString,apiCallPayload, apiCallURL FROM apiCall WHERE apiCallId = :apiCallId";
		$statement = $pdo->prepare($query);
		$statement->execute();
		$apiCalls = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$apiCall = new apiCall($row["CallId"], $row["UserId"], $row["Browser"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["apiCallDateTime"]), $row["ApiHttpVerb"], $row["ApiIp"], $row["ApiQueryString"], $row["ApiPayload"], $row["ApiURL"]);
				$apiCalls[$apiCalls->key()] = $apiCall;
				$apiCalls->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
	}
	/**
	 * @return array
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
}