<?php
/**
 * Class TwitchTest
 *
 * @filesource   TwitchTest.php
 * @created      01.01.2018
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\Twitch;

/**
 * @property \chillerlan\OAuth\Providers\BigCartel $provider
 */
class TwitchTest extends OAuth2Test{
	use SupportsOAuth2ClientCredentials, SupportsOAuth2TokenRefresh;

	protected $FQCN = Twitch::class;

	public function testGetClientCredentialsHeaders(){
		$headers = $this
			->getMethod('getClientCredentialsTokenHeaders')
			->invoke($this->provider);

		$this->assertSame('application/vnd.twitchtv.v5+json', $headers['Accept']);
	}

}
