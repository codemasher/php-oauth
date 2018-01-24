<?php
/**
 * Class APITestAbstract
 *
 * @filesource   APITestAbstract.php
 * @created      10.07.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\Database\{
	Connection, Drivers\Native\MySQLiDriver, Options, Query\Dialects\MySQLQueryBuilder
};
use chillerlan\OAuth\{
	OAuthOptions, Providers\OAuth2Interface, Providers\OAuthInterface, Storage\DBTokenStorage, Storage\TokenStorageInterface, Token
};
use chillerlan\HTTP\{
	CurlClient, GuzzleClient, HTTPClientAbstract, HTTPClientInterface, HTTPResponse, HTTPResponseInterface, StreamClient, TinyCurlClient
};
use chillerlan\TinyCurl\{
	Request, RequestOptions
};
use chillerlan\Traits\ContainerInterface;
use chillerlan\Traits\DotEnv;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

abstract class APITestAbstract extends TestCase{

	const CFGDIR        = __DIR__.'/../../config';
	const STORAGE       = __DIR__.'/../../tokenstorage';
	const UA            = 'chillerlanPhpOAuth/2.0.0 +https://github.com/chillerlan/php-oauth';
	const SLEEP_SECONDS = 1.0;
	const TABLE_TOKEN    = 'storagetest';
	const TABLE_PROVIDER = 'storagetest_providers';

	/**
	 * @var \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	protected $storage;

	/**
	 * @var \chillerlan\OAuth\Providers\OAuthInterface
	 */
	protected $provider;

	/**
	 * @var \chillerlan\HTTP\HTTPResponseInterface
	 */
	protected $response;

	/**
	 * @var \chillerlan\HTTP\HTTPClientInterface
	 */
	protected $http;

	/**
	 * @var string
	 */
	protected $FQCN;

	/**
	 * @var \chillerlan\Traits\DotEnv
	 */
	protected $env;

	/**
	 * @var \chillerlan\OAuth\OAuthOptions
	 */
	protected $options;

	/**
	 * @var string
	 */
	protected $envvar;

	/**
	 * @var array
	 */
	protected $scopes = [];

	protected function setUp(){
		ini_set('date.timezone', 'Europe/Amsterdam');

		$this->env = (new DotEnv(self::CFGDIR, file_exists(self::CFGDIR.'/.env') ? '.env' : '.env_travis'))->load();

		$this->options = new OAuthOptions([
			'key'              => $this->env->get($this->envvar.'_KEY'),
			'secret'           => $this->env->get($this->envvar.'_SECRET'),
			'callbackURL'      => $this->env->get($this->envvar.'_CALLBACK_URL'),
			'dbTokenTable'     => self::TABLE_TOKEN,
			'dbProviderTable'  => self::TABLE_PROVIDER,
			'storageCryptoKey' => '000102030405060708090a0b0c0d0e0f101112131415161718191a1b1c1d1e1f',
			'dbUserID'         => 1,
		]);

		$this->storage  = $this->initStorage();
		$this->http     = $this->initHTTP('tinycurl');
		$this->provider = $this->initProvider();

		$this->storage->storeAccessToken($this->provider->serviceName, $this->getToken());
	}

	protected function tearDown(){
		if($this->response instanceof HTTPResponse){

			$json = $this->response->json;

			!empty($json)
				? print_r($json)
				: print_r($this->response->body);
		}
	}

	protected function initProvider():OAuthInterface{
		return  new $this->FQCN(
			$this->http,
			$this->storage,
			$this->options,
			$this->scopes
		);
	}

	protected function initHTTP($client):HTTPClientInterface{
		return new class($client, $this->options) extends HTTPClientAbstract{
			protected $client;

			public function __construct(ContainerInterface $options, string $client = null){
				parent::__construct($options);
				$this->client = call_user_func([$this, $client]);
			}

			public function request(string $url, array $params = null, string $method = null, $body = null, array $headers = null):HTTPResponseInterface{
				$args = func_get_args();
#	        	print_r($args);
				$response = $this->client->request(...$args);
#	        	print_r($response);
				usleep(APITestAbstract::SLEEP_SECONDS * 1000000);
				return $response;
			}

			protected function guzzle(){
				return new GuzzleClient($this->options, new Client(['cacert' => $this->options->ca_info, 'headers' => ['User-Agent' => $this->options->userAgent]]));
			}

			protected function tinycurl(){
				return new TinyCurlClient($this->options, new Request(new RequestOptions(['ca_info' =>  $this->options->ca_info, 'userAgent' => $this->options->userAgent])));
			}

			protected function curl(){
				return new CurlClient($this->options);
			}

			protected function stream(){
				return new StreamClient($this->options);
			}

		};
	}

	protected function initStorage():TokenStorageInterface{
		$db = new Connection(new Options([
			'driver'       => MySQLiDriver::class,
			'querybuilder' => MySQLQueryBuilder::class,
			'host'         => $this->env->get('MYSQL_HOST'),
			'port'         => $this->env->get('MYSQL_PORT'),
			'database'     => $this->env->get('MYSQL_DATABASE'),
			'username'     => $this->env->get('MYSQL_USERNAME'),
			'password'     => $this->env->get('MYSQL_PASSWORD'),
		]));

		return new DBTokenStorage($this->options, $db);
	}

	protected function getToken():Token{
		$file = self::STORAGE.'/'.$this->provider->serviceName.'.token';

		if(is_file($file)){
			return unserialize(file_get_contents($file));
		}

		return new Token(['accessToken' => '']);
	}

	public function testInstance(){
		$this->assertInstanceOf(OAuthInterface::class, $this->provider);
		$this->assertInstanceOf($this->FQCN, $this->provider);
	}

	public function testRequestCredentialsToken(){

		if(!$this->provider instanceof OAuth2Interface){
			$this->markTestSkipped('OAuth2 only');
		}

		if(!$this->provider->supportsClientCredentials){
			$this->markTestSkipped('not supported');
		}

		$token = $this->provider->getClientCredentialsToken();

		$this->assertInstanceOf(Token::class, $token);
		$this->assertInternalType('string', $token->accessToken);

		if($token->expires !== Token::EOL_NEVER_EXPIRES){
			$this->assertGreaterThan(time(), $token->expires);
		}

		print_r($token);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage not supported
	 */
	public function testRequestCredentialsTokenNotSupportedException(){

		if(!$this->provider instanceof OAuth2Interface){
			$this->markTestSkipped('OAuth2 only');
		}

		if($this->provider->supportsClientCredentials){
			$this->markTestSkipped('does not apply');
		}

		$this->provider->getClientCredentialsToken();
	}

}
