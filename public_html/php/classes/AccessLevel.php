<?php
namespace Edu\cnm\jmedley4\mlbscout;

require_once ("autoload.php");
/**
 * access level class for MLB scout Capstone
 *
 * @author Jared Padilla <jaredpadilla16@gmail.com>
 */
class accessLevel implements \JsonSerializable {

	/*
	 * access level id for user; this is the primary key
	 */
	private $accessLevelId;

	/**
	 * access level set for user
	 */
	private $accessLevelName;
	
	/**
	 * accessor method for access level id
	 */
	public function getAccessLevelId() {
		return $this->accessLevelId;
	}
	
	/**
	 * mutator method for access level id
	 */
	public function setAccessLevelId($accessLevelId) {
		$this->accessLevelId = $accessLevelId;
	}
	
	/**
	 * accessor method for access level name
	 */
	public function getAccessLevelName() {
		return $this->accessLevelName;
	}
	
	/**
	 * mutator method for access level name
	 */
	public function setAccessLevelName($accessLevelName) {
		$this->accessLevelName = $accessLevelName;
	}


}