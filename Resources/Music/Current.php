<?php
namespace Resources\Music;

/**
 * @self /music/current
 * @next \\Resources\\Music\\Next
 * @song \\Resources\\Music\\Song
 * @resource \\Resources\\Music\\Song
 */
class Current extends MPD {
	/**
	 * @method get
	 */
	public function get() {
		$song = $this->mpd->query('currentsong', false);

		if(empty($song)) {
			throw new \Exception('not playing', 400);
		}

		$links = ['_links' => ['next' => []]];
		$song = new \Data\Music\Song($song);

		return array_merge($links, [get_object_vars($song)]);
	}
}
