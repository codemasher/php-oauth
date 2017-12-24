<?php
/**
 * Class RequestTestAbstract
 *
 * @filesource   RequestTestAbstract.php
 * @created      04.11.2017
 * @package      chillerlan\OAuthTest\Request
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Request;

use chillerlan\OAuth\Token;
use chillerlan\OAuthTest\Providers\ProviderTestAbstract;

abstract class RequestTestAbstract extends ProviderTestAbstract{

	protected function setUp(){
		parent::setUp();

		$this->http     = new TestHTTPClient;
		$this->provider = $this->reflection->newInstanceArgs([$this->http, $this->storage, $this->options]);
	}


}
