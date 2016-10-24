<?php
namespace Resources\Users;

/**
 * @self /users/{slug}
 */
class User extends AbstractUser {
	/**
	 * @return object User
	 *
	 * @method get
	 * @provides *\/*
	 * @provides application/json
	 */
	public function get(string $slug) {
		return $this->database->getUser($slug);
	}
}
