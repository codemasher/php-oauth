<?php
/**
 * Class YahooSocialTest
 *
 * @filesource   YahooSocialTest.php
 * @created      01.01.2018
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\YahooSocial;

/**
 * @property \chillerlan\OAuth\Providers\YahooSocial $provider
 */
class YahooSocialTest extends OAuth2Test{

	protected $FQCN = YahooSocial::class;

	public function testMagicTokenRefreshable(){
		$this->assertTrue($this->provider->tokenRefreshable);
	}

	public function testTokenRefreshNotRefreshable(){
		$this->markTestSkipped('N/A');
	}

}
