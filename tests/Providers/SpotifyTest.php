<?php
/**
 * Class SpotifyTest
 *
 * @filesource   SpotifyTest.php
 * @created      01.01.2018
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\Spotify;

/**
 * @property \chillerlan\OAuth\Providers\Spotify $provider
 */
class SpotifyTest extends OAuth2Test{

	protected $FQCN = Spotify::class;

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
