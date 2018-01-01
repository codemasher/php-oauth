<?php
/**
 * Class VimeoTest
 *
 * @filesource   VimeoTest.php
 * @created      01.01.2018
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\Vimeo;

/**
 * @property \chillerlan\OAuth\Providers\Vimeo $provider
 */
class VimeoTest extends OAuth2Test{
	use SupportsOAuth2ClientCredentials;

	protected $FQCN = Vimeo::class;

}
