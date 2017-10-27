<?php
/**
 * Class Deezer
 *
 * @filesource   Deezer.php
 * @created      26.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

use chillerlan\OAuth\HTTP\OAuthResponse;
use chillerlan\OAuth\OAuthException;
use chillerlan\OAuth\Token;

/**
 * @link https://developers.deezer.com/api/oauth
 *
 * sure, you *can* use different parameter names than the standard ones...
 * https://xkcd.com/927/
 */
class Deezer extends OAuth2Provider{

	const SCOPE_BASIC             = 'basic_access';
	const SCOPE_EMAIL             = 'email';
	const SCOPE_OFFLINE_ACCESS    = 'offline_access';
	const SCOPE_MANAGE_LIBRARY    = 'manage_library';
	const SCOPE_MANAGE_COMMUNITY  = 'manage_community';
	const SCOPE_DELETE_LIBRARY    = 'delete_library';
	const SCOPE_LISTENING_HISTORY = 'listening_history';

	protected $apiURL              = 'https://api.deezer.com';
	protected $authURL             = 'https://connect.deezer.com/oauth/auth.php';
	protected $accessTokenEndpoint = 'https://connect.deezer.com/oauth/access_token.php';
	protected $authMethod          = self::QUERY_ACCESS_TOKEN;

	/**
	 * @param array $parameters
	 *
	 * @return array
	 */
	protected function getAuthURLBody(array $parameters):array {
		return array_merge($parameters, [
			'app_id'        => $this->options->key,
			'redirect_uri'  => $this->options->callbackURL,
			'perms'         => implode($this->scopesDelimiter, $this->scopes),
#			'response_type' => 'token', // -> token in hash fragment
		]);
	}

	/**
	 * @param string $code
	 *
	 * @return array
	 */
	protected function getAccessTokenBody(string $code):array {
		return [
			'app_id' => $this->options->key,
			'secret' => $this->options->secret,
			'code'   => $code,
			'output' => 'json',
		];
	}

	/**
	 * @param OAuthResponse $response
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	protected function parseResponse(OAuthResponse $response):Token{
		parse_str($response->body, $data);

		if(!is_array($data)){
			throw new OAuthException('unable to parse access token response'.PHP_EOL.print_r($response, true));
		}

		$this->checkResponse($data);

		$token = new Token([
			'accessToken'  => $data['access_token'],
			'expires'      => $data['expires'] ?? Token::EOL_NEVER_EXPIRES,
		]);

		unset($data['expires'], $data['access_token']);

		$token->extraParams = $data;

		return $token;
	}

}
