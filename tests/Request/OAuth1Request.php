<?php
/**
 * Class OAuth1Request
 *
 * @filesource   OAuth1Request.php
 * @created      04.11.2017
 * @package      chillerlan\OAuthTest\Request
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Request;

use chillerlan\OAuth\Token;

/**
 * @property \chillerlan\OAuth\Providers\OAuth1Interface $provider
 */
class OAuth1Request extends RequestTestAbstract{

	const ROUTES = [
		self::ROUTE_REQUEST_TOKEN,
		self::ROUTE_ACCESS_TOKEN,
		self::ROUTE_API_REQUEST,
	];

	const ROUTE_REQUEST_TOKEN = ['POST', '/oauth1/request_token', [
		'body'    => [
			'oauth_token'              => 'test_request_token',
			'oauth_token_secret'       => 'test_request_token_secret',
			'oauth_callback_confirmed' => 'true',
		],
	]];

	const ROUTE_ACCESS_TOKEN = ['POST', '/oauth1/access_token', [
		'body'    => [
			'oauth_token'              => 'test_access_token',
			'oauth_token_secret'       => 'test_access_token_secret',
			'oauth_callback_confirmed' => 'true',
		],
	]];

	const ROUTE_API_REQUEST = ['GET', '/oauth1/api/request', [
		'headers' => [
			'Content-type: application/json'
		],
		'body'    => [
			'data' => 'such data! much wow!',
		],
	]];

	protected $FQCN = TestOAuth1Provider::class;

	public function testGetAuthURL(){
		$this->setURL('requestTokenURL', self::ROUTE_REQUEST_TOKEN[1]);

		parse_str(parse_url($this->provider->getAuthURL(), PHP_URL_QUERY), $query);

		$this->assertSame('test_request_token', $query['oauth_token']);
	}

	public function testGetAccessToken(){
		$this->setURL('accessTokenURL', self::ROUTE_ACCESS_TOKEN[1]);
		$this->storeToken(new Token(['requestTokenSecret' => 'test_request_token_secret']));

		$token = $this->provider->getAccessToken('test_request_token', 'verifier');

		$this->assertSame('test_access_token', $token->accessToken);
		$this->assertSame('test_access_token_secret', $token->accessTokenSecret);
	}

	public function testRequest(){
		$this->setURL('apiURL', self::ROUTE_API_REQUEST[1]);
		$this->storeToken(new Token(['requestTokenSecret' => 'test_request_token_secret']));

		$response = $this->provider->request('');

		$this->assertSame('application/json', $response->headers->{'content-type'});
		$this->assertSame(self::ROUTE_API_REQUEST['2']['body']['data'], $response->json->data);
	}

}
