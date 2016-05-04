<?php
namespace Edu\cnm\jmedley4\mlbscout;

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
	 * @var string $userPhoneNumber
	 */
	private $userPhoneNumber;
	/**
	 * salt set for this user
	 * @var string $userSalt
	 */
	private $userSalt;
	
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
	 * not entirely sure how to write this one :) will come back, never.
	 */
	public function setUserActivationToken($newUserActivationToken) {

		if($newUserActivationToken )
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
		$newUserEmail - filter_var($newUserEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newUserEmail) === true) {
			throw(new \InvalidArgumentException("email is empty or insecure"));
		}

		//verify the email will fit in the database
		if(strlen($newUserEmail) > 64) {
			throw(new \RangeException("email is too large"));
		}

		// store the email
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
	 * 
	 */
	public function setUserFirstName($userFirstName) {
		$this->userFirstName = $userFirstName;
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
	 */
	public function getUserLastName() {
		return $this->userLastName;
	}

	/**
	 * mutator method for user last name
	 */
	public function setUserLastName($userLastName) {
		$this->userLastName = $userLastName;
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
	 */
	public function getUserPhoneNumber() {
		return $this->userPhoneNumber;
	}

	/**
	 * mutator method for user phone number
	 */
	public function setUserPhoneNumber($userPhoneNumber) {
		$this->userPhoneNumber = $userPhoneNumber;
	}

	/**
	 * accessor method for user salt
	 */
	public function getUserSalt() {
		return $this->userSalt;
	}

	/**
	 * mutator method for user salt
	 */
	public function setUserSalt($userSalt) {
		$this->userSalt = $userSalt;
	}

}