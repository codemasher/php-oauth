<?php
/**
 * Class Twitter2
 *
 * @filesource   Twitter2.php
 * @created      10.07.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

use chillerlan\OAuth\{
	OAuthException, Token
};

/**
 * @link https://dev.twitter.com/overview/api
 * @link https://developer.twitter.com/en/docs/basics/authentication/overview/application-only
 */
class Twitter2 extends OAuth2Provider{

	protected $AUTH_ERRMSG = 'Twitter2 only supports Client Credentials Grant, use the Twitter OAuth1 class for authentication instead.';

	protected $apiURL                    = 'https://api.twitter.com/1.1';
	protected $clientCredentialsTokenURL = 'https://api.twitter.com/oauth2/token';
	protected $clientCredentials         = true;
	protected $userRevokeURL             = 'https://twitter.com/settings/applications';

	/**
	 * @inheritdoc
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function getAuthURL(array $params = []):string{
		throw new OAuthException($this->AUTH_ERRMSG);
	}

	/**
	 * @inheritdoc
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function getAccessToken(string $code, string $state = null):Token{
		throw new OAuthException($this->AUTH_ERRMSG);
	}

}
