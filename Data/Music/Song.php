<?php
namespace Data\Music;

class Song {
	public $id;
	public $title;
	public $album;
	public $artist;
	public $_links;

	public function __construct(array $song) {
		$this->id = $song['MUSICBRAINZ_TRACKID'];
		$this->title = $song['Title'];
		$this->album = $song['Album'];
		$this->artist = $song['Artist'];
		$this->_links = ['self' => ['id' => $this->id]];
	}

	public function addLink($link) {
		$this->_links = array_merge($this->_links, $link);
	}
}
