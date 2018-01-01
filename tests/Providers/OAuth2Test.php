<?php
/**
 * Class OAuth2Test
 *
 * @filesource   OAuth2Test.php
 * @created      03.11.2017
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\{
	HTTP\HTTPClientInterface, HTTP\HTTPClientAbstract, HTTP\OAuthResponse, Providers\OAuth2Interface, Token
};

/**
 * @property \chillerlan\OAuth\Providers\OAuth2Interface $provider
 */
abstract class OAuth2Test extends ProviderTestAbstract{

	const OAUTH2_RESPONSES = [
		'https://localhost/oauth2/access_token' => [
			'access_token' => 'test_access_token',
			'expires_in'   => 3600,
			'state'        => 'test_state',
		],
		'https://localhost/oauth2/refresh_token' =>  [
			'access_token' => 'test_refreshed_access_token',
			'expires_in'   => 60,
			'state'        => 'test_state',
		],
		'https://localhost/oauth2/client_credentials' => [
			'access_token' => 'test_client_credentials_token',
			'expires_in'   => 30,
			'state'        => 'test_state',
		],
		'https://localhost/oauth2/api/request' => [
			'data' => 'such data! much wow!'
		],
	];

	protected function setUp(){
		parent::setUp();

		$this->setProperty($this->provider, 'apiURL', 'https://localhost/oauth2/api/request');
		$this->setProperty($this->provider, 'accessTokenURL', 'https://localhost/oauth2/access_token');
		$this->setProperty($this->provider, 'refreshTokenURL', 'https://localhost/oauth2/refresh_token');
		$this->setProperty($this->provider, 'clientCredentialsTokenURL', 'https://localhost/oauth2/client_credentials');

		$this->storage->storeAuthorizationState($this->provider->serviceName, 'test_state');
	}

	protected function initHttp():HTTPClientInterface{
		return new class extends HTTPClientAbstract{
			public function request(string $url, array $params = null, string $method = null, $body = null, array $headers = null):OAuthResponse{
				return new OAuthResponse(['body' => json_encode(OAuth2Test::OAUTH2_RESPONSES[$url])]);
			}
		};
	}

	public function testMagicSupportsClientCredentials(){
		$this->assertFalse($this->provider->supportsClientCredentials);
	}

	public function testMagicTokenRefreshable(){
		$this->assertFalse($this->provider->tokenRefreshable);
	}

	public function testGetAuthURL(){
		$url = $this->provider->getAuthURL(['client_secret' => 'foo']);
		parse_str(parse_url($url, PHP_URL_QUERY), $query);

		$this->assertArrayNotHasKey('client_secret', $query);
		$this->assertSame($this->options->key, $query['client_id']);
		$this->assertSame('code', $query['response_type']);
	}

