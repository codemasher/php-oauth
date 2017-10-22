<?php
/**
 * Class CurlClientTest
 *
 * @filesource   CurlClientTest.php
 * @created      21.10.2017
 * @package      chillerlan\OAuthTest\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\HTTP;

use chillerlan\OAuth\HTTP\CurlClient;

class CurlClientTest extends HTTPClientTestAbstract{

	protected $FQCN = CurlClient::class;

	protected function setUp(){

		$this->http = new $this->FQCN([
			CURLOPT_CAINFO => self::CACERT,
			CURLOPT_USERAGENT => self::USER_AGENT
		]);

	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage invalid CA file
	 */
	public function testNoCAException(){
		$this->http = new $this->FQCN([CURLOPT_CAINFO => 'foo']);
	}

}
