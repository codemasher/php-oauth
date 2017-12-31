<?php
/**
 * Class Twitter2APITest
 *
 * @filesource   Twitter2APITest.php
 * @created      26.10.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\Twitter2;

/**
 * @property \chillerlan\OAuth\Providers\Twitter2 $provider
 */
class Twitter2APITest extends APITestAbstract{

	protected $providerClass = Twitter2::class;
	protected $envvar        = 'TWITTER';

}
