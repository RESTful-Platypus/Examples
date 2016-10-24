<?php
namespace Resources\Users;

abstract class AbstractUser {
	/**
	 * @type \Data\Users\Database
	 */
	protected $database;

	public function __construct() {
		$this->database = new \Data\Users\Database;
	}
}
