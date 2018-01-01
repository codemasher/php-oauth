<?php
/**
 * Class DeviantArtTest
 *
 * @filesource   DeviantArtTest.php
 * @created      01.01.2018
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\DeviantArt;

/**
 * @property \chillerlan\OAuth\Providers\DeviantArt $provider
 */
class DeviantArtTest extends OAuth2Test{
	use SupportsOAuth2ClientCredentials, SupportsOAuth2TokenRefresh;

	protected $FQCN = DeviantArt::class;

}
