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

use chillerlan\Database\Connection;
use chillerlan\Database\Drivers\PDO\PDOMySQLDriver;
use chillerlan\Database\Options as DBOptions;
use chillerlan\Database\Query\Dialects\MySQLQueryBuilder;
use chillerlan\OAuth\HTTP\CurlClient;
use chillerlan\OAuth\HTTP\GuzzleClient;
use chillerlan\OAuth\HTTP\StreamClient;
use chillerlan\OAuth\HTTP\TinyCurlClient;
use chillerlan\OAuth\OAuthOptions;
use chillerlan\OAuth\Providers\OAuth2Interface;
use chillerlan\OAuth\Providers\OAuthInterface;
use chillerlan\OAuth\Storage\DBTokenStorage;
use chillerlan\OAuth\Token;
use chillerlan\OAuthTest\Storage\DBTest;
use chillerlan\TinyCurl\Request;
use chillerlan\TinyCurl\RequestOptions;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

abstract class APITestAbstract extends TestCase{

	const CFGDIR  = __DIR__.'/../../config';
	const STORAGE = __DIR__.'/../../tokenstorage';
	const UA = 'chillerlanPhpOAuth/1.2.0 +https://github.com/codemasher/php-oauth';

	/**
	 * @var \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	protected $storage;

	/**
	 * @var \chillerlan\OAuth\Providers\OAuthInterface
	 */
	protected $provider;

	protected $providerClass;
	protected $envvar;
	protected $scopes = [];

	protected function setUp(){
		ini_set('date.timezone', 'Europe/Amsterdam');

		$env = file_exists(self::CFGDIR.'/.env') ? '.env' : '.env_travis';

		(new Dotenv(self::CFGDIR, $env))->load();

		$db = new Connection(new DBOptions([
			'driver'       => PDOMySQLDriver::class,
			'querybuilder' => MySQLQueryBuilder::class,
			'host'         => getenv('MYSQL_HOST'),
			'port'         => getenv('MYSQL_PORT'),
			'database'     => getenv('MYSQL_DATABASE'),
			'username'     => getenv('MYSQL_USERNAME'),
			'password'     => getenv('MYSQL_PASSWORD'),
		]));

		$this->storage  = new DBTokenStorage($db, DBTest::TABLE_TOKEN, DBTest::TABLE_PROVIDER, 1);

		$http = new GuzzleClient(new Client(['cacert' => self::CFGDIR.'/cacert.pem', 'headers' => ['User-Agent' => self::UA]]));
#		$http = new TinyCurlClient(new Request(new RequestOptions(['ca_info' => self::CFGDIR.'/cacert.pem', 'userAgent' => self::UA])));
#		$http = new CurlClient([CURLOPT_CAINFO => self::CFGDIR.'/cacert.pem', CURLOPT_USERAGENT => self::UA]);
#		$http = new StreamClient(self::CFGDIR.'/cacert.pem', self::UA);

		$this->provider = new $this->providerClass(
			$http,
			$this->storage,
			new OAuthOptions([
				'key'         => getenv($this->envvar.'_KEY'),
				'secret'      => getenv($this->envvar.'_SECRET'),
				'callbackURL' => getenv($this->envvar.'_CALLBACK_URL'),
			]),
			$this->scopes
		);

		$this->storage->storeAccessToken($this->provider->serviceName, $this->getToken());
	}

	protected function getToken():Token{
		$f = self::STORAGE.'/'.$this->provider->serviceName.'.token';

		if(is_file($f)){
			return unserialize(file_get_contents($f));
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
	 * @expectedException \chillerlan\OAuth\OAuthException
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
