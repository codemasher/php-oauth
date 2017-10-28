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
 */
class Mixcloud extends OAuth2Provider{

	protected $apiURL              = 'https://api.mixcloud.com';
	protected $authURL             = 'https://www.mixcloud.com/oauth/authorize';
	protected $accessTokenEndpoint = 'https://www.mixcloud.com/oauth/access_token';
	protected $authMethod          = self::QUERY_ACCESS_TOKEN;
	protected $csrfToken           = false;

}