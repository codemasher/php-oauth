<?php
/**
 * Trait Magic
 *
 * @filesource   Magic.php
 * @created      28.06.2017
 * @package      chillerlan\OAuth\Traits
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Traits;

/**
 * @link https://github.com/codemasher/php-prototype-dom/blob/master/src/Traits/Magic.php
 */
trait Magic{

	/**
	 * @param string $name
	 *
	 * @return null
	 */
	public function __get(string $name) {
		return $this->get($name);
	}

	/**
	 * @codeCoverageIgnore unused
	 * @param string $name
	 * @param        $value
	 */
	public function __set(string $name, $value) {
		$this->set($name, $value);
	}

	/**
	 * @param string $name
	 *
	 * @return null
	 */
	private function get(string $name) {
		$method = 'magic_get_'.$name;

		return method_exists($this, $method) ? $this->$method() : null;
	}

	/**
	 * @codeCoverageIgnore unused
	 * @param string $name
	 * @param        $value
	 */
	private function set(string $name, $value) {
		$method = 'magic_set_'.$name;

		if(method_exists($this, $method)){
			$this->$method($value);
		}

	}

}
