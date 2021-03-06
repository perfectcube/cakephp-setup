<?php
/**
 * ClearCache library class
 *
  * Copyright 2010, Marc Ypes, The Netherlands
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     2010 Marc Ypes, The Netherlands
 * @author        Ceeram
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Helps clear content of CACHE subfolders as well as content in cache engines
 *
 * @cakephp 2.0
 * based on https://github.com/ceeram/clear_cache/blob/master/Lib/ClearCache.php
 */
class ClearCacheLib {

	/**
	 * Clears content of cache engines
	 *
	 * @param mixed any amount of strings - keys of configure cache engines
	 * @return array associative array with cleanup results
	 */
	public function engines() {
		$result = [];

		$keys = Cache::configured();

		if ($engines = func_get_args()) {
			$keys = array_intersect($keys, $engines);
		}

		foreach ($keys as $key) {
			$result[$key] = Cache::clear(false, $key);
		}

		return $result;
	}

	/**
	 * Clears content of CACHE subfolders
	 *
	 * @param mixed any amount of strings - names of CACHE subfolders or '.' (dot) for CACHE folder itself
	 * @return array associative array with cleanup results
	 */
	public function files() {
		$deleted = $error = [];

		$folders = func_get_args();
		if (empty($folders)) {
			$folders = ['.', '*'];
		}

		if (count($folders) > 1) {
			$files = glob(CACHE . '{' . implode(', ', $folders) . '}' . DS . '*', GLOB_BRACE);
		} else {
			$files = glob(CACHE . $folders[0] . DS . '*');
		}

		foreach ($files as $file) {
			if (is_file($file) && basename($file) !== 'empty') {
				if (unlink($file)) {
					$deleted[] = $file;
				} else {
					$error[] = $file;
				}
			}
		}
		return compact('deleted', 'error');
	}

	/**
	 * Clears content of CACHE subfolders and configured cache engines
	 *
	 * @return array associative array with cleanup results
	 */
	public function run() {
		$files = $this->files();
		$engines = $this->engines();

		return compact('files', 'engines');
	}

}
