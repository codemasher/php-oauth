<?php
/**
 * Class DeezerTest
 *
 * @filesource   DeezerTest.php
 * @created      31.12.2017
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\{
	OAuthOptions, Providers\Deezer, Token
};
use chillerlan\HTTP\{
	HTTPClientAbstract, HTTPClientInterface, HTTPResponse, HTTPResponseInterface
};

/**
 * @property \chillerlan\OAuth\Providers\Deezer $provider
 */
class DeezerTest extends OAuth2Test{

	protected $FQCN = Deezer::class;

	protected function initHttp():HTTPClientInterface{
		return new class(new OAuthOptions) extends HTTPClientAbstract{
			public function request(string $url, array $params = null, string $method = null, $body = null, array $headers = null):HTTPResponseInterface{
				$body = OAuth2Test::OAUTH2_RESPONSES[$url];
				return new HTTPResponse([
					'body' => $url === 'https://localhost/oauth2/api/request' ? json_encode($body) : http_build_query($body)
				]);
			}
		};
	}

	public function testGetAuthURL(){
		$this->setProperty($this->provider, 'scopes', [Deezer::SCOPE_BASIC, Deezer::SCOPE_EMAIL]);

		$this->assertContains('https://connect.deezer.com/oauth/auth.php?app_id='.$this->options->key.'&foo=bar&perms=basic_access%20email&redirect_uri=https%3A%2F%2Flocalhost%2Fcallback&state=', $this->provider->getAuthURL(['foo' => 'bar']));
	}

	public function testParseTokenResponse(){
		$token = $this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new HTTPResponse(['body' => http_build_query(['access_token' => 'whatever'])])]);

		$this->assertInstanceOf(Token::class, $token);
		$this->assertSame('whatever', $token->accessToken);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage retrieving access token:
	 */
	public function testParseTokenResponseError(){
		$this
			->getMethod('parseTokenResponse')
			->invokeArgs($this->provider, [new HTTPResponse(['body' => http_build_query(['error_reason' => 'whatever'])])]);
	}

	public function testGetAccessTokenBody(){
		$body = $this->getMethod('getAccessTokenBody')->invokeArgs($this->provider, ['foo']);

		$this->assertSame('foo', $body['code']);
		$this->assertSame($this->options->key, $body['app_id']);
		$this->assertSame($this->options->secret, $body['secret']);
		$this->assertSame('json', $body['output']);
	}

	public function testGetAccessToken(){
		$token = $this->provider->getAccessToken('foo', 'test_state');

		$this->assertSame('test_access_token', $token->accessToken);
		$this->assertSame(Token::EOL_NEVER_EXPIRES, $token->expires);
	}

}
