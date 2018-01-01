<?php
/**
 * Class DiscordTest
 *
 * @filesource   DiscordTest.php
 * @created      01.01.2018
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\Discord;

/**
 * @property \chillerlan\OAuth\Providers\Discord $provider
 */
class DiscordTest extends OAuth2Test{
	use SupportsOAuth2ClientCredentials, SupportsOAuth2TokenRefresh;

	protected $FQCN = Discord::class;

}
