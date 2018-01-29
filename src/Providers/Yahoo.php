<?php
/**
 * Class Yahoo
 *
 * @filesource   Yahoo.php
 * @created      27.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://developer.yahoo.com/oauth2/guide/
 */
abstract class Yahoo extends OAuth2Provider implements CSRFToken, TokenExpires, TokenRefresh{
	use OAuth2TokenRefreshTrait;

	protected $authURL            = 'https://api.login.yahoo.com/oauth2/request_auth';
	protected $accessTokenURL     = 'https://api.login.yahoo.com/oauth2/get_token';
	protected $userRevokeURL      = 'https://login.yahoo.com/account/activity';

}
