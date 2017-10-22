<?php
/**
 * Class Google
 *
 * @filesource   Google.php
 * @created      22.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://developers.google.com/identity/protocols/OAuth2WebServer
 * @link https://developers.google.com/identity/protocols/OAuth2ServiceAccount
 * @link https://developers.google.com/oauthplayground/
 */
class Google extends OAuth2Provider{

	const SCOPE_EMAIL            = 'email';
	const SCOPE_PROFILE          = 'profile';
	const SCOPE_USERINFO_EMAIL   = 'https://www.googleapis.com/auth/userinfo.email';
	const SCOPE_USERINFO_PROFILE = 'https://www.googleapis.com/auth/userinfo.profile';
	const SCOPE_YOUTUBE          = 'https://www.googleapis.com/auth/youtube';
	const SCOPE_YOUTUBE_GDATA    = 'https://gdata.youtube.com';

	protected $apiURL              = 'https://www.googleapis.com';
	protected $authURL             = 'https://accounts.google.com/o/oauth2/auth';
	protected $accessTokenEndpoint = 'https://accounts.google.com/o/oauth2/token';
	protected $userRevokeURL       = 'https://myaccount.google.com/permissions';
	protected $accessTokenExpires  = true;

}
