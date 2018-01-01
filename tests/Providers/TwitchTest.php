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

	protected $FQCN = Twitch::class;

	public function testMagicSupportsClientCredentials(){
		$this->assertTrue($this->provider->supportsClientCredentials);
	}

	public function testGetClientCredentialsTokenNotSupported(){
		$this->markTestSkipped('N/A');
	}

	public function testMagicTokenRefreshable(){
		$this->assertTrue($this->provider->tokenRefreshable);
	}

	public function testTokenRefreshNotRefreshable(){
		$this->markTestSkipped('N/A');
	}

	public function testGetClientCredentialsHeaders(){
		$headers = $this
			->getMethod('getClientCredentialsTokenHeaders')
			->invoke($this->provider);

		$this->assertSame('application/vnd.twitchtv.v5+json', $headers['Accept']);
	}


}
