<?php
/**
 * Class OAuth1Test
 *
 * @filesource   OAuth1Test.php
 * @created      03.11.2017
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\{HTTP\OAuthResponse, Token};

/**
 * @property \chillerlan\OAuth\Providers\OAuth1Interface $provider
 */
abstract class OAuth1Test extends ProviderTestAbstract{

	public function testParseTokenResponse(){
		$token = $this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse(['body' => 'oauth_token=whatever&oauth_token_secret=whatever_secret&oauth_callback_confirmed=true'])]);

		$this->assertInstanceOf(Token::class, $token);
		$this->assertSame('whatever', $token->accessToken);
		$this->assertSame('whatever_secret', $token->accessTokenSecret);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage oauth callback unconfirmed
	 */
	public function testParseTokenResponseCallbackUnconfirmed(){
		$this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse(['body' => 'oauth_token=whatever&oauth_token_secret=whatever_secret']), true]);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage unable to parse token response
	 */
	public function testParseTokenResponseNoData(){
		$this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse]);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage error retrieving access token
	 */
	public function testParseTokenResponseError(){
		$this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse(['body' => 'error=whatever'])]);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage token missing
	 */
	public function testParseTokenResponseNoToken(){
		$this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse(['body' => 'oauth_token=whatever'])]);
	}

	public function testGetRequestTokenHeaderParams(){
		$this->setURL('requestTokenURL', '/oauth1/request_token');

		$params = $this
			->getMethod('getRequestTokenHeaderParams')
			->invoke($this->provider);

		$this->assertSame(self::HOST.self::BASE_PATH.'/callback', $params['oauth_callback']);
		$this->assertSame($this->options->key, $params['oauth_consumer_key']);
		$this->assertRegExp('/^([a-f\d]{64})$/', $params['oauth_nonce']);
	}

	public function testRequestHeaders(){
		$headers = $this
			->getMethod('requestHeaders')
			->invokeArgs($this->provider, ['http://localhost/api/whatever', ['oauth_session_handle' => 'nope'], 'GET', [], new Token(['accessTokenSecret' => 'test_token_secret', 'accessToken' => 'test_token'])]);

		$this->assertContains('OAuth oauth_consumer_key="'.$this->options->key.'", oauth_nonce="', $headers['Authorization']);
	}

	public function testGetAccessTokenHeaders(){
		$this->setURL('accessTokenURL', '/oauth1/request_token');

		$headers = $this
			->getMethod('getAccessTokenHeaders')
			->invokeArgs($this->provider, [['foo' => 'bar']]);

		$this->assertContains('OAuth oauth_consumer_key="'.$this->options->key.'", oauth_nonce="', $headers['Authorization']);
	}

	public function testGetSignatureData(){
		$signature = $this
			->getMethod('getSignatureData')
			->invokeArgs($this->provider, ['http://localhost/api/whatever', ['foo' => 'bar', 'oauth_signature' => 'should not see me!'], 'GET']);

		$this->assertSame('GET&http%3A%2F%2Flocalhost%2Fapi%2Fwhatever&foo%3Dbar', $signature);
	}

	public function testGetSignature(){
		$signature = $this
			->getMethod('getSignature')
			->invokeArgs($this->provider, ['http://localhost/api/whatever', ['foo' => 'bar', 'oauth_signature' => 'should not see me!'], 'GET']);

		$this->assertSame('ygg22quLhpyegiyr7yl4hLAP9S8=', $signature);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage getSignature: invalid url
	 */
	public function testGetSignatureInvalidURLException(){
		$this
			->getMethod('getSignature')
			->invokeArgs($this->provider, ['whatever', [], 'GET']);
	}

}
