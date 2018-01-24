<?php
/**
 * Class AmazonTest
 *
 * @filesource   AmazonTest.php
 * @created      31.12.2017
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\Amazon;

/**
 * @property \chillerlan\OAuth\Providers\Amazon $provider
 */
abstract class AmazonTest extends OAuth2Test{
	use SupportsOAuth2TokenRefresh;

	protected $FQCN = Amazon::class;

}
