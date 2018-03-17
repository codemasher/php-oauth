<?php
/**
 * Class Gitter
 *
 * @filesource   Gitter.php
 * @created      22.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://developer.gitter.im/
 * @link https://developer.gitter.im/docs/authentication
 *
 */
class Gitter extends OAuth2Provider implements CSRFToken, TokenExpires{
	use CSRFTokenTrait;

	const SCOPE_FLOW    = 'flow';
	const SCOPE_PRIVATE = 'private';

	protected $apiURL             = 'https://api.gitter.im/v1';
	protected $authURL            = 'https://gitter.im/login/oauth/authorize';
	protected $accessTokenURL     = 'https://gitter.im/login/oauth/token';
	protected $scopesDelimiter    = ',';

}
