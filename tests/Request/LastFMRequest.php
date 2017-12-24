<?php
/**
 * Class LastFMRequest
 *
 * @filesource   LastFMRequest.php
 * @created      05.11.2017
 * @package      chillerlan\OAuthTest\Request
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Request;

use chillerlan\OAuth\Providers\LastFM;

/**
 * @property \chillerlan\OAuth\Providers\LastFM $provider
 */
class LastFMRequest extends RequestTestAbstract{

	const ROUTES = [
		self::ROUTE_AUTH,
		self::ROUTE_API_REQUEST,
	];

	const ROUTE_AUTH = ['POST', '/lastfm/auth', [
		'headers' => [
			'Content-type: application/json'
		],
		'body'    => [
			'session'              => ['key' => 'session_key'],
		],
	]];

	const ROUTE_API_REQUEST = ['GET', '/lastfm/api/request', [
		'headers' => [
			'Content-type: application/json'
		],
		'body'    => [
			'data' => 'such data! much wow!',
		],
	]];

	protected $FQCN = LastFM::class;

	public function testGetAccessToken(){
		$this->setURL('apiURL', self::ROUTE_AUTH[1]);

		$token = $this->provider->getAccessToken('session_token');

		$this->assertSame('session_key', $token->accessToken);
	}

	public function testRequest(){
		$this->setURL('apiURL', self::ROUTE_API_REQUEST[1]);

		$response = $this->provider->request('');

		$this->assertSame('application/json', $response->headers->{'content-type'});
		$this->assertSame(self::ROUTE_API_REQUEST['2']['body']['data'], $response->json->data);
	}


}
