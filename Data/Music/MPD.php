<?php
namespace Data\Music;

class MPD {
	private $host;
	private $port;
	private $socket;

	public function __construct($host, $port) {
		$this->host = $host;
		$this->port = $port;
	}

	public function open() {
		$this->socket = @fsockopen($this->host, $this->port, $code, $error, 2);

		if(!$this->socket) {
			throw new \Exception($error, 500);
		}
	}

	public function close() {
		if(!$this->socket) {
			return;
		}

		// fclose($this->socket);
	}

	/**
	 * https://www.musicpd.org/doc/protocol/command_reference.html
	 */
	public function query($command, $group = true) {
		$this->open();

		fwrite($this->socket, trim($command).PHP_EOL.PHP_EOL);

		$out = '';

		while(!feof($this->socket)) {
			$out .= fgets($this->socket, 128);
		}

		$out = $this->parse($out, $group);

		$this->close();

		return $out;
	}

	public function parse($in, $group) {
		$out = [];
		$block = [];
		$lines = explode(PHP_EOL, $in);

		// if(strpos($lines[0], 'OK MPD') !== 0) {
		// 	throw new \Exception($lines[0]);
		// }

		foreach($lines as $line) {
			$line = explode(':', $line, 2);
			$line = array_map('trim', $line);

			if(count($line) != 2) {
				continue;
			}

			list($key, $value) = $line;

			if($group and isset($block[$key])) {
				$out[] = $block;
				$block = [];
			}

			$block[$key] = $value;
		}

		$out[] = $block;

		return $group ? $out : $out[0];
	}
}
