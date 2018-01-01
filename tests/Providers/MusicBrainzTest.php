<?php
/**
 * Class MusicBrainzTest
 *
 * @filesource   MusicBrainzTest.php
 * @created      01.01.2018
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\MusicBrainz;

/**
 * @property \chillerlan\OAuth\Providers\MusicBrainz $provider
 */
class MusicBrainzTest extends OAuth2Test{
	use SupportsOAuth2TokenRefresh;

	protected $FQCN = MusicBrainz::class;

	public function testRequestInvalidAuthType(){
		$this->markTestSkipped('N/A');
	}

}
