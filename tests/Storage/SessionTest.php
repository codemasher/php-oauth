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

use chillerlan\OAuth\Storage\SessionTokenStorage;
use chillerlan\OAuth\Token;

class SessionTest extends TokenStorageTestAbstract{

	const SESSION_VAR = 'chillerlan-oauth-token';
	const STATE_VAR   = 'chillerlan-oauth-state';

	/**
	 * @var \chillerlan\OAuth\Storage\SessionTokenStorage
	 */
	protected $storage;

	protected $FQCN = SessionTokenStorage::class;

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
		$this->assertSame([], $_SESSION[self::SESSION_VAR]);
		$this->assertSame([], $_SESSION[self::STATE_VAR]);
	}

	/**
	 * coverage
	 *
	 * @runInSeparateProcess
	 */
	public function testStoreTokenWithSessionVar(){
		$_SESSION[self::SESSION_VAR] = 'foo';

		$this->storage->storeAccessToken(self::SERVICE_NAME, $this->token);
		$tokenFromSession = unserialize($_SESSION[self::SESSION_VAR][self::SERVICE_NAME]);
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
		$_SESSION[self::STATE_VAR] = 'foo';

		$this->storage->storeAuthorizationState(self::SERVICE_NAME, 'foobar');
		$this->assertTrue($this->storage->hasAuthorizationState(self::SERVICE_NAME));
		$this->assertSame('foobar', $this->storage->retrieveAuthorizationState(self::SERVICE_NAME));
	}
}
