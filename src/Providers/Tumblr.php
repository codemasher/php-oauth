<?php
/**
 * Class Tumblr
 *
 * @filesource   Tumblr.php
 * @created      22.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 *
 */
class Tumblr extends OAuth1Provider{

	protected $apiURL               = 'https://api.tumblr.com/v2';
	protected $requestTokenEndpoint = 'https://www.tumblr.com/oauth/request_token';
	protected $authURL              = 'https://www.tumblr.com/oauth/authorize';
	protected $accessTokenEndpoint  = 'https://www.tumblr.com/oauth/access_token';
	protected $userRevokeURL        = 'https://www.tumblr.com/settings/apps';

}
