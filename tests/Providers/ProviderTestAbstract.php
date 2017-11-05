<?php
/**
 * Class ProviderTestAbstract
 *
 * @filesource   ProviderTestAbstract.php
 * @created      22.10.2017
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\{
	HTTP\HTTPClientAbstract,
	HTTP\OAuthResponse,
	OAuthOptions,
	Providers\OAuthInterface,
	Storage\MemoryTokenStorage,
	Storage\TokenStorageInterface,
	Token
};
use PHPUnit\Framework\TestCase;
use ReflectionClass, ReflectionMethod, ReflectionProperty;

abstract class ProviderTestAbstract extends TestCase{

	const HOST      = 'http://localhost';
	const BASE_PATH = '/php-oauth-rewrite/tests/web'; // @todo Travis reminder

	/**
	 * @var string
	 */
	protected $FQCN;

	/**
	 * @var \ReflectionClass
	 */
	protected $reflection;

	/**
	 * @var \chillerlan\OAuth\HTTP\HTTPClientInterface
	 */
	protected $http;

	/**
	 * @var \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	protected $storage;

	/**
	 * @var \chillerlan\OAuth\OAuthOptions
	 */
	protected $options;

	/**
	 * @var \chillerlan\OAuth\Providers\OAuthInterface
	 */
	protected $provider;

	protected function setUp(){

		$this->http = new class extends HTTPClientAbstract{
			public function request(string $url, array $params = [], string $method = 'POST', $body = null, array $headers = []):OAuthResponse{
				return new OAuthResponse;
			}
		};

		$this->options  = new OAuthOptions([
			'key'         => 'testkey',
			'secret'      => 'testsecret',
			'callbackURL' => self::HOST.self::BASE_PATH.'/callback',
		]);

		$this->storage    = new MemoryTokenStorage;
		$this->reflection = new ReflectionClass($this->FQCN);

		$this->provider = $this->reflection->newInstanceArgs([$this->http, $this->storage, $this->options]);
		$this->storage->storeAccessToken($this->provider->serviceName, new Token(['accessToken' => 'foo']));
	}

	/**
	 * @param string $method
	 *
	 * @return \ReflectionMethod
	 */
	protected function getMethod(string $method):ReflectionMethod {
		$method = $this->reflection->getMethod($method);
		$method->setAccessible(true);

		return $method;
	}

	/**
	 * @param string $property
	 *
	 * @return \ReflectionProperty
	 */
	protected function getProperty(string $property):ReflectionProperty{
		$property = $this->reflection->getProperty($property);
		$property->setAccessible(true);

		return $property;
	}

	/**
	 * @param        $object
	 * @param string $property
	 * @param        $value
	 *
	 * @return \ReflectionProperty
	 */
	protected function setProperty($object, string $property, $value):ReflectionProperty{
		$property = $this->getProperty($property);
		$property->setValue($object, $value);

		return $property;
	}

	/**
	 * @param string $prop
	 * @param string $path
	 */
	protected function setURL(string $prop, string $path){
		$this->setProperty($this->provider, $prop, self::HOST.self::BASE_PATH.$path);
	}

	/**
	 * @param \chillerlan\OAuth\Token $token
	 */
	protected function storeToken(Token $token){
		$this->storage->storeAccessToken($this->provider->serviceName, $token);
	}

	public function testInstance(){
		$this->assertInstanceOf(OAuthInterface::class, $this->provider);
	}

	public function testMagicGetServicename(){
		$this->assertSame($this->reflection->getShortName(), $this->provider->serviceName);
	}

	public function testGetUserRevokeURL(){
		$this->setProperty($this->provider, 'userRevokeURL', '/oauth/revoke');

		$this->assertSame('/oauth/revoke', $this->provider->getUserRevokeURL());
	}

	public function testGetStorageInterface(){
		$this->assertInstanceOf(TokenStorageInterface::class, $this->provider->getStorageInterface());
	}

	public function rawurlencodeDataProvider(){
		return [
			['some test string!', 'some%20test%20string%21'],
			[['some other', 'test string', ['oh wait!', 'this', ['is an', 'array!']]], ['some%20other', 'test%20string', ['oh%20wait%21', 'this', ['is%20an', 'array%21']]]],
		];
	}

	/**
	 * @dataProvider rawurlencodeDataProvider
	 */
	public function testRawurlencode($data, $expected){
		$m = $this->getMethod('rawurlencode');

		$this->assertSame($expected, $m->invokeArgs($this->provider, [$data]));
	}

	public function testBuildHttpQuery(){

		$data = ['foo' => 'bar', 'whatever?' => 'nope!'];

		$this->assertSame('', $this->provider->buildHttpQuery([]));
		$this->assertSame('foo=bar&whatever%3F=nope%21', $this->provider->buildHttpQuery($data));
		$this->assertSame('foo=bar&whatever?=nope!', $this->provider->buildHttpQuery($data, false));
		$this->assertSame('foo=bar, whatever?=nope!', $this->provider->buildHttpQuery($data, false, ', '));
		$this->assertSame('foo="bar", whatever?="nope!"', $this->provider->buildHttpQuery($data, false, ', ', '"'));

		$data['florps']  = ['nope', 'nope', 'nah'];
		$this->assertSame('florps="nah", florps="nope", florps="nope", foo="bar", whatever?="nope!"', $this->provider->buildHttpQuery($data, false, ', ', '"'));
	}

}
