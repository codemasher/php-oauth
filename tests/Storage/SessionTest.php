<?php
/**
 *
 * @filesource   SessionTest.php
 * @created      11.07.2016
 * @package      chillerlan\OAuthTest\Storage
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2016 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Storage;

use chillerlan\OAuth\{
	Storage\SessionTokenStorage, Storage\TokenStorageInterface, Token
};

/**
 * @property \chillerlan\OAuth\Storage\SessionTokenStorage $storage
 */
class SessionTest extends TokenStorageTestAbstract{

	protected function initStorage():TokenStorageInterface{
		return new SessionTokenStorage($this->options);
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testInterface(){
		parent::testInterface();
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testTokenStorage(){
		parent::testTokenStorage();
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testClearAllAccessTokens(){
		parent::testClearAllAccessTokens();
	}

	/**
	 * @runInSeparateProcess
	 * @expectedException \chillerlan\OAuth\Storage\TokenStorageException
	 * @expectedExceptionMessage state not found
	 */
	public function testRetrieveAuthorizationStateNotFoundException(){
		parent::testRetrieveAuthorizationStateNotFoundException();
	}

	/**
	 * @runInSeparateProcess
	 * @expectedException \chillerlan\OAuth\Storage\TokenStorageException
	 * @expectedExceptionMessage token not found
	 */
	public function testRetrieveAccessTokenNotFoundException(){
		parent::testRetrieveAccessTokenNotFoundException();
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testToStorage(){
		parent::testToStorage();
	}

	/**
	 * @runInSeparateProcess
	 * @expectedException \chillerlan\OAuth\Storage\TokenStorageException
	 * @expectedExceptionMessage sodium extension installed/enabled?
	 */
	public function testMissingSodiumExtension(){
		parent::testMissingSodiumExtension();
	}

	/**
	 * coverage
	 *
	 * @runInSeparateProcess
	 */
	public function testDestruct(){
		$this->assertTrue($this->storage->sessionIsActive());
		$this->storage->__destruct();
		$this->assertTrue(session_status() === PHP_SESSION_NONE);
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testSessionVars(){
		$this->assertSame([], $_SESSION[$this->options->sessionTokenVar]);
		$this->assertSame([], $_SESSION[$this->options->sessionStateVar]);
	}

	/**
	 * coverage
	 *
	 * @runInSeparateProcess
	 */
	public function testStoreTokenWithSessionVar(){
		$_SESSION[$this->options->sessionTokenVar] = 'foo';

		$this->storage->storeAccessToken(self::SERVICE_NAME, $this->token);
		$tokenFromSession = new Token(json_decode($_SESSION[$this->options->sessionTokenVar][self::SERVICE_NAME], true));
		$this->assertInstanceOf(Token::class, $tokenFromSession);
		$this->assertSame('foobar', $tokenFromSession->accessToken);
		$tokenFromStorage = $this->storage->retrieveAccessToken(self::SERVICE_NAME);
		$this->assertInstanceOf(Token::class, $tokenFromStorage);
		$this->assertSame('foobar', $tokenFromStorage->accessToken);
	}

	/**
	 * coverage
	 *
	 * @runInSeparateProcess
	 */
	public function testStoreAuthorizationStateWithSessionVar(){
		$_SESSION[$this->options->sessionStateVar] = 'foo';

		$this->storage->storeAuthorizationState(self::SERVICE_NAME, 'foobar');
		$this->assertTrue($this->storage->hasAuthorizationState(self::SERVICE_NAME));
		$this->assertSame('foobar', $this->storage->retrieveAuthorizationState(self::SERVICE_NAME));
	}

}
