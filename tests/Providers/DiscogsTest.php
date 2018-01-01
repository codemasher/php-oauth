<?php
/**
 * Class DiscogsTest
 *
 * @filesource   Discogs.php
 * @created      05.11.2017
 * @package      chillerlan\OAuthTest\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Providers;

use chillerlan\OAuth\Providers\Discogs;

/**
 * @property \chillerlan\OAuth\Providers\Discogs $provider
 */
class DiscogsTest extends OAuth1Test{

	protected $FQCN = Discogs::class;

	public function testGetRequestTokenHeaderParams(){
		$this->setProperty($this->provider, 'requestTokenURL', '/oauth1/request_token');

		$params = $this
			->getMethod('getRequestTokenHeaderParams')
			->invoke($this->provider);

		$this->assertSame('https://localhost/callback', $params['oauth_callback']);
		$this->assertSame($this->options->key, $params['oauth_consumer_key']);
		$this->assertRegExp('/^([a-f\d]{64})$/', $params['oauth_nonce']);
		$this->assertSame('PLAINTEXT', $params['oauth_signature_method']);
		$this->assertSame($this->options->secret.'&', $params['oauth_signature']);
	}

}
