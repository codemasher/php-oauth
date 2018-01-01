<?php
/**
 * Class DeviantArtAPITest
 *
 * @filesource   DeviantArtAPITest.php
 * @created      27.10.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\DeviantArt;

class DeviantArtAPITest extends APITestAbstract{

	protected $providerClass = DeviantArt::class;
	protected $envvar        = 'DEVIANTART';

}