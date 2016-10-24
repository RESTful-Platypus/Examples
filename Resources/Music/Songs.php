<?php
namespace Resources\Music;

/**
 * @self /music/songs{?page}
 * @resource \\Resources\\Music\\Song
 */
class Songs extends MPD {
	/**
	 * @method get
	 */
	public function songs($page) {
		$songs = $this->mpd->query('list Title group Album group Artist group MUSICBRAINZ_TRACKID');
		$songs = array_filter($songs, function($song) {
			return @$song['Title'] and @$song['Album'] and @$song['Artist'] and @$song['MUSICBRAINZ_TRACKID'];
		});
		$songs = array_map(function($song) {
			return new \Data\Music\Song($song);
		}, $songs);

		$songs = array_splice($songs, $page * 5, 5);
		$links = ['_links' => ['next' => ['page' => $page + 1]]];

		return array_merge($links, $songs);
	}
}
