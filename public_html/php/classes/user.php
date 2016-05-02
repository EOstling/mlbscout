<?php
namespace Edu\cnm\jmedley4\mlbscout;

/**
 * User Class for MLBscout Capstone
 *
 * @author Jared Padilla <jaredpadilla16@gmail.com>
 * @version 1.0.0
 * @see https://app.asana.com/0/117435671931068/118830311351365
 */
class User {
	/**
	 * id for the user who owns this profile; this is the primary key
	 */
	private $userId;
	/**
	 * access level id set for user; this is the foreign key
	 */
	private $userAccessLevelId;
	/**
	 * email of this user
	 */
	private $userEmail;
	/**
	 * first name of this user
	 */
	private $userFirstName;
	/**
	 * last name of this user
	 */
	private $userLastName;
	/**
	 * phone number of this user
	 */
	private $userPhoneNumber;
	/**
	 * password for this user
	 */
	private $userPassword;
	/**
	 * api call for user
	 */
	private $userApiCall;
	/**
	 * hash set for the user
	 */
	private $userHash;
	/**
	 * salt set for this user
	 */
	private $userSalt;
	/**
	 * activation token for user account
	 */
	private $userActivationToken;

	/**
	 * accessor method for user id
	 *
	 * @return int value of user id
	 */
	public function getUserId () {
		return($this->userId);
	}

	/**
	 * mutator method for user id
	 */
	public function setUserId ($newUserId) {
		// verify the user id is valid
		$newUserId = filter_var($newUserId, FILTER_VALIDATE_INT);
		if ($newUserId === false) {
			throw(new UnexpectedValueException ("user id is not a valid integer"));
		}

		// convert and store the user id
		$this->userId = intval($newUserId);
	}

	/**
	 * accessor method for user access level id
	 */
	public function getUserAccessLevelId() {
		return $this->userAccessLevelId;
	}

	/**
	 * mutator method for user access level id
	 */
	public function setUserAccessLevelId($userAccessLevelId) {
		$this->userAccessLevelId = $userAccessLevelId;
	}

	/**
	 * accessor method for user email
	 *
	 */
	public function getUserEmail() {
		return $this->userEmail;
	}

	/**
	 * mutator method for user email
	 */
	public function setUserEmail($newUserEmail) {
		$this->userEmail = $userEmail;
	}

	/**
	 * accessor method for user first name
	 *
	 * @return string value of user first name
	 */
	public public function getUserFirstName() {
		return $this->userFirstName;
	}

	/**
	 * mutator method for user first name
	 *
	 * @param string $newUserFirstName
	 * @throws UnexpectedValueException if $newUserFirstName is not valid
	 */
	public function setUserFirstName($newUserFirstName) {
		// verify the first name is valid
		
		$this->userFirstName = $userFirstName;
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
	 * accessor method for user phone number
	 */
	public function getUserPhoneNumber() {
		return $this->userPhoneNumber;
	}

	/**
	 * mutator method for user phone number
	 */
	public public function setUserPhoneNumber($userPhoneNumber) {
		$this->userPhoneNumber = $userPhoneNumber;
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
	 * accessor method for user api call
	 */
	public function getUserApiCall() {
		return $this->userApiCall;
	}

	/**
	 * mutator method for api call
	 */
	public function setUserApiCall($userApiCall) {
		$this->userApiCall = $userApiCall;
	}

	/**
	 * accessor method for user hash
	 */
	public function getUserHash {
		return $this->userHash;
	}

	/**m
	 * mutator method for user hash
	 */
	public function setUserHash($userHash) {
		$this->userHash = $userHash;
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

	/**
	 * accessor method for user activation key
	 */
	public function getUserActivationToken() {
		return $this->userActivationToken;
	}

	/**
	 * mutator method for user activation key
	 */
	public function setUserActivationToken($userActivationToken) {
		$this->userActivationToken = $userActivationToken;
	}

}