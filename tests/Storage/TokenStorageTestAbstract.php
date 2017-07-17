<?php
/**
 * Class TokenStorageTestAbstract
 *
 * @filesource   TokenStorageTestAbstract.php
 * @created      11.07.2016
 * @package      chillerlan\OAuthTest\Storage
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2016 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Storage;

use chillerlan\OAuth\Storage\TokenStorageInterface;
use chillerlan\OAuth\Token;
use PHPUnit\Framework\TestCase;

abstract class TokenStorageTestAbstract extends TestCase{

	const SERVICE_NAME = 'Spotify';

	/**
	 * @var \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	protected $storage;

	/**
	 * @var \chillerlan\OAuth\Token
	 */
	protected $token;

	/**
	 * @var string FQCN
	 */
	protected $FQCN;

	protected function setUp(){
		$this->storage = new $this->FQCN;
		$this->token   = new Token(['accessToken' => 'foobar']);
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testInterface(){
		$this->assertInstanceOf($this->FQCN, $this->storage);
		$this->assertInstanceOf(TokenStorageInterface::class, $this->storage);
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testTokenStorage(){
		$this->storage->storeAccessToken(self::SERVICE_NAME, $this->token);
		$this->assertTrue($this->storage->hasAccessToken(self::SERVICE_NAME));
		$this->assertSame('foobar', $this->storage->retrieveAccessToken(self::SERVICE_NAME)->accessToken);

		$this->storage->storeAuthorizationState(self::SERVICE_NAME, 'foobar');
		$this->assertTrue($this->storage->hasAuthorizationState(self::SERVICE_NAME));
		$this->assertSame('foobar', $this->storage->retrieveAuthorizationState(self::SERVICE_NAME));

		$this->storage->clearAuthorizationState(self::SERVICE_NAME);
		$this->assertFalse($this->storage->hasAuthorizationState(self::SERVICE_NAME));

		$this->storage->clearAccessToken(self::SERVICE_NAME);
		$this->assertFalse($this->storage->hasAccessToken(self::SERVICE_NAME));
	}


	/**
	 * @runInSeparateProcess
	 */
	public function testClearAllAccessTokens(){
		$range = ['Spotify', 'LastFM', 'Twitter'];
		$this->storage->clearAllAccessTokens();

		foreach($range as $k){
			$this->assertFalse($this->storage->hasAccessToken($k));
			$this->storage->storeAccessToken($k, $this->token);
			$this->assertTrue($this->storage->hasAccessToken($k));
		}

		foreach($range as $k){
			$this->assertFalse($this->storage->hasAuthorizationState($k));
			$this->storage->storeAuthorizationState($k, 'foobar');
			$this->assertTrue($this->storage->hasAuthorizationState($k));
		}

		$this->storage->clearAllAuthorizationStates();

		foreach($range as $k){
			$this->assertFalse($this->storage->hasAuthorizationState($k));
		}

#		$this->storage->clearAllAccessTokens();

		foreach($range as $k){
			$this->assertFalse($this->storage->hasAccessToken($k));
		}

	}


	/**
	 * @runInSeparateProcess
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage state not found
	 */
	public function testRetrieveAuthorizationStateNotFoundException(){
		$this->storage->retrieveAuthorizationState('LOLNOPE');
	}

	/**
	 * @runInSeparateProcess
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage token not found
	 */
	public function testRetrieveAccessTokenNotFoundException(){
		$this->storage->retrieveAccessToken('LOLNOPE');
	}

}
