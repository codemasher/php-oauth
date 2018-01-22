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

use chillerlan\OAuth\{
	HTTP\OAuthResponse, Token
};

/**
 * @link https://developers.deezer.com/api/oauth
 *
 * sure, you *can* use different parameter names than the standard ones... and what about JSON?
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

	protected $apiURL         = 'https://api.deezer.com';
	protected $authURL        = 'https://connect.deezer.com/oauth/auth.php';
	protected $accessTokenURL = 'https://connect.deezer.com/oauth/access_token.php';
	protected $userRevokeURL  = 'https://www.deezer.com/account/apps';
	protected $authMethod     = self::QUERY_ACCESS_TOKEN;

	/**
	 * @param array $params
	 *
	 * @return array
	 */
	protected function getAuthURLParams(array $params):array {
		return array_merge($params, [
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
	 * @throws \chillerlan\OAuth\Providers\ProviderException
	 */
	protected function parseTokenResponse(OAuthResponse $response):Token{
		parse_str($response->body, $data);

		if(!is_array($data) || empty($data)){
			throw new ProviderException('unable to parse token response');
		}

		if(isset($data['error_reason'])){
			throw new ProviderException('error retrieving access token: "'.$data['error_reason'].'"');
		}

		if(!isset($data['access_token'])){
			throw new ProviderException('token missing');
		}

		$token = new Token([
			'provider'     => $this->serviceName,
			'accessToken'  => $data['access_token'],
			'expires'      => $data['expires'] ?? Token::EOL_NEVER_EXPIRES,
		]);

		unset($data['expires'], $data['access_token']);

		$token->extraParams = $data;

		return $token;
	}

}
