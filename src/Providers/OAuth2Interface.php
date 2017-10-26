<?php
/**
 * Interface OAuth2Interface
 *
 * @filesource   OAuth2Interface.php
 * @created      09.07.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

use chillerlan\OAuth\Token;

/**
 * @property bool supportsClientCredentials
 */
interface OAuth2Interface extends OAuthInterface{

	const HEADER_OAUTH              = 0;
	const HEADER_BEARER             = 1;
	const QUERY_ACCESS_TOKEN        = 2;
	const QUERY_OAUTH2_ACCESS_TOKEN = 3;
	const QUERY_APIKEY              = 4;
	const QUERY_AUTH                = 5;

	const AUTH_METHODS_HEADER = [
		self::HEADER_OAUTH  => 'OAuth ',
		self::HEADER_BEARER => 'Bearer ',
	];

	const AUTH_METHODS_QUERY = [
		self::QUERY_ACCESS_TOKEN        => 'access_token',
		self::QUERY_OAUTH2_ACCESS_TOKEN => 'oauth2_access_token',
		self::QUERY_APIKEY              => 'apikey',
		self::QUERY_AUTH                => 'auth',
	];

	/**
	 * @param string      $code
	 * @param string|null $state
	 *
	 * @return \chillerlan\OAuth\Token
	 */
	public function getAccessToken(string $code, string $state = null):Token;

	/**
	 * @param array $scopes
	 *
	 * @return \chillerlan\OAuth\Token
	 */
	public function getClientCredentialsToken(array $scopes = []):Token;

	/**
	 * @param \chillerlan\OAuth\Token $token
	 *
	 * @return \chillerlan\OAuth\Token
	 */
	public function refreshAccessToken(Token $token):Token;

}
