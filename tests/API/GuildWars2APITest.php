<?php
/**
 * Class GuildWars2APITest
 *
 * @filesource   GuildWars2APITest.php
 * @created      15.07.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\GuildWars2;

/**
 * @property \chillerlan\OAuth\Providers\GuildWars2 $provider
 */
class GuildWars2APITest extends APITestAbstract{

	protected $FQCN = GuildWars2::class;

	/**
	 * @var \chillerlan\OAuth\Token
	 */
	protected $token;

	public function testStoreGW2Token(){
		$this->token = $this->provider->storeGW2Token($this->env->get('GW2_TOKEN'));

		$this->assertSame($this->env->get('GW2_TOKEN'), $this->token->accessToken);
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage invalid token
	 */
	public function testStoreInvalidGW2TokenException(){
		$this->provider->storeGW2Token('foo');
	}

}
