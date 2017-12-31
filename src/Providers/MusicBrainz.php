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

use chillerlan\OAuth\{Token, HTTP\OAuthResponse};

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

	protected $apiURL             = 'https://musicbrainz.org/ws/2';
	protected $authURL            = 'https://musicbrainz.org/oauth2/authorize';
	protected $accessTokenURL     = 'https://musicbrainz.org/oauth2/token';
	protected $userRevokeURL      = 'https://musicbrainz.org/account/applications';
	protected $accessTokenExpires = true;

	/**
	 * @inheritdoc
	 */
	public function refreshAccessTokenBody(Token $token):array{
		return [
			'client_id'     => $this->options->key,
			'client_secret' => $this->options->secret,
			'grant_type'    => 'refresh_token',
			'refresh_token' => $token->refreshToken,
		];
	}

	/**
	 * @param string $path
	 * @param array  $params
	 * @param string $method
	 * @param null   $body
	 * @param array  $headers
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 * @throws \chillerlan\OAuth\Providers\ProviderException
	 */
	public function request(string $path, array $params = null, string $method = null, $body = null, array $headers = null):OAuthResponse{
		$token = $this->storage->retrieveAccessToken($this->serviceName);
		$params = $params ?? [];

		if($this->accessTokenExpires && $token->isExpired()){
			throw new ProviderException(sprintf('Token expired on %s at %s', date('m/d/Y', $token->expires), date('h:i:s A', $token->expires))); // @codeCoverageIgnore
		}

		if(!isset($params['fmt'])){
			$params['fmt'] = 'json';
		}

		if(!isset($params['client'])){
			$params['client'] = 'awesome-php-oauth-client-0.1'; // @todo
		}

		$headers = array_merge($this->apiHeaders, $headers ?? [], ['Authorization' => 'Bearer '.$token->accessToken]);

		return $this->http->request($this->apiURL.explode('?', $path)[0], $params, $method, $body, $headers);
	}

}
