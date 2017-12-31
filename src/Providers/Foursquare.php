<?php
/**
 * Class Foursquare
 *
 * @filesource   Foursquare.php
 * @created      22.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

use chillerlan\OAuth\HTTP\OAuthResponse;

/**
 * @link https://developer.foursquare.com/docs/
 * @link https://developer.foursquare.com/overview/auth
 */
class Foursquare extends OAuth2Provider{

	const API_VERSIONDATE = '20171022';

	protected $apiURL         = 'https://api.foursquare.com/v2';
	protected $authURL        = 'https://foursquare.com/oauth2/authenticate';
	protected $accessTokenURL = 'https://foursquare.com/oauth2/access_token';
	protected $userRevokeURL  = 'https://foursquare.com/settings/connections';
	protected $authMethod     = self::QUERY_OAUTH_TOKEN;
	protected $useCsrfToken   = false;

	/**
	 * @param string $path
	 * @param array  $params
	 * @param string $method
	 * @param null   $body
	 * @param array  $headers
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 */
	public function request(string $path, array $params = null, string $method = null, $body = null, array $headers = null):OAuthResponse{

		parse_str(parse_url($this->apiURL.$path, PHP_URL_QUERY), $query);

		$query['v'] = $this::API_VERSIONDATE;
		$query['m'] = 'foursquare';

		return parent::request(explode('?', $path)[0], array_merge($params ?? [], $query), $method, $body, $headers);
	}

}
