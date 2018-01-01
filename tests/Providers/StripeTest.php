<?php
/**
 * Class StripeTest
 *
 * @filesource   StripeTest.php
 * @created      01.01.2018
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\Stripe;

/**
 * @property \chillerlan\OAuth\Providers\Stripe $provider
 */
class StripeTest extends OAuth2Test{

	protected $FQCN = Stripe::class;

	public function testMagicTokenRefreshable(){
		$this->assertTrue($this->provider->tokenRefreshable);
	}

	public function testTokenRefreshNotRefreshable(){
		$this->markTestSkipped('N/A');
	}

}
