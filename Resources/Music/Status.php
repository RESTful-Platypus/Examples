<?php
namespace Resources\Music;

/**
 * @self /music/status
 * @resource \\Resources\\Music\\Song
 */
class Status extends MPD {
	/**
	 * @method get
	 */
	public function get() {
		return $this->mpd->query('status', false);
	}
}
