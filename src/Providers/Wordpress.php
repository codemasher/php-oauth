<?php
/**
 * Class Wordpress
 *
 * @filesource   Wordpress.php
 * @created      26.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://developer.wordpress.com/docs/oauth2/
 */
class Wordpress extends OAuth2Provider{

	const SCOPE_AUTH   = 'auth';
	const SCOPE_GLOBAL = 'global';

	protected $apiURL         = 'https://public-api.wordpress.com/rest/v1';
	protected $authURL        = 'https://public-api.wordpress.com/oauth2/authorize';
	protected $accessTokenURL = 'https://public-api.wordpress.com/oauth2/token';
	protected $userRevokeURL  = 'https://wordpress.com/me/security/connected-applications';

}
