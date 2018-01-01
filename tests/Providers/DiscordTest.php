<?php
/**
 * Class DiscordTest
 *
 * @filesource   DiscordTest.php
 * @created      01.01.2018
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\Discord;

/**
 * @property \chillerlan\OAuth\Providers\Discord $provider
 */
class DiscordTest extends OAuth2Test{

	protected $FQCN = Discord::class;

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

}