	public function testParseTokenResponse(){
		$token = $this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse(['body' => json_encode(['access_token' => 'whatever'])])]);

		$this->assertInstanceOf(Token::class, $token);
		$this->assertSame('whatever', $token->accessToken);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage unable to parse token response
	 */
	public function testParseTokenResponseNoData(){
		$this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse(['body' => ''])]);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage retrieving access token:
	 */
	public function testParseTokenResponseError(){
		$this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse(['body' => json_encode(['error' => 'whatever'])])]);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage token missing
	 */
	public function testParseTokenResponseNoToken(){
		$this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse(['body' => json_encode(['foo' => 'bar'])])]);
	}

	public function testCheckState(){
		$provider = $this
			->getMethod('checkState')
			->invokeArgs($this->provider, ['test_state']);

		$this->assertInstanceOf(OAuth2Interface::class, $provider);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage invalid state
	 */
	public function testCheckStateInvalid(){
		$this
			->getMethod('checkState')
			->invoke($this->provider);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage invalid authorization state
	 */
	public function testCheckStateInvalidAuth(){

		$this
			->getMethod('checkState')
			->invokeArgs($this->provider, ['invalid_test_state']);
	}

	public function testGetAccessTokenBody(){
		$body = $this->getMethod('getAccessTokenBody')->invokeArgs($this->provider, ['foo']);

		$this->assertSame('foo', $body['code']);
		$this->assertSame($this->options->key, $body['client_id']);
		$this->assertSame($this->options->secret, $body['client_secret']);
		$this->assertSame('authorization_code', $body['grant_type']);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage not supported
	 */
	public function testGetClientCredentialsTokenNotSupported(){
		$this->provider->getClientCredentialsToken();
	}

	public function testGetClientCredentialsTokenBody(){
		$this->setProperty($this->provider, 'scopesDelimiter', ',');

		$body = $this
			->getMethod('getClientCredentialsTokenBody')
			->invokeArgs($this->provider, [['scope1', 'scope2', 'scope3']]);

		$this->assertSame('scope1,scope2,scope3', $body['scope']);
		$this->assertSame('client_credentials', $body['grant_type']);
	}

	public function testGetClientCredentialsHeaders(){
		$headers = $this
			->getMethod('getClientCredentialsTokenHeaders')
			->invoke($this->provider);

		$this->assertSame('Basic dGVzdGtleTp0ZXN0c2VjcmV0', $headers['Authorization']);
	}

	public function testRefreshAccessTokenBody(){
		$body = $this
			->getMethod('refreshAccessTokenBody')
			->invokeArgs($this->provider, [new Token(['refreshToken' => 'whatever'])]);

		$this->assertSame('whatever', $body['refresh_token']);
		$this->assertSame($this->options->key, $body['client_id']);
		$this->assertSame($this->options->secret, $body['client_secret']);
		$this->assertSame('refresh_token', $body['grant_type']);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage Token is not refreshable
	 */
	public function testTokenRefreshNotRefreshable(){
		$this->provider->refreshAccessToken();
	}

	public function testGetAccessToken(){
		$token = $this->provider->getAccessToken('foo', 'test_state');

		$this->assertSame('test_access_token', $token->accessToken);
		$this->assertGreaterThan(time(), $token->expires);
	}

	public function testGetClientCredentials(){

		if(!$this->provider->supportsClientCredentials){
			$this->markTestSkipped('N/A');
		}

		$token = $this->provider->getClientCredentialsToken();

		$this->assertSame('test_client_credentials_token', $token->accessToken);
		$this->assertGreaterThan(time(), $token->expires);
	}

	public function testRefreshAccessToken(){

		if(!$this->provider->tokenRefreshable){
			$this->markTestSkipped('N/A');
		}

		$this->storeToken(new Token(['expires' => 1, 'refreshToken' => 'test_refresh_token']));

		$token = $this->provider->refreshAccessToken();

		$this->assertSame('test_refresh_token', $token->refreshToken);
		$this->assertSame('test_refreshed_access_token', $token->accessToken);
		$this->assertGreaterThan(time(), $token->expires);
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage no refresh token available, token expired [
	 */
	public function testRefreshAccessTokenNoRefreshTokenAvailable(){

		if(!$this->provider->tokenRefreshable){
			$this->markTestSkipped('N/A');
		}

		$this->storeToken(new Token(['expires' => 1, 'refreshToken' => null]));

		$token = $this->provider->refreshAccessToken();
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage invalid auth type
	 */
	public function testRequestInvalidAuthType(){
		$this->setProperty($this->provider, 'authMethod', 'foo');

		$this->storeToken(new Token(['accessToken' => 'test_access_token_secret', 'expires' => 1]));
		$this->provider->request('');
	}

	public function testRequest(){
		$this->storeToken(new Token(['accessToken' => 'test_access_token_secret', 'expires' => 1]));

		$response = $this->provider->request('');

		$this->assertSame('such data! much wow!', $response->json->data);
	}

	public function testRequestWithTokenRefresh(){

		if(!$this->provider->tokenRefreshable){
			$this->markTestSkipped('N/A');
		}

		$this->storeToken(new Token(['accessToken' => 'test_access_token', 'refreshToken' => 'test_refresh_token', 'expires' => 1]));

		sleep(2);

		$this->assertSame('such data! much wow!', $this->provider->request('')->json->data);
	}

}
