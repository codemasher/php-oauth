<?php
/**
 * Class SoundCloud
 *
 * @filesource   SoundCloud.php
 * @created      22.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://developers.soundcloud.com/
 * @link https://developers.soundcloud.com/docs/api/guide#authentication
 *
 */
class SoundCloud extends OAuth2Provider implements TokenExpires{

	const SCOPE_NONEXPIRING = 'non-expiring';
#	const SCOPE_EMAIL       = 'email'; // ???

	protected $apiURL             = 'https://api.soundcloud.com';
	protected $authURL            = 'https://soundcloud.com/connect';
	protected $accessTokenURL     = 'https://api.soundcloud.com/oauth2/token';
	protected $userRevokeURL      = 'https://soundcloud.com/settings/connections';
	protected $authMethod         = self::HEADER_OAUTH;

}
