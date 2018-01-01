<?php
/**
 * Class SoundcloudAPITest
 *
 * @filesource   SoundcloudAPITest.php
 * @created      16.07.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\SoundCloud;

/**
 * @property  \chillerlan\OAuth\Providers\SoundCloud $provider
 */
class SoundcloudAPITest extends APITestAbstract{

	const USERNAME = '<SOUNDCLOUD_USERNAME>'; // @todo: change this to your username
	const USER_ID  = '<SOUNDCLOUD_USER_ID>';

	protected $FQCN   = SoundCloud::class;
	protected $envvar = 'SOUNDCLOUD';

	public function testGetUserInfo(){
		$this->assertSame(self::USERNAME, $this->provider->user(self::USER_ID)->json->username);
	}

}
