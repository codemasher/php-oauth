<?php
/**
 * Class StreamClientTest
 *
 * @filesource   StreamClientTest.php
 * @created      21.10.2017
 * @package      chillerlan\OAuthTest\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\HTTP;

use chillerlan\OAuth\HTTP\StreamClient;
use chillerlan\TinyCurl\{Request, RequestOptions};

class StreamClientTest extends HTTPClientTestAbstract{

	protected function setUp(){
		$this->http = new StreamClient(self::CACERT, self::USER_AGENT);
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage invalid CA file
	 */
	public function testNoCAException(){
		new StreamClient('foo', self::USER_AGENT);
	}

}
