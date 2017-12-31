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

use chillerlan\OAuth\{
	OAuthOptions, Token, Storage\TokenStorageInterface
};
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
	 * @var \chillerlan\OAuth\OAuthOptions
	 */
	protected $options;

	/**
	 * @var string FQCN
	 */
	protected $FQCN;

	protected function setUp(){

		$this->options = new OAuthOptions([
			'storageCryptoKey' => '000102030405060708090a0b0c0d0e0f101112131415161718191a1b1c1d1e1f',
			'dbUserID' => 1,
		]);

		$this->storage = new $this->FQCN($this->options);
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

		$this->storage->clearAllAccessTokens();

		foreach($range as $k){
			$this->assertFalse($this->storage->hasAccessToken($k));
		}

	}


	/**
	 * @runInSeparateProcess
	 * @expectedException \chillerlan\OAuth\Storage\TokenStorageException
	 * @expectedExceptionMessage state not found
	 */
	public function testRetrieveAuthorizationStateNotFoundException(){
		$this->storage->retrieveAuthorizationState('LOLNOPE');
	}

	/**
	 * @runInSeparateProcess
	 * @expectedException \chillerlan\OAuth\Storage\TokenStorageException
	 * @expectedExceptionMessage token not found
	 */
	public function testRetrieveAccessTokenNotFoundException(){
		$this->storage->retrieveAccessToken('LOLNOPE');
	}

}
