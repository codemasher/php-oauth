<?php
/**
 * Class TinyCurlClientTest
 *
 * @filesource   TinyCurlClientTest.php
 * @created      21.10.2017
 * @package      chillerlan\OAuthTest\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\HTTP;

use chillerlan\OAuth\HTTP\TinyCurlClient;
use chillerlan\TinyCurl\{Request, RequestOptions};

class TinyCurlClientTest extends HTTPClientTestAbstract{

	protected function setUp(){
		$this->http = new TinyCurlClient(new Request(new RequestOptions([
			'ca_info'    => self::CACERT,
			'user_agent' => self::USER_AGENT,
		])));
	}

}
