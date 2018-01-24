<?php
/**
 * Class GuildWars2Test
 *
 * @filesource   GuildWars2Test.php
 * @created      01.01.2018
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\OAuthOptions;
use chillerlan\OAuth\Providers\GuildWars2;
use chillerlan\HTTP\{
	HTTPClientAbstract, HTTPClientInterface, HTTPResponse, HTTPResponseInterface
};

/**
 * @property \chillerlan\OAuth\Providers\GuildWars2 $provider
 */
class GuildWars2Test extends OAuth2Test{

	const GW2_RESPONSES = [
		'https://localhost/oauth2/api/request' => [
			'data' => 'such data! much wow!'
		],
		'https://localhost/lastfm/auth/tokeninfo' => [
			'id' => '00000000-1111-2222-3333-444444444444',
			'name' => 'GW2Token',
			'permissions' => ['foo', 'bar'],
		],
	];

	protected $FQCN = GuildWars2::class;

	protected function initHttp():HTTPClientInterface{
		return new class(new OAuthOptions) extends HTTPClientAbstract{
			public function request(string $url, array $params = null, string $method = null, $body = null, array $headers = null):HTTPResponseInterface{
				return new HTTPResponse(['body' => json_encode(GuildWars2Test::GW2_RESPONSES[$url])]);
			}
		};
	}

	public function testStoreGW2Token(){
		$this->setProperty($this->provider, 'apiURL', 'https://localhost/lastfm/auth');

		$id     = '00000000-1111-2222-3333-444444444444';
		$secret = '55555555-6666-7777-8888-999999999999';

		$token = $this->provider->storeGW2Token($id.$secret);

		$this->assertSame($id.$secret, $token->accessToken);
		$this->assertSame($secret, $token->accessTokenSecret);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Providers\ProviderException
	 * @expectedExceptionMessage invalid token
	 */
	public function testStoreGW2TokenInvalidToken(){
		$token = $this->provider->storeGW2Token('foo');
	}

	public function testGetAuthURL(){$this->markTestSkipped('GuildWars2: N/A');}
	public function testGetUserRevokeURL(){$this->markTestSkipped('GuildWars2: N/A');}
	public function testParseTokenResponse(){$this->markTestSkipped('GuildWars2: N/A');}
	public function testParseTokenResponseNoData(){$this->markTestSkipped('GuildWars2: N/A');}
	public function testParseTokenResponseError(){$this->markTestSkipped('GuildWars2: N/A');}
	public function testParseTokenResponseNoToken(){$this->markTestSkipped('GuildWars2: N/A');}
	public function testCheckState(){$this->markTestSkipped('GuildWars2: N/A');}
	public function testCheckStateInvalid(){$this->markTestSkipped('GuildWars2: N/A');}
	public function testCheckStateInvalidAuth(){$this->markTestSkipped('GuildWars2: N/A');}
	public function testGetAccessToken(){$this->markTestSkipped('GuildWars2: N/A');}
	public function testGetAccessTokenBody(){$this->markTestSkipped('GuildWars2: N/A');}
	public function testRequestInvalidAuthType(){$this->markTestSkipped('GuildWars2: N/A');}

}
