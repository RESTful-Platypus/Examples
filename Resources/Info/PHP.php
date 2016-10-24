<?php
namespace Resources\Info;

/**
 * @self /info/php
 */
class PHP {
	/**
	 * @method get
	 */
	public function get() {
		ob_start();
		phpinfo();
		$info = ob_get_clean();
		$regex = '/<h[1-2]><.+?name="(.+?)">(.+?)<\/.+?><\/h[1-2]>|(<table>.+?<\/table>)/s';

		preg_match_all($regex, $info, $tables);

		list($_, $names, $headlines, $tables) = $tables;

		$result = [];
		$name = $headline = $table = '';

		for($i = 0; $i < count($_); $i++) {
			foreach(['name', 'headline', 'table'] as $key) {
				if(!empty(${$key.'s'}[$i])) {
					${$key} = ${$key.'s'}[$i];
				}
			}

			if(empty($name) or empty($headline) or empty($table)) {
				continue;
			}

			// number of keys equals cells per row
			preg_match_all('/<th>(.+?)<\/th>/', $table, $keys);
			preg_match_all('/<td.+?>(.+?)<\/td>/', $table, $values);

			$keys = array_map(function($key) {
				$key = strtolower($key);
				$key = preg_replace('/value$/', '', $key);
				$key = preg_replace('/[^a-z\-\._]/', '', $key);

				return $key;
			}, end($keys));

			if(empty($keys)) {
				$keys = ['name', 'value'];
			}

			$values = array_map('trim', end($values));
			$rows = array_chunk($values, count($keys));

			foreach($rows as &$row) {
				if(count($keys) != count($rows)) {
					continue;
				}

				$row = array_combine($keys, $row);
			}

			if(!isset($result[$name])) {
				$result[$name] = [
					'name' => $headline,
					'values' => []
				];
			}

			$result[$name]['values'][] = $rows;
		}

		return $result;
	}
}
