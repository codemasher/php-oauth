<?php
/**
 * Class Stripe
 *
 * @filesource   Stripe.php
 * @created      05.12.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://stripe.com/docs/api
 * @link https://stripe.com/docs/connect/authentication
 * @link https://stripe.com/docs/connect/oauth-reference
 * @link https://stripe.com/docs/connect/standard-accounts
 * @link https://gist.github.com/amfeng/3507366
 */
class Stripe extends OAuth2Provider{

	const SCOPE_READ_WRITE = 'read_write';
	const SCOPE_READ_ONLY  = 'read_only';

	protected $apiURL                 = 'https://api.stripe.com/v1';
	protected $authURL                = 'https://connect.stripe.com/oauth/authorize';
	protected $accessTokenURL         = 'https://connect.stripe.com/oauth/token';
	protected $revokeURL              = 'https://connect.stripe.com/oauth/deauthorize';
	protected $userRevokeURL          = 'https://dashboard.stripe.com/account/applications';
	protected $accessTokenRefreshable = true;

}
