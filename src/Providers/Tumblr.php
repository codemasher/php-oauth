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
 * @link https://www.tumblr.com/docs/en/api/v2
 */
class Tumblr extends OAuth1Provider{

	protected $apiURL          = 'https://api.tumblr.com/v2';
	protected $requestTokenURL = 'https://www.tumblr.com/oauth/request_token';
	protected $authURL         = 'https://www.tumblr.com/oauth/authorize';
	protected $accessTokenURL  = 'https://www.tumblr.com/oauth/access_token';
	protected $userRevokeURL   = 'https://www.tumblr.com/settings/apps';

}
