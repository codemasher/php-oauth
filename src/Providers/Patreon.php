<?php
/**
 * Class Patreon
 *
 * @filesource   Patreon.php
 * @created      26.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://docs.patreon.com/
 */
class Patreon extends OAuth2Provider{

	const SCOPE_USERS         = 'users';
	const SCOPE_PLEDGES_TO_ME = 'pledges-to-me';
	const SCOPE_MY_CAMPAIGN   = 'my-campaign';

	protected $apiURL              = 'https://www.patreon.com/api/oauth2/api';
	protected $authURL             = 'https://www.patreon.com/oauth2/authorize';
	protected $accessTokenEndpoint = 'https://www.patreon.com/api/oauth2/token';
	protected $accessTokenExpires  = true;
	protected $authMethod          = self::HEADER_BEARER;


}
