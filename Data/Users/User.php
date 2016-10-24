<?php
namespace Data\Users;

class User {
	public $id;
	public $name;
	public $slug;

	public function __construct(int $id, string $name) {
		$regex = '/[^a-z0-9\-_]/i';

		$this->id = $id;
		$this->name = preg_replace($regex, '', $name);
		$this->slug = strtolower($this->name);
		$this->slug = preg_replace($regex, '', $this->slug);
	}
}
