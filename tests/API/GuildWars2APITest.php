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

class GuildWars2APITest extends APITestAbstract{

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

	public function testStuff(){

		print_r($this->provider->colors(['ids' => '1,2,3', 'lang' => 'zh'])->json);

/*
		print_r($this->provider->build());
		print_r($this->provider->cats(['ids' => '1,2,3']));
		print_r($this->provider->catsId(3));
		print_r($this->provider->color(1, ['lang' => 'zh']));
		print_r($this->provider->color(1, ['lang' => 'zh']));
*/



	}
}
