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

use chillerlan\OAuth\OAuthOptions;
use chillerlan\OAuth\Storage\SessionTokenStorage;
use PHPUnit\Framework\TestCase;

class SessionInstanceTest extends TestCase{

	protected $FQCN = SessionTokenStorage::class;

	/**
	 * @var \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	protected $storage;

	/**
	 * @runInSeparateProcess
	 */
	public function testWithWithoutStart(){
		$this->storage = new SessionTokenStorage(new OAuthOptions(['sessionStart' => false]));
		$this->assertInstanceOf($this->FQCN, $this->storage);
		$this->assertFalse($this->storage->sessionIsActive());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testWithExistingSession(){
		session_start();

		$this->storage = new SessionTokenStorage;
		$this->assertInstanceOf($this->FQCN, $this->storage);
		$this->assertTrue($this->storage->sessionIsActive());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testWithExistingSessionWithoutStart(){
		session_start();

		$this->storage = new SessionTokenStorage(new OAuthOptions(['sessionStart' => false]));
		$this->assertInstanceOf($this->FQCN, $this->storage);
		$this->assertTrue($this->storage->sessionIsActive());
	}

}
