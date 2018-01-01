<?php
/**
 * Class VimeoTest
 *
 * @filesource   VimeoTest.php
 * @created      15.07.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\Vimeo;

/**
 * @property  \chillerlan\OAuth\Providers\Vimeo $provider
 */
class VimeoAPITest extends APITestAbstract{

	const USERNAME = '<VIMEO_USERNAME>'; // @todo: change this to your username
	const USER_ID  = '<VIMEO_USER_ID>';

	protected $FQCN   = Vimeo::class;
	protected $envvar = 'VIMEO';

	public function testLogin(){
		$this->assertSame($this::USERNAME, $this->provider->user('37851108')->json->name);
	}

}
