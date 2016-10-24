<?php
namespace Resources\Music;

/**
 * @self /music/next
 * @current \\Resources\\Music\\Current
 * @song \\Resources\\Music\\Song
 * @resource \\Resources\\Music\\Song
 */
class Next extends MPD {
	/**
	 * @method get
	 */
	public function next() {
		$status = $this->mpd->query('status', false);
		$song = $this->mpd->query('playlistinfo '.$status['nextsong'], false);

		if(empty($song)) {
			throw new \Exception('not playing', 400);
		}

		$links = ['_links' => ['next' => []]];
		$song = new \Data\Music\Song($song);

		return array_merge($links, [get_object_vars($song)]);
	}

	/**
	 * @method post
	 */
	public function skip() {
		$status = $this->mpd->query('next', false);
		$current = new Current;

		return $current->get();
	}
}
