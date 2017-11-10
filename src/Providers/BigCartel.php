<?php
/**
 * Class BigCartel
 *
 * @filesource   BigCartel.php
 * @created      31.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://developers.bigcartel.com/api/v1
 * @link https://bigcartel.wufoo.com/confirm/big-cartel-api-application/
 *
 * @method \chillerlan\OAuth\HTTP\OAuthResponse account()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse countries()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse createArtist($account_id, array $body = ['type', 'name'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse createCategory($account_id, array $body = ['type', 'name'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse createDiscount($account_id, array $body = ['type', 'name', 'code', 'active_at', 'expires_at', 'requirement_type', 'expiration_type', 'reward_type', 'application_type', 'percent_discount', 'flat_rate_discount', 'use_limit', 'minimum_cart_total', 'minimum_cart_quantity'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse deleteArtist($account_id, $artist_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse deleteCategory($account_id, $category_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse deleteDiscount($account_id, $discount_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse getAccount($account_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse getArtist($account_id, $artist_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse getArtists($account_id, array $params = ['page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse getCategories($account_id, array $params = ['page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse getCategory($account_id, $category_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse getDiscount($account_id, $discount_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse getDiscounts($account_id, array $params = ['filter', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse getOrder($account_id, $order_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse getOrders($account_id, array $params = ['filter', 'page', 'search', 'sort'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse getProduct($account_id, $product_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse getProducts($account_id, array $params = ['filter', 'page', 'sort'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse repositionArtists($account_id, array $body = ['id', 'type'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse repositionCategories($account_id, array $body = ['id', 'type'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse repositionProducts($account_id, array $body = ['id', 'type'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse updateArtist($account_id, $artist_id, array $body = ['id', 'type', 'name'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse updateCategory($account_id, $category_id, array $body = ['id', 'type', 'name'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse updateDiscount($account_id, $discount_id, array $body = ['type', 'name', 'code', 'active_at', 'expires_at', 'requirement_type', 'expiration_type', 'reward_type', 'application_type', 'percent_discount', 'flat_rate_discount', 'use_limit', 'minimum_cart_total', 'minimum_cart_quantity'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse updateOrder($account_id, $order_id, array $body = ['id', 'type', 'customer_first_name', 'customer_last_name', 'customer_email', 'shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_state', 'shipping_zip', 'shipping_country_id', 'shipping_status'])
 */
class BigCartel extends OAuth2Provider{

	protected $apiURL         = 'https://api.bigcartel.com/v1';
	protected $authURL        = 'https://my.bigcartel.com/oauth/authorize';
	protected $accessTokenURL = 'https://api.bigcartel.com/oauth/token';
	protected $revokeURL      = 'https://api.bigcartel.com/oauth/deauthorize/{ACCOUNT_ID}'; // @todo
	protected $userRevokeURL  = 'https://my.bigcartel.com/account';
	protected $apiHeaders     = ['Accept' => 'application/vnd.api+json'];

}
