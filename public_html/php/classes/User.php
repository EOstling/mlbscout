<?php
namespace Edu\cnm\jmedley4\mlbscout;

use MongoDB\Driver\Exception\UnexpectedValueException;

require_once ("autoload.php");
/**
 * User Class for MLBscout Capstone
 *
 * @author Jared Padilla <jaredpadilla16@gmail.com>
 * @see https://app.asana.com/0/117435671931068/118830311351365
 */
class User implements \JsonSerializable {
	
	/**
	 * id for the user who owns this profile; this is the primary key
	 * @var int $userId
	 */
	private $userId;
	/**
	 * access level id set for user; this is the foreign key
	 * @var int $userAccessLevelId
	 */
	private $userAccessLevelId;
	/**
	 * activation token for user account
	 * @var string $userActivationToken
	 */
	private $userActivationToken;
	/**
	 * email of this user
	 * @var string $userEmail
	 */
	private $userEmail;
	/**
	 * first name of this user
	 * @var string $userFirstName
	 */
	private $userFirstName;
	/**
	 * hash set for the user
	 * @var string $userHash
	 */
	private $userHash;
	/**
	 * last name of this user
	 * @var string $userLastName
	 */
	private $userLastName;
	/**
	 * password for this user
	 * @var string $userPassword
	 */
	private $userPassword;
	/**
	 * phone number of this user
	 * @var int $userPhoneNumber
	 */
	private $userPhoneNumber;
	/**
	 * salt set for this user
	 * @var string $userSalt
	 */
	private $userSalt;
	/**
	 * update function for this user
	 * @var string $userUpdate
	 */
	private $userUpdate;
	
	/**
	 * Constructor for this User
	 *
	 * 
	 */
	/**
	 * accessor method for user id
	 *
	 * @return int value of user id
	 */
	public function getUserId() {
		return ($this->userId);
	}

	/**
	 * mutator method for user id
	 *
	 * @param int $newUserId new value of user id
	 * @throws \RangeException if $newUserId is not positive
	 * @throws \TypeError if $newUserId is not an integer
	 */
	public function setUserId($newUserId) {
		//verify the profile id is positive
		if($newUserId <=0) {
			throw(new \RangeException("profile id is not positive"));

		}

		//convert and store the user id
		$this->userId = $newUserId;
	}

	/**
	 * accessor method for user access level id
	 *
	 * return int values of user access level id
	 */
	public function getUserAccessLevelId() {
		return ($this->userAccessLevelId);
	}

	/**
	 * mutator method for user access level id
	 *
	 * @param int $newUserAccessLevelId new value of user access level id
	 * @throws \RangeException if $newUserAccessLevelId is not positive
	 * @throws \TypeError if $newUserAccessLevelId is not an integer
	 */
	public function setUserAccessLevelId($newUserAccessLevelId) {
		// verify the  user access level id is positive
		if($newUserAccessLevelId <=0) {
			throw(new \RangeException("access level id is not positive"));
		}

		// convert and store the access level id
		$this->userAccessLevelId = $newUserAccessLevelId;
	}

	/**
	 * accessor method for user activation token
	 *
	 * @return string value of activation token
	 */
	public function getUserActivationToken() {
		return ($this->userActivationToken);
	}

	/**
	 * mutator method for user activation token
	 *
	 * @param string $newUserActivationToken new value
	 * @throws \RangeException if $newUserActivationToken is not positive
	 * @throws \TypeError if $newUserActivation in not an integer
	 */
	public function setUserActivationToken($newUserActivationToken) {

		// verify the user activation token is positive
		if($newUserActivationToken <=0) {
			throw(new \RangeException("user activation token is not positive"));
		}

		//convert and store the user activation token
		$this->userActivationToken = $newUserActivationToken;
	}

	/**
	 * accessor method for user email
	 *
	 * @return string value of email
	 */
	public function getUserEmail() {
		return ($this->userEmail);
	}

	/**
	 * mutator method for user email
	 * @param string $newUserEmail new value of email
	 * @throws \InvalidArgumentException if $newUserEmail is not a valid email or insecure
	 * @throws \RangeException if $newUserEmail is > 64 characters
	 * @throws \TypeError if $newUserEmail is not a string
	 */
	public function setUserEmail($newUserEmail) {
		//verify the user email is secure
		$newUserEmail = trim($newUserEmail);
		$newUserEmail = filter_var($newUserEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newUserEmail) === true) {
			throw(new \InvalidArgumentException("email is empty or insecure"));
		}

