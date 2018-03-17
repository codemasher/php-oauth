<?php
/**
 * Class Amazon
 *
 * @filesource   Amazon.php
 * @created      22.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://login.amazon.com/
 * @link https://images-na.ssl-images-amazon.com/images/G/01/lwa/dev/docs/website-developer-guide._TTH_.pdf
 * @link https://images-na.ssl-images-amazon.com/images/G/01/mwsportal/doc/en_US/offamazonpayments/LoginAndPayWithAmazonIntegrationGuide._V335378063_.pdf
 */
class Amazon extends OAuth2Provider implements CSRFToken, TokenExpires, TokenRefresh{
	use CSRFTokenTrait, OAuth2TokenRefreshTrait;

	const SCOPE_PROFILE         = 'profile';
	const SCOPE_PROFILE_USER_ID = 'profile:user_id';
	const SCOPE_POSTAL_CODE     = 'postal_code';

	protected $apiURL             = 'https://api.amazon.com';
	protected $authURL            = 'https://www.amazon.com/ap/oa';
	protected $accessTokenURL     = 'https://www.amazon.com/ap/oatoken';

}
