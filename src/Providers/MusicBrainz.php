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

use chillerlan\OAuth\Token;
use chillerlan\HTTP\HTTPResponseInterface;

/**
 * @link https://musicbrainz.org/doc/Development
 * @link https://musicbrainz.org/doc/Development/OAuth2
 *
 */
class MusicBrainz extends OAuth2Provider implements CSRFToken, TokenExpires, TokenRefresh{
	use CSRFTokenTrait, OAuth2TokenRefreshTrait;

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

	/**
	 * @inheritdoc
	 */
	protected function refreshAccessTokenBody(string $refreshToken):array{
		return [
			'client_id'     => $this->options->key,
			'client_secret' => $this->options->secret,
			'grant_type'    => 'refresh_token',
			'refresh_token' => $refreshToken,
		];
	}

	/**
	 * @param string $path
	 * @param array  $params
	 * @param string $method
	 * @param null   $body
	 * @param array  $headers
	 *
	 * @return \chillerlan\HTTP\HTTPResponseInterface
	 */
	public function request(string $path, array $params = null, string $method = null, $body = null, array $headers = null):HTTPResponseInterface{
		$token = $this->storage->retrieveAccessToken($this->serviceName);
		$params = $params ?? [];

		if($this->accessTokenRefreshable && ($token->isExpired() || $token->expires === $token::EOL_UNKNOWN)){
			$token = $this->refreshAccessToken($token);
		}

		if(!isset($params['fmt'])){
			$params['fmt'] = 'json';
		}

		if(!isset($params['client'])){
			$params['client'] = 'awesome-php-oauth-client-0.1'; // @todo
		}

		$headers = array_merge($this->apiHeaders, $headers ?? [], ['Authorization' => 'Bearer '.$token->accessToken]);

		return $this->httpRequest($this->apiURL.explode('?', $path)[0], $params, $method, $body, $headers);
	}

}
