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
	use SupportsOAuth2TokenRefresh;

	protected $FQCN = YahooSocial::class;

}
