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

use chillerlan\OAuth\{
	HTTP\HTTPClientAbstract, HTTP\OAuthResponse, HTTP\TinyCurlClient, OAuthOptions, Providers\OAuth2Interface, Providers\OAuthInterface, Token
};
use chillerlan\TinyCurl\Request;
use chillerlan\TinyCurl\RequestOptions;
use chillerlan\Traits\DotEnv;
use PHPUnit\Framework\TestCase;

abstract class APITestAbstract extends TestCase{

	const CFGDIR        = __DIR__.'/../../config';
	const STORAGE       = __DIR__.'/../../tokenstorage';
	const UA            = 'chillerlanPhpOAuth/2.0.0 +https://github.com/codemasher/php-oauth';
	const SLEEP_SECONDS = 1.0;

	/**
	 * @var \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	protected $storage;

	/**
	 * @var \chillerlan\OAuth\Providers\OAuthInterface
	 */
	protected $provider;

	/**
	 * @var \chillerlan\OAuth\HTTP\OAuthResponse
	 */
	protected $response;

	protected $providerClass;
	protected $envvar;
	protected $scopes = [];
	protected $httpclient;

	protected function setUp(){
		ini_set('date.timezone', 'Europe/Amsterdam');

		$env = (new DotEnv(self::CFGDIR, file_exists(self::CFGDIR.'/.env') ? '.env' : '.env_travis'))->load();

		$this->storage  = new TestDBStorage;

		$this->httpclient = new class extends HTTPClientAbstract{
			protected $http;

			public function __construct(){
#				$this->http = new GuzzleClient(new Client(['cacert' => APITestAbstract::CFGDIR.'/cacert.pem', 'headers' => ['User-Agent' => APITestAbstract::UA]]));
				$this->http = new TinyCurlClient(new Request(new RequestOptions(['ca_info' => APITestAbstract::CFGDIR.'/cacert.pem', 'userAgent' => APITestAbstract::UA])));
#	        	$this->http = new CurlClient([CURLOPT_CAINFO => self::CFGDIR.'/cacert.pem', CURLOPT_USERAGENT => self::UA]);
#	        	$this->http = new StreamClient(self::CFGDIR.'/cacert.pem', self::UA);
			}

			public function request(string $url, array $params = null, string $method = null, $body = null, array $headers = null):OAuthResponse{
				$args = func_get_args();
#	        	print_r($args);
				$response = $this->http->request(...$args);
#	        	print_r($response);
				usleep(APITestAbstract::SLEEP_SECONDS * 1000000);
				return $response;
			}
		};

		$this->provider = new $this->providerClass(
			$this->httpclient,
			$this->storage,
			new OAuthOptions([
				'key'         => $env->get($this->envvar.'_KEY'),
				'secret'      => $env->get($this->envvar.'_SECRET'),
				'callbackURL' => $env->get($this->envvar.'_CALLBACK_URL'),
			]),
			$this->scopes
		);

		$this->storage->storeAccessToken($this->provider->serviceName, $this->getToken());
	}

	protected function tearDown(){
		if($this->response instanceof OAuthResponse){

			$json = $this->response->json;

			!empty($json)
				? print_r($json)
				: print_r($this->response->body);
		}
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
		$this->assertInstanceOf($this->providerClass, $this->provider);
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
