<?php
/**
 * Class FlickrAPITest
 *
 * @filesource   FlickrAPITest.phpphp
 * @created      15.07.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\Flickr;

/**
 * @property  \chillerlan\OAuth\Providers\Flickr $provider
 */
class FlickrAPITest extends APITestAbstract{

	const USER = '<FLICKR_USERNAME>'; // @todo: change this to your username

	protected $FQCN   = Flickr::class;
	protected $envvar = 'FLICKR';

	public function testLogin(){
		$this->assertSame($this::USER, $this->provider->testLogin()->json->user->username->_content);
	}
	
}
