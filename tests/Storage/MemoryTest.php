<?php
/**
 *
 * @filesource   MemoryTest.php
 * @created      11.07.2016
 * @package      chillerlan\OAuthTest\Storage
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2016 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Storage;

use chillerlan\OAuth\Storage\MemoryTokenStorage;
use chillerlan\OAuth\Storage\TokenStorageInterface;

/**
 * @property \chillerlan\OAuth\Storage\MemoryTokenStorage $storage
 */
class MemoryTest extends TokenStorageTestAbstract{

	protected function initStorage($options):TokenStorageInterface{
		return new MemoryTokenStorage($options);
	}

}
