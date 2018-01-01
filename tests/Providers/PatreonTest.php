<?php
/**
 * Class PatreonTest
 *
 * @filesource   PatreonTest.php
 * @created      01.01.2018
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\Patreon;

/**
 * @property \chillerlan\OAuth\Providers\Patreon $provider
 */
class PatreonTest extends OAuth2Test{

	protected $FQCN = Patreon::class;

	public function testMagicTokenRefreshable(){
		$this->assertTrue($this->provider->tokenRefreshable);
	}

	public function testTokenRefreshNotRefreshable(){
		$this->markTestSkipped('N/A');
	}

}