		//verify the user email will fit in the database
		if(strlen($newUserEmail) > 64) {
			throw(new \RangeException("email is too large"));
		}

		// store the user email
		$this->userEmail = $newUserEmail;
	}

	/**
	 * accessor method for user first name
	 *
	 * @return string value of user first name
	 */
	public function getUserFirstName() {
		return ($this->userFirstName);
	}

	/**
	 * mutator method for user first name
	 *
	 * @param string $newUserFirstName new value of first name
	 * @throws UnexpectedValueException if $newUserFirstName is not valid
	 * @throws \RangeException if $newUserFirstName is > 32 characters
	 */
	public function setUserFirstName($newUserFirstName) {
		// verify the first name is valid
		$newUserFirstName = filter_var($newUserFirstName, FILTER_SANITIZE_STRING);
		if($newUserFirstName === false) {
			throw(new \UnexpectedValueException("first name is not a valid string"));
		}

		//verify the user first name will fit in the database
		if(strlen($newUserFirstName) > 32) {
			throw(new \RangeException("first name is too long please change it"));
		}

		// store the user first name
		$this->userFirstName = $newUserFirstName;
	}

	/**
	 * accessor method for user hash
	 *
	 * @return string value of user hash
	 */
	public function getUserHash() {
		return ($this->userHash);
	}

	/**
	 * mutator method for user hash
	 *
	 * @param string $newUserHash new value of user hash
	 * @throws \InvalidArgumentException if $newUser hash is not a string or insecure
	 * @throws \RangeException if $newUserHash is > 128 characters
	 * @throws \TypeError if $newUserHash is not a string
	 */
	public function setUserHash($newUserHash) {
		// verify the user hash is secure
		$newUserHash = trim($newUserHash);
		$newUserHash = filter_var($newUserHash, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserHash === true)) {
			throw(new \InvalidArgumentException("user hash is empty or insecure"));
		}

		// verify hash will fit in the database
		if(strlen($newUserHash) > 128) {
			throw(new \RangeException("user hash is too large"));
		}

		// store the user hash
		$this->userHash = $newUserHash;
	}

	/**
	 * accessor method for user last name
	 *
	 * @return string value of user last name
	 */
	public function getUserLastName() {
		return ($this->userLastName);
	}

	/**
	 * mutator method for user last name
	 * @param string $newUserLastName new value of user last name
	 * @throws UnexpectedValueException if $newUserLastName is not valid
	 * @throws \RangeException if $newUserLastName is > 32 characters
	 */
	public function setUserLastName($newUserLastName) {
		// verify the Last name is valid
		$newUserLastName = filter_var($newUserLastName, FILTER_SANITIZE_STRING);
		if($newUserLastName === false) {
			throw(new \UnexpectedValueException("last name is not a valid string"));
		}

		//verify the user last name will fit in the database
		if(strlen($newUserLastName) > 32) {
			throw(new \RangeException("last name is too long please change it"));
		}

		// store the user last name
		$this->userLastName = $newUserLastName;
	}

	/**
	 * accessor method for user password
	 *
	 * @return string value of user password
	 */
	public function getUserPassword() {
		return ($this->userPassword);
	}

	/**
	 * mutator method for user password
	 *
	 * @throws \InvalidArgumentException if $newUserPassword is not a string or insecure
	 * @throws \RangeException if $newUserPassword is > 64 characters
	 * @throws \TypeError if $newUserPassword is not a string
	 */
	public function setUserPassword($newUserPassword) {
		// verify the user password is secure
		$newUserPassword = trim($newUserPassword);
		$newUserPassword = filter_var($newUserPassword, FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserPassword) === true) {
			throw(new \InvalidArgumentException("user password is empty or insecure"));
		}

		//verify the password will fit in the database
		if(strlen($newUserPassword) > 64) {
			throw(new \RangeException("user password is too large"));
		}

		// store the user password
		$this->userPassword = $newUserPassword;
	}

	/**
	 * accessor method for user phone number
	 *
	 * @return int value of user phone number
	 */
	public function getUserPhoneNumber() {
		return ($this->userPhoneNumber);
	}

	/**
	 * mutator method for user phone number
	 *
	 * @param int $newUserPhoneNumber new value of user phone number
	 * @throws \InvalidArgumentException if $newUserPhoneNumer is not a integer
	 * @throws \TypeError if $newUserPhoneNumber is not a string
	 */
	public function setUserPhoneNumber($newUserPhoneNumber) {
		// verify the user phone number is secure
		$newUserPhoneNumber = trim($newUserPhoneNumber);
		$newUserPhoneNumber = filter_var($newUserPhoneNumber, FILTER_VALIDATE_INT);
		if(empty($newUserPhoneNumber) === true) {
			throw(new \InvalidArgumentException("user phone number is empty or insecure"));
		}

		// store the user phone number
		$this->userPhoneNumber = $newUserPhoneNumber;
	}

	/**
	 * accessor method for user salt
	 *
	 * @return string value for user salt
	 */
	public function getUserSalt() {
		return ($this->userSalt);
	}

	/**
	 * mutator method for user salt
	 *
	 * @param string $newUserSalt new value of user salt
	 * @throws \InvalidArgumentException if $newUserSalt is not a string or insecure
	 * @throws \RangeException if $newUserSalt is > 64 characters
	 * @throws \TypeError if $newUserSalt is not a string
	 */
	public function setUserSalt($newUserSalt) {
		//verify the user salt is secure
		$newUserSalt = trim($newUserSalt);
		$newUserSalt = filter_var($newUserSalt, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserSalt) === true) {
			throw(new \InvalidArgumentException("users salt is empty or insecure"));
		}

		// verify the user salt will fit in the database
		if(strlen($newUserSalt) > 64) {
			throw(new \RangeException ("user salt it too large"));
		}


		//store the user salt
		$this->userSalt = $newUserSalt;
	}

	/**
	 * accessor method for user update
	 *
	 * @return string value of user update
	 */
	public function getUserUpdate() {
		return ($this->userUpdate);
	}

	/**
	 * mutator method for user update
	 *
	 * @param string $newUserUpdate new value of user update
	 * @throws \InvalidArgumentException if $newUserUpdate is not a string or insecure
	 * @throws \RangeException if $newUserUpdate is > 64
	 * @throws \TypeError if $newUserUpdate is not a string
	 */
	public function setUserUpdate($newUserUpdate) {
		// verify the user update is secure
		$newUserUpdate = trim($newUserUpdate);
		$newUserUpdate = filter_var($newUserUpdate, FILTER_SANITIZE_STRING);
		if(empty($newUserUpdate) === true) {
			throw(new \InvalidArgumentException("user update is empty or insecure"));
		}

		//verify the user update will fit in the database
		if(strlen($newUserUpdate) > 64) {
			throw(new \RangeException("user update too large"));
		}

		// store the user update
		$this->userUpdate = $newUserUpdate;
	}

	/**
	 * inserts this User into mySQL
	 *
	 * @param PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		// enforce the user is null
		if($this->userId !==null) {
			throw(new \PDOException("user already exist"));
		}

		// create query template
		$query = "INSERT INTO user(userId, userAccessLevelId, userActivationToken, userEmail, userUpdate, userSalt, userPhoneNumber, userPassword, userLastName, userHash, userFirstName) VALUES(:userId, :userAccessLevel, userActivatioonToken, :userEmail, :userUpdate, :userSalt, :userPhoneNumber, :userPassword, :user:astName, :userHash, :userFirstName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["userId" => $this->userId, "userAccessLevelId" => $this->userAccessLevelId, "userActivationToken" => $this->userActivationToken, "userEmail" => $this->userEmail, "userUpdate" => $this->userUpdate, "userSalt" => $this->userSalt, "userPhoneNumber" => $this->userPhoneNumber, "userPassword" => $this->userPassword, "userLastName" => $this->userLastName, "userHash" => $this->userHash, "userFirstName" => $this->userFirstName];
		$statement -> execute($parameters);

		//update the null userId with what mySQL just game us
		$this->userId = intval($pdo->lastInsertId());
	}

	/**
	 *deletes this User from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object 
	 * */
	public function delete(\PDO $pdo) {
		//enforce the userId is not null
		if($this->userId === null) {
			throw(new \PDOException("unable to delete a user that does not exist"));
		}

		// create a query template
		$query = "DELETE FROM user WHERE userId = :userId";
		$statement = $pdo ->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = ["userId" => $this->userId];
		$statement->execute($parameters);
	}

}