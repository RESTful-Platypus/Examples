<?php
namespace Data\Users;

class Database {
	/**
	 * @type Array[User]
	 */
	private $users;

	/**
	 * @type string
	 */
	private $filename = 'users.txt';

	public function __construct() {
		$users = file_get_contents($this->filename);
		$users = explode(PHP_EOL, $users);
		$users = array_filter($users);

		foreach($users as $index => $name) {
			$this->users[] = new User($index, $name);
		}
	}

	public function getUser(string $slug): User {
		$users = array_filter($this->users, function($user) use($slug) {
			return $user->slug == $slug;
		});

		if(empty($users)) {
			throw new \Exception('not found', 404);
		}

		return reset($users);
	}

	public function getUsers(): array {
		return $this->users;
	}

	public function addUser(string $name): User {
		$user = new User(count($this->users), $name);

		if(!@file_put_contents($this->filename, $user->name.PHP_EOL, FILE_APPEND)) {
			throw new \Exception('internal server error', 500);
		}

		return $user;
	}
}
