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
	HTTP\OAuthResponse, Providers\OAuth2Interface, Token
};

/**
 * @property \chillerlan\OAuth\Providers\OAuth2Interface $provider
 */
class OAuth2Test extends ProviderTestAbstract{

	protected $FQCN = TestOAuth2Provider::class;

	public function testMagicSupportsClientCredentials(){
		$this->assertFalse($this->provider->supportsClientCredentials);
	}

	public function testGetAuthURL(){
		$url = $this->provider->getAuthURL(['client_secret' => 'foo']);
		parse_str(parse_url($url, PHP_URL_QUERY), $query);

		$this->assertArrayNotHasKey('client_secret', $query);
		$this->assertSame('testkey', $query['client_id']);
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
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage unable to parse token response
	 */
	public function testParseTokenResponseNoData(){
		$this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse(['body' => ''])]);
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage retrieving access token:
	 */
	public function testParseTokenResponseError(){
		$this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse(['body' => json_encode(['error' => 'whatever'])])]);
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage token missing
	 */
	public function testParseTokenResponseNoToken(){
		$this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse(['body' => json_encode(['foo' => 'bar'])])]);
	}

	public function testCheckState(){
		$this->storage->storeAuthorizationState($this->provider->serviceName, 'test_state');

		$provider = $this
			->getMethod('checkState')
			->invokeArgs($this->provider, ['test_state']);

		$this->assertInstanceOf(OAuth2Interface::class, $provider);
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage invalid state
	 */
	public function testCheckStateInvalid(){
		$this
			->getMethod('checkState')
			->invoke($this->provider);
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage invalid state for
	 */
	public function testCheckStateInvalidForService(){
		$this
			->getMethod('checkState')
			->invokeArgs($this->provider, ['some_test_state']);
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage invalid authorization state
	 */
	public function testCheckStateInvalidAuth(){
		$this->storage->storeAuthorizationState($this->provider->serviceName, 'test_state');

		$this
			->getMethod('checkState')
			->invokeArgs($this->provider, ['invalid_test_state']);
	}

	public function testGetAccessTokenBody(){
		$body = $this->getMethod('getAccessTokenBody')->invokeArgs($this->provider, ['foo']);

		$this->assertSame('foo', $body['code']);
		$this->assertSame('testkey', $body['client_id']);
		$this->assertSame('testsecret', $body['client_secret']);
		$this->assertSame('authorization_code', $body['grant_type']);
	}


	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
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
		$this->assertSame('testkey', $body['client_id']);
		$this->assertSame('testsecret', $body['client_secret']);
		$this->assertSame('refresh_token', $body['grant_type']);
	}

}
