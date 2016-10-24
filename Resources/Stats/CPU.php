<?php
namespace Resources\Stats;

/**
 * @self /stats/cpu
 * @ram \\Resources\\Stats\\RAM
 */
class CPU {
	/**
	 * @method get
	 */
	public function get() {
		$mem = $this->{strtolower(PHP_OS)}();

		return ['percent' => $mem];
	}

	/**
	 * Get the CPU usage on a linux-host.
	 *
	 * @return float Current usage.
	 */
	private function linux() {
		exec('top -bn1 | grep "Cpu(s)"', $cpu);

		return $cpu;

		// slow ...
		return floatval(exec('top -bn2 | grep "Cpu(s)" | sed "s/.*, *\([0-9.]*\)%* id.*/\1/" | awk \'{print 100 - $1}\''));
	}

	/**
	 * Get the CPU usage on a darwin-host.
	 *
	 * @return float Current usage.
	 */
	private function darwin() {
		$usage = exec('/bin/ps -A -o "%cpu" | /usr/bin/tail -n +2 | /usr/bin/awk \'{s+=$1} END {print s}\' 2>&1');
		$cores = exec('/usr/sbin/sysctl -n hw.ncpu');

		return $usage / $cores;
	}
}
