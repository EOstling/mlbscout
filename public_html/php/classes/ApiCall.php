<?php
namespace Edu\Cnm\MlbScout;
class ApiCall implements \JsonSerializable {
	use \Edu\Cnm\MlbScout\ValidateDate;

	private $apiCallId;

	private $apiCallUserId;

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

		} catch (\InvalidArgumentException $invalidArgument) {
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

	public function getApiCallHttpVerb() {
		return ($this->apiCallHttpVerb);
	}

	public function setApiCallHttpVerb(string $newApiCallHttpVerb) {

		$verb = $newApiCallHttpVerb;
		if($verb !== "GET" && $verb !== "POST" && $verb !== "PUT" && $verb!=="DELETE"){
			throw(new\InvalidArgumentException("Api Verb must be Get, Put, Post or Delete"));

		}
		$this->ApiCallHttpVerb=$newApiCallHttpVerb;

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
			throw(new\RangeException(""));
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
							"apiCallURL"=>$this->apiCallURL,"apiCallHttpVerb"=>$this->apiCallHttpVerb,"apiCallBrowser"=>$this->apiCallBrowser,
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
			"apiCallURL"=>$this->apiCallURL,"apiCallHttpVerb"=>$this->apiCallHttpVerb,"apiCallBrowser"=>$this->apiCallBrowser,
			"apicallIP"=>$this->apiCallIp,"apiCallPayload"=>$this->apiCallPayload];
		$statement->execute($parameters);

	}

	public function getApiCallByApiUserId(\PDO $pdo, string $ApiUserId){
		if($ApiUserId <= 0) {
			throw(new \PDOException("User Id isn't positive"));
		}

		// create query template
		$query = "SELECT apiCallId, apiCallUserId, apiCallBrowser, apicallIP, apiCallQueryString,apiCallPayload, apiCallURL FROM apiCall WHERE apiCallId = :apiCallId";
		$statement = $pdo->prepare($query);

	}


	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
}