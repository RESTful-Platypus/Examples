<?php
namespace Data;

class Config {
	private static $config;
	private static $instance;

	public static function getInstance() {
		if(!isset(static::$instance)) {
			static::$instance = new static;
		}

		static::$config = parse_ini_file('config.ini.php', true);

		return static::$instance;
	}

	public static function get($section) {
		return static::$config[$section];
	}
}
