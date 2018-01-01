<?php
/**
 * Class TwitterTest
 *
 * @filesource   TwitterTest.php
 * @created      01.01.2018
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\Twitter;

/**
 * @property \chillerlan\OAuth\Providers\Twitter $provider
 */
class TwitterTest extends OAuth1Test{

	protected $FQCN = Twitter::class;

	public function testCheckParams(){
		$data = ['foo' => 'bar', 'whatever' => null, 'nope' => '', 'true' => true, 'false' => false];

		$this->assertSame(['foo' => 'bar', 'true' => 'true', 'false' => 'false'], $this->getMethod('checkParams')->invokeArgs($this->provider, [$data]));
	}

}
