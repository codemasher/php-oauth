<?php
/**
 * Class MusicBrainz
 *
 * @filesource   MusicBrainz.php
 * @created      22.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

use chillerlan\OAuth\HTTP\OAuthResponse;
use chillerlan\OAuth\{Token, OAuthException};

/**
 * @link https://musicbrainz.org/doc/Development
 * @link https://musicbrainz.org/doc/Development/OAuth2
 *
 */
class MusicBrainz extends OAuth2Provider{

	const SCOPE_PROFILE        = 'profile';
	const SCOPE_EMAIL          = 'email';
	const SCOPE_TAG            = 'tag';
	const SCOPE_RATING         = 'rating';
	const SCOPE_COLLECTION     = 'collection';
	const SCOPE_SUBMIT_ISRC    = 'submit_isrc';
	const SCOPE_SUBMIT_BARCODE = 'submit_barcode';

	protected $apiURL              = 'https://musicbrainz.org/ws/2';
	protected $authURL             = 'https://musicbrainz.org/oauth2/authorize';
	protected $userRevokeURL       = 'https://musicbrainz.org/account/applications';
	protected $accessTokenEndpoint = 'https://musicbrainz.org/oauth2/token';
	protected $accessTokenExpires  = true;
	protected $checkState          = true;
	protected $authMethod          = self::HEADER_BEARER;

	/**
	 * @param string $path
	 * @param array  $params
	 * @param string $method
	 * @param null   $body
	 * @param array  $headers
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function request(string $path, array $params = [], string $method = 'GET', $body = null, array $headers = []):OAuthResponse{
		$token = $this->storage->retrieveAccessToken($this->serviceName);

		if($this->accessTokenExpires && $token->isExpired()){
			throw new OAuthException(sprintf('Token expired on %s at %s', date('m/d/Y', $token->expires), date('h:i:s A', $token->expires))); // @codeCoverageIgnore
		}

		if(!isset($params['fmt'])){
			$params['fmt'] = 'json';
		}

		if(!isset($params['client'])){
			$params['client'] = 'awesome-php-oauth-client-0.1'; // @todo
		}

		$headers = array_merge($this->apiHeaders, $headers, ['Authorization' => 'Bearer '.$token->accessToken]);

		return $this->http->request($this->apiURL.explode('?', $path)[0], $params, $method, $body, $headers);
	}

	/**
	 * @param \chillerlan\OAuth\Token $token
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function refreshAccessToken(Token $token = null):Token{

		if(is_null($token)){
			$token = $this->storage->retrieveAccessToken($this->serviceName);
		}

		$refreshToken = $token->refreshToken;

		if(empty($refreshToken)){
			throw new OAuthException('no refresh token available'); // @codeCoverageIgnore
		}

		$body = [
			'grant_type'    => 'refresh_token',
			'client_id'     => $this->options->key,
			'client_secret' => $this->options->secret,
			'refresh_token' => $refreshToken,
		];

		$token = $this->parseResponse($this->http->request($this->accessTokenEndpoint, [], 'POST', $body, $this->authHeaders));

		if(!$token->refreshToken){
			$token->refreshToken = $refreshToken;
		}

		$this->storage->storeAccessToken($this->serviceName, $token);

		return $token;
	}

}
