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
		if($newUserAccessLevelId <= 0) {
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
	 */
	public function setUserActivationToken($newUserActivationToken) {

		if($newUserActivationToken)
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
	 * @param string $newUserFirstName
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
	 */
	public function getUserHash() {
		return $this->userHash;
	}

	/**
	 * mutator method for user hash
	 */
	public function setUserHash($userHash) {
		$this->userHash = $userHash;
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
	 * @param string $newUserLastName
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
	 */
	public function getUserPassword() {
		return $this->userPassword;
	}

	/**
	 * mutator method for user password
	 */
	public function setUserPassword($userPassword) {
		$this->userPassword = $userPassword;
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
	 */
	public function getUserSalt() {
		return ($this->userSalt);
	}

	/**
	 * mutator method for user salt
	 */
	public function setUserSalt($userSalt) {
		$this->userSalt = $userSalt;
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

}