<?php
/**
 * Class StripeAPITest
 *
 * @filesource   StripeAPITest.php
 * @created      01.01.2018
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\Stripe;

/**
 */
class StripeAPITest extends APITestAbstract{

	protected $providerClass = Stripe::class;
	protected $envvar        = 'STRIPE';

}
