<?php
/**
 *
 * @filesource   SessionInstanceTest.php
 * @created      11.07.2016
 * @package      chillerlan\OAuthTest\Storage
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2016 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Storage;

use chillerlan\OAuth\{
	OAuthOptions, Storage\SessionTokenStorage
};
use PHPUnit\Framework\TestCase;

class SessionInstanceTest extends TestCase{

	/**
	 * @runInSeparateProcess
	 */
	public function testWithWithoutStart(){
		$this->assertFalse((new SessionTokenStorage(new OAuthOptions(['sessionStart' => false])))->sessionIsActive());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testWithExistingSession(){
		session_start();

		$this->assertTrue((new SessionTokenStorage)->sessionIsActive());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testWithExistingSessionWithoutStart(){
		session_start();

		$this->assertTrue((new SessionTokenStorage(new OAuthOptions(['sessionStart' => false])))->sessionIsActive());
	}

}
