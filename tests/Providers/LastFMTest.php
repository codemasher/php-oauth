<?php
/**
 * Class LastFMTest
 *
 * @filesource   LastFMTest.php
 * @created      05.11.2017
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\{
	HTTP\OAuthResponse, Providers\LastFM
};

/**
 * @property \chillerlan\OAuth\Providers\LastFM $provider
 */
class LastFMTest extends ProviderTestAbstract{

	protected $FQCN = LastFM::class;

	public function testGetAuthURL(){
		$url = $this->provider->getAuthURL(['foo' => 'bar']);

		$this->assertSame('https://www.last.fm/api/auth?api_key='.$this->options->key.'&foo=bar', $url);
	}

	public function testGetSignature(){
		$signature = $this
			->getMethod('getSignature')
			->invokeArgs($this->provider, [['foo' => 'bar', 'format' => 'whatever', 'callback' => 'nope']]);

		$this->assertSame('cb143650fa678449f5492a2aa6fab216', $signature);
	}

	public function testParseTokenResponse(){
		$token = $this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse(['body' => json_encode(['session' => ['key' => 'whatever']])])]);

		$this->assertSame('whatever', $token->accessToken);
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage unable to parse token response
	 */
	public function testParseTokenResponseNoData(){
		$this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse]);
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage error retrieving access token:
	 */
	public function testParseTokenResponseError(){
		$this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse(['body' => json_encode(['error' => 42, 'message' => 'whatever'])])]);
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage token missing
	 */
	public function testParseTokenResponseNoToken(){
		$this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new OAuthResponse(['body' => json_encode(['session' => []])])]);
	}

	public function testGetAccessTokenParams(){
		$params = $this
			->getMethod('getAccessTokenParams')
			->invokeArgs($this->provider, ['foo']);

		$this->assertSame('foo', $params['token']);
		$this->assertSame($this->options->key, $params['api_key']);
	}

	public function testRequestParams(){
		$params = $this
			->getMethod('requestParams')
			->invokeArgs($this->provider, ['whatever', ['foo' => 'bar'], []]);

		$this->assertSame('310be19b3ff6967ca8425666753019fb', $params['api_sig']);
		$this->assertSame($this->options->key, $params['api_key']);
		$this->assertSame('whatever', $params['method']);
		$this->assertSame('bar', $params['foo']);
	}

}
