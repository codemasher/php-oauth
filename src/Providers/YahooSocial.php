<?php
/**
 * Class YahooSocial
 *
 * @filesource   YahooSocial.php
 * @created      27.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://developer.yahoo.com/social/rest_api_guide/
 */
class YahooSocial extends Yahoo{

	const SCOPE_READ_PUBLIC               = 'sdps-r';
	const SCOPE_READ_WRITE_PUBLIC         = 'sdps-w';
	const SCOPE_READ_WRITE_PUBLIC_PRIVATE = 'sdpp-w';

	protected $apiURL = 'https://social.yahooapis.com/v1';

}
