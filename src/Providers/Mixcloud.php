<?php
/**
 * Class Mixcloud
 *
 * @filesource   Mixcloud.php
 * @created      28.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://www.mixcloud.com/developers/
 */
class Mixcloud extends OAuth2Provider{

	protected $apiURL         = 'https://api.mixcloud.com';
	protected $authURL        = 'https://www.mixcloud.com/oauth/authorize';
	protected $accessTokenURL = 'https://www.mixcloud.com/oauth/access_token';
	protected $userRevokeURL  = 'https://www.mixcloud.com/settings/applications/';
	protected $authMethod     = self::QUERY_ACCESS_TOKEN;
	protected $useCsrfToken   = false;

}
