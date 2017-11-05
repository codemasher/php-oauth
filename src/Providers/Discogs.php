<?php
/**
 * Class Discogs
 *
 * @filesource   Discogs.php
 * @created      09.07.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

use DateTime;

/**
 * @link https://www.discogs.com/developers/
 * @link https://www.discogs.com/developers/#page:authentication,header:authentication-oauth-flow
 *
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artist(string $artist_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artistReleases(string $artist_id, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionCreateFolder(string $username, array $body = ['name'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionDeleteFolder(string $username, string $folder_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionFields(string $username)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionFolder(string $username, string $folder_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionFolderAddRelease(string $username, string $folder_id, string $release_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionFolderRateRelease(string $username, string $folder_id, string $release_id, string $instance_id, array $body = ['rating'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionFolderReleases(string $username, string $folder_id, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionFolderRemoveRelease(string $username, string $folder_id, string $release_id, string $instance_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionFolderUpdateReleaseField(string $username, string $folder_id, string $release_id, string $instance_id, string $field_id, array $body = ['value'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionFolders(string $username)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionRelease(string $username, string $release_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionUpdateFolder(string $username, string $folder_id, array $body = ['name'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionValue(string $username)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse contributions(string $username, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse identity()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse inventory(string $username, array $params = ['page', 'per_page', 'status', 'sort', 'sort_order'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse label(string $label_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse labelReleases(string $label_id, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse list(string $list_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse lists(string $username)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse marketplaceCreateListing(array $body = ['release_id', 'condition', 'sleeve_condition', 'price', 'comments', 'allow_offers', 'status', 'external_id', 'location', 'weight', 'format_quantity'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse marketplaceFee(string $price)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse marketplaceFeeCurrency(string $price, string $currency)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse marketplaceListing(string $listing_id, array $params = ['curr_abbr'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse marketplaceOrder(string $order_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse marketplaceOrderAddMessage(string $order_id, array $body = ['message', 'status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse marketplaceOrderMessages(string $order_id, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse marketplaceOrders(array $params = ['status', 'page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse marketplaceRemoveListing(string $listing_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse marketplaceUpdateListing(string $listing_id, array $body = ['release_id', 'condition', 'sleeve_condition', 'price', 'comments', 'allow_offers', 'status', 'external_id', 'location', 'weight', 'format_quantity'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse marketplaceUpdateOrder(string $order_id, array $body = ['status', 'shipping'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse master(string $master_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse masterVersions(string $master_id, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse profile(string $username)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse profileUpdate(string $username, array $body = ['name', 'home_page', 'location', 'curr_abbr'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse release(string $release_id, array $params = ['curr_abbr'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse releasePriceSuggestion(string $release_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse releaseRating(string $release_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse releaseRemoveUserRating(string $release_id, string $username)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse releaseUpdateUserRating(string $release_id, string $username)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse releaseUserRating(string $release_id, string $username)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse search(array $params = ['q', 'query', 'type', 'title', 'release_title', 'credit', 'artist', 'anv', 'label', 'genre', 'style', 'country', 'year', 'format', 'catno', 'barcode', 'track', 'submitter', 'contributor'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse submissions(string $username, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wantlist(string $username, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wantlistAdd(string $username, string $release_id, array $body = ['notes', 'rating'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wantlistRemove(string $username, string $release_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wantlistUpdate(string $username, string $release_id, array $body = ['notes', 'rating'])
 */
class Discogs extends OAuth1Provider{

	protected $apiURL          = 'https://api.discogs.com';
	protected $requestTokenURL = 'https://api.discogs.com/oauth/request_token';
	protected $authURL         = 'https://www.discogs.com/oauth/authorize';
	protected $accessTokenURL  = 'https://api.discogs.com/oauth/access_token';
	protected $revokeURL       = 'https://www.discogs.com/oauth/revoke'; // ?access_key=<TOKEN>
	protected $userRevokeURL   = 'https://www.discogs.com/settings/applications';
	protected $apiHeaders      = ['Accept' => 'application/vnd.discogs.v2.discogs+json'];

	/**
	 * @inheritdoc
	 */
	protected function getRequestTokenHeaderParams():array{
		return [
			'oauth_callback'         => $this->options->callbackURL,
			'oauth_consumer_key'     => $this->options->key,
			'oauth_nonce'            => bin2hex(random_bytes(32)),
			'oauth_signature'        => $this->options->secret.'&',
			'oauth_signature_method' => 'PLAINTEXT',
			'oauth_timestamp'        => (new DateTime())->format('U'),
		];
	}

}
