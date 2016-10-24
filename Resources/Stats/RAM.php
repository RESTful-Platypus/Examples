<?php
namespace Resources\Stats;

/**
 * @self /stats/ram
 * @cpu \\Resources\\Stats\\CPU
 */
class RAM {
	/**
	 * @method get
	 */
	public function get() {
		$links = ['_links' => ['cpu' => []]];
		$mem = $this->{strtolower(PHP_OS)}();
		$mem = [
			'total' => $mem[0],
			'used' => $mem[1],
			'free' => $mem[2],
			'percent' => round(100 / $mem[0] * $mem[1], 2)
		];

		return array_merge($links, $mem);
	}

	/**
	 * Get the RAM usage on a linux-host.
	 *
	 * @return array [total, used, free]
	 */
	private function linux() {
		exec('free -m', $free);

		for($i = 0; $i < count($free); $i++) {
			preg_match_all('/([0-9]+)/', $free[$i], $free[$i]);
		}

		if(count($free) < 4) {
			return null;
		}

		return [$free[1][1][0], $free[2][1][0], $free[2][1][1]];
	}

	/**
	 * Get the RAM usage on a darwin-host.
	 *
	 * @return array [total, used, free]
	 */
	private function darwin() {
		$mem = ['memsize', 'usermem'];
		$mem = array_map(function($mem) {
			exec('/usr/sbin/sysctl hw.'.$mem, $mem);

			return $mem[0];
		}, $mem);
		$mem = array_map(function($mem) {
			preg_match('/^[a-z\.]+\:\s+([0-9]+)$/i', $mem, $mem);

			return $mem[1];
		}, $mem);
		$mem = array_map(function($mem) {
			return floor($mem / (1024 ** 2));
		}, $mem);

		return [$mem[0], $mem[0] - $mem[1], $mem[1]];
	}
}
