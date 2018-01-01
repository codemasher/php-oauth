<?php
/**
 * Class SpotifyTest
 *
 * @filesource   SpotifyTest.php
 * @created      01.01.2018
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\Spotify;

/**
 * @property \chillerlan\OAuth\Providers\Spotify $provider
 */
class SpotifyTest extends OAuth2Test{
	use SupportsOAuth2ClientCredentials, SupportsOAuth2TokenRefresh;

	protected $FQCN = Spotify::class;

}
