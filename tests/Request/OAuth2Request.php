<?php
/**
 * Class OAuth2Request
 *
 * @filesource   OAuth2Request.php
 * @created      04.11.2017
 * @package      chillerlan\OAuthTest\Request
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Request;

use chillerlan\OAuth\{
	Token
};

/**
 * @property \chillerlan\OAuth\Providers\OAuth2Interface $provider
 */
class OAuth2Request extends RequestTestAbstract{

	const ROUTES =  [
		self::ROUTE_ACCESS_TOKEN,
		self::ROUTE_CC_TOKEN,
		self::ROUTE_REFRESH_TOKEN,
		self::ROUTE_API_REQUEST,
	];

	const ROUTE_ACCESS_TOKEN = ['POST', '/oauth2/access_token', [
		'headers' => [
			'Content-type: application/json'
		],
		'body'    => [
			'access_token' => 'test_access_token',
			'expires_in'   => 3600,
			'state'        => 'test_state',
		],
	]];

	const ROUTE_CC_TOKEN = ['POST', '/oauth2/client_credentials', [
		'headers' => [
			'Content-type: application/json'
		],
		'body'    => [
			'access_token' => 'test_client_credentials_token',
			'expires_in'   => 60,
			'state'        => 'test_state',
		],
	]];

	const ROUTE_REFRESH_TOKEN = ['POST', '/oauth2/refresh_token', [
		'headers' => [
			'Content-type: application/json'
		],
		'body'    => [
			'access_token' => 'test_refreshed_access_token',
			'expires_in'   => 60,
			'state'        => 'test_state',
		],
	]];

	const ROUTE_API_REQUEST = ['GET', '/oauth2/api/request', [
		'headers' => [
			'Content-type: application/json'
		],
		'body'    => [
			'data' => 'such data! much wow!',
		],
	]];

	protected $FQCN = TestOAuth2Provider::class;

	protected function setUp(){
		parent::setUp();

		$this->setProperty($this->provider, 'useCsrfToken', true);
		$this->storage->storeAuthorizationState($this->provider->serviceName, 'test_state');
	}

	public function testGetAccessToken(){
		$this->setURL('accessTokenURL', self::ROUTE_ACCESS_TOKEN[1]);

		$token = $this->provider->getAccessToken('foo', 'test_state');

		$this->assertSame('test_access_token', $token->accessToken);
		$this->assertGreaterThan(time(), $token->expires);
	}

	public function testGetClientCredentials(){
		$this->setProperty($this->provider, 'clientCredentials', true);
		$this->setURL('accessTokenURL', self::ROUTE_CC_TOKEN[1]);

		$token = $this->provider->getClientCredentialsToken();

		$this->assertSame('test_client_credentials_token', $token->accessToken);
		$this->assertGreaterThan(time(), $token->expires);
	}

	public function testRefreshAccessToken(){
		$this->setProperty($this->provider, 'accessTokenExpires', true);
		$this->setProperty($this->provider, 'accessTokenRefreshable', true);
		$this->setURL('accessTokenURL', self::ROUTE_REFRESH_TOKEN[1]);
		$this->storeToken(new Token(['expires' => 30, 'refreshToken' => 'test_refresh_token']));

		$token = $this->provider->refreshAccessToken();

		$this->assertSame('test_refresh_token', $token->refreshToken);
		$this->assertSame('test_refreshed_access_token', $token->accessToken);
		$this->assertGreaterThan(time(), $token->expires);
	}

	public function testRequestHeaderToken(){
		$this->setURL('apiURL', self::ROUTE_API_REQUEST[1]);
		$this->storeToken(new Token(['accessToken' => 'test_access_token_secret']));

		$response = $this->provider->request('');

		$this->assertSame('application/json', $response->headers->{'content-type'});
		$this->assertSame(self::ROUTE_API_REQUEST['2']['body']['data'], $response->json->data);
	}

	public function testRequestQueryToken(){
		$this->setURL('apiURL', self::ROUTE_API_REQUEST[1]);
		$this->storeToken(new Token(['accessToken' => 'test_access_token_secret']));
		$this->setProperty($this->provider, 'authMethod', 2); // query access token

		$response = $this->provider->request('');

		$this->assertSame('application/json', $response->headers->{'content-type'});
		$this->assertSame(self::ROUTE_API_REQUEST['2']['body']['data'], $response->json->data);
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage invalid auth type
	 */
	public function testRequestInvalidAuthType(){
		$this->setURL('apiURL', self::ROUTE_API_REQUEST[1]);
		$this->storeToken(new Token(['accessToken' => 'test_access_token_secret']));
		$this->setProperty($this->provider, 'authMethod', 'foo');

		$response = $this->provider->request('');

		$this->assertSame('application/json', $response->headers->{'content-type'});
		$this->assertSame(self::ROUTE_API_REQUEST['2']['body']['data'], $response->json->data);
	}

	public function testRequestWithTokenRefresh(){
		$this->setURL('apiURL', self::ROUTE_API_REQUEST[1]);
		$this->setURL('refreshTokenURL', self::ROUTE_REFRESH_TOKEN[1]);
		$this->storeToken(new Token(['accessToken' => 'test_access_token', 'refreshToken' => 'test_refresh_token', 'expires' => 1]));
		$this->setProperty($this->provider, 'accessTokenExpires', true);

		sleep(2);
		$response = $this->provider->request('');

		$this->assertSame('application/json', $response->headers->{'content-type'});
		$this->assertSame(self::ROUTE_API_REQUEST['2']['body']['data'], $response->json->data);
	}

}
