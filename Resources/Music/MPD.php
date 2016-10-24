<?php
namespace Resources\Music;

abstract class MPD {
	protected $mpd;

	public function __construct() {
		$config = \Data\Config::getInstance();
		list($host, $port) = array_values($config::get('mpd'));
		$this->mpd = new \Data\Music\MPD($host, $port);
	}
}
