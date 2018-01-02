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
	OAuthOptions, Storage\TokenStorageInterface, Token
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

		$this->options = $this->options ?? new OAuthOptions([
			'storageCryptoKey' => '000102030405060708090a0b0c0d0e0f101112131415161718191a1b1c1d1e1f',
			'dbUserID' => 1,
		]);

		$this->token   = new Token(['accessToken' => 'foobar']);
		$this->storage = $this->initStorage();
	}

	abstract protected function initStorage():TokenStorageInterface;

	public function testInterface(){
		$this->assertInstanceOf(TokenStorageInterface::class, $this->storage);
	}

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
	 * @expectedException \chillerlan\OAuth\Storage\TokenStorageException
	 * @expectedExceptionMessage state not found
	 */
	public function testRetrieveAuthorizationStateNotFoundException(){
		$this->storage->retrieveAuthorizationState('LOLNOPE');
	}

	/**
	 * @expectedException \chillerlan\OAuth\Storage\TokenStorageException
	 * @expectedExceptionMessage token not found
	 */
	public function testRetrieveAccessTokenNotFoundException(){
		$this->storage->retrieveAccessToken('LOLNOPE');
	}

	public function testToStorage(){
		$a = $this->storage->toStorage($this->token);
		$b = $this->storage->fromStorage($a);

		$this->assertInternalType('string', $a);
		$this->assertInstanceOf(Token::class, $b);
		$this->assertEquals($this->token, $b);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Storage\TokenStorageException
	 * @expectedExceptionMessage sodium extension installed/enabled?
	 */
	public function testMissingSodiumExtension(){

		if(PHP_MINOR_VERSION >= 2 && function_exists('sodium_crypto_secretbox')){
			$this->markTestSkipped('soduim enabled');
		}

		$this->options->useEncryption = true;
		$this->initStorage();
	}

}
