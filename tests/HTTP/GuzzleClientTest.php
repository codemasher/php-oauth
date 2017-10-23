<?php
/**
 * Class GuzzleClientTest
 *
 * @filesource   GuzzleClientTest.php
 * @created      23.10.2017
 * @package      chillerlan\OAuthTest\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\HTTP;

use chillerlan\OAuth\HTTP\GuzzleClient;
use GuzzleHttp\Client;

class GuzzleClientTest extends HTTPClientTestAbstract{

	protected $FQCN = GuzzleClient::class;

	protected function setUp(){

		$client = new Client([
			'cacert' => self::CACERT,
		]);

		$this->http = new $this->FQCN($client);
	}

}
