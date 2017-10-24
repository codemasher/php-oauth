<?php
/**
 * Class GuildWars2Test
 *
 * @filesource   GuildWars2Test.php
 * @created      15.07.2017
 * @package      chillerlan\OAuthTest
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\GuildWars2;

class GuildWars2Test extends APITestAbstract{

	protected $providerClass = GuildWars2::class;

	/**
	 * @var \chillerlan\OAuth\Providers\GuildWars2
	 */
	protected $provider;

	/**
	 * @var \chillerlan\OAuth\Token
	 */
	protected $token;

	public function testStoreGW2Token(){
		$this->token = $this->provider->storeGW2Token(getenv('GW2_TOKEN'));

		$this->assertSame(getenv('GW2_TOKEN'), $this->token->accessToken);
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage invalid/unverified token
	 */
	public function testStoreInvalidGW2TokenException(){
		$this->provider->storeGW2Token('foo');
	}

}
