<?php
namespace Resources\Music;

/**
 * @self /music/song/{id}
 * @resource \\Resources\\Music\\Song
 */
class Song extends MPD {
	/**
	 * @method get
	 */
	public function get(string $id) {
		if(!preg_match('/^[a-z0-9\-]+$/', $id)) {
			throw new \Exception('id not 0-9a-z\-', 400);
		}

		$song = $this->mpd->query('find MUSICBRAINZ_TRACKID '.$id, false);

		if(empty($song)) {
			throw new \Exception('song not found', 404);
		}

		return new \Data\Music\Song($song);
	}
}
