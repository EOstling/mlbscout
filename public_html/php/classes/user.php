<?php
namespace Edu\cnm\jmedley4\mlbscout;

require_once ("autoload.php");
/**
 * User Class for MLBscout Capstone
 *
 * @author Jared Padilla <jaredpadilla16@gmail.com>
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
	 * activation token for user account
	 */
	private $userActivationToken;
	/**
	 * api call for user
	 */
	private $userApiCall;
	/**
	 * email of this user
	 */
	private $userEmail;
	/**
	 * first name of this user
	 */
	private $userFirstName;
	/**
	 * hash set for the user
	 */
	private $userHash;
	/**
	 * last name of this user
	 */
	private $userLastName;
	/**
	 * password for this user
	 */
	private $userPassword;
	/**
	 * phone number of this user
	 */
	private $userPhoneNumber;
	/**
	 * salt set for this user
	 */
	private $userSalt;

	/**
	 * accessor method for user id
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * mutator method for user id
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
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
	 * accessor method for user activation token
	 */
	public function getUserActivationToken() {
		return $this->userActivationToken;
	}

	/**
	 * mutator method for user activation token
	 */
	public function setUserActivationToken($userActivationToken) {
		$this->userActivationToken = $userActivationToken;
	}

	/**
	 * accessor method for user api call
	 */
	public function getUserApiCall() {
		return $this->userApiCall;
	}

	/**
	 * mutator method for user api call
	 */
	public function setUserApiCall($userApiCall) {
		$this->userApiCall = $userApiCall;
	}

	/**
	 * accessor method for user email
	 */
	public function getUserEmail() {
		return $this->userEmail;
	}

	/**
	 * mutator method for user email
	 */
	public function setUserEmail($userEmail) {
		$this->userEmail = $userEmail;
	}

	/**
	 * accessor method for user first name
	 */
	public function getUserFirstName() {
		return $this->userFirstName;
	}

	/**
	 * mutator method for user first name
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