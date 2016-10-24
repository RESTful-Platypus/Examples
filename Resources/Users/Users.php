<?php
namespace Resources\Users;

/**
 * @self /users
 * @self /users/{?page}
 * @resource \\Resources\\Users\\User
 */
class Users extends AbstractUser {
	/**
	 * TODO
	 *
	 * @method get
	 * @provides application/json
	 */
	public function get($page = 1) {
		$users = $this->database->getUsers();
		$users = array_map(function($user) {
			return [
				'name' => $user->name,
				'_links' => [
					'self' => ['slug' => $user->slug]
				]
			];
		}, $users);

		return $users;
	}

	/**
	 * @method post
	 * @accept application/json
	 */
	public function add() {
		if(!($user = file_get_contents('php://input'))) {
			throw new \Exception('could not read input', 400);
		}

		if(!($user = json_decode($user))) {
			throw new \Exception('not valid json', 400);
		}

		if(!isset($user->name) or empty($user->name)) {
			throw new \Exception('name cannot be empty', 400);
		}

		// TODO: _self
		return $this->database->addUser($user->name);
	}
}
