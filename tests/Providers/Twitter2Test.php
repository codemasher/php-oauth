<?php
/**
 * Class Twitter2Test
 *
 * @filesource   Twitter2Test.php
 * @created      26.10.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\Twitter2;

/**
 * @property \chillerlan\OAuth\Providers\Twitter2 $provider
 */
class Twitter2Test extends ProviderTestAbstract{

	protected $FQCN = Twitter2::class;

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage Twitter2 only supports Client Credentials Grant
	 */
	public function testRequestGetAuthURLNotSupportedException(){
		$this->provider->getAuthURL();
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage Twitter2 only supports Client Credentials Grant
	 */
	public function testRequestGetAccessTokenNotSupportedException(){
		$this->provider->getAccessToken('foo');
	}

}
