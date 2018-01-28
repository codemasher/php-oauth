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
use chillerlan\HTTP\HTTPResponseInterface;

/**
 * @link https://www.discogs.com/developers/
 * @link https://www.discogs.com/developers/#page:authentication,header:authentication-oauth-flow
 *
 * @method \chillerlan\HTTP\HTTPResponseInterface artist(string $artist_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface artistReleases(string $artist_id, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionCreateFolder(string $username, array $body = ['name'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionDeleteFolder(string $username, string $folder_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionFields(string $username)
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionFolder(string $username, string $folder_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionFolderAddRelease(string $username, string $folder_id, string $release_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionFolderRateRelease(string $username, string $folder_id, string $release_id, string $instance_id, array $body = ['rating'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionFolderReleases(string $username, string $folder_id, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionFolderRemoveRelease(string $username, string $folder_id, string $release_id, string $instance_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionFolderUpdateReleaseField(string $username, string $folder_id, string $release_id, string $instance_id, string $field_id, array $body = ['value'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionFolders(string $username)
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionRelease(string $username, string $release_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionUpdateFolder(string $username, string $folder_id, array $body = ['name'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionValue(string $username)
 * @method \chillerlan\HTTP\HTTPResponseInterface contributions(string $username, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\HTTP\HTTPResponseInterface identity()
 * @method \chillerlan\HTTP\HTTPResponseInterface inventory(string $username, array $params = ['page', 'per_page', 'status', 'sort', 'sort_order'])
 * @method \chillerlan\HTTP\HTTPResponseInterface label(string $label_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface labelReleases(string $label_id, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\HTTP\HTTPResponseInterface list(string $list_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface lists(string $username)
 * @method \chillerlan\HTTP\HTTPResponseInterface marketplaceCreateListing(array $body = ['release_id', 'condition', 'sleeve_condition', 'price', 'comments', 'allow_offers', 'status', 'external_id', 'location', 'weight', 'format_quantity'])
 * @method \chillerlan\HTTP\HTTPResponseInterface marketplaceFee(string $price)
 * @method \chillerlan\HTTP\HTTPResponseInterface marketplaceFeeCurrency(string $price, string $currency)
 * @method \chillerlan\HTTP\HTTPResponseInterface marketplaceListing(string $listing_id, array $params = ['curr_abbr'])
 * @method \chillerlan\HTTP\HTTPResponseInterface marketplaceOrder(string $order_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface marketplaceOrderAddMessage(string $order_id, array $body = ['message', 'status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface marketplaceOrderMessages(string $order_id, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\HTTP\HTTPResponseInterface marketplaceOrders(array $params = ['status', 'page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\HTTP\HTTPResponseInterface marketplaceRemoveListing(string $listing_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface marketplaceUpdateListing(string $listing_id, array $body = ['release_id', 'condition', 'sleeve_condition', 'price', 'comments', 'allow_offers', 'status', 'external_id', 'location', 'weight', 'format_quantity'])
 * @method \chillerlan\HTTP\HTTPResponseInterface marketplaceUpdateOrder(string $order_id, array $body = ['status', 'shipping'])
 * @method \chillerlan\HTTP\HTTPResponseInterface master(string $master_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface masterVersions(string $master_id, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\HTTP\HTTPResponseInterface profile(string $username)
 * @method \chillerlan\HTTP\HTTPResponseInterface profileUpdate(string $username, array $body = ['name', 'home_page', 'location', 'curr_abbr'])
 * @method \chillerlan\HTTP\HTTPResponseInterface release(string $release_id, array $params = ['curr_abbr'])
 * @method \chillerlan\HTTP\HTTPResponseInterface releasePriceSuggestion(string $release_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface releaseRating(string $release_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface releaseRemoveUserRating(string $release_id, string $username)
 * @method \chillerlan\HTTP\HTTPResponseInterface releaseUpdateUserRating(string $release_id, string $username)
 * @method \chillerlan\HTTP\HTTPResponseInterface releaseUserRating(string $release_id, string $username)
 * @method \chillerlan\HTTP\HTTPResponseInterface search(array $params = ['q', 'query', 'type', 'title', 'release_title', 'credit', 'artist', 'anv', 'label', 'genre', 'style', 'country', 'year', 'format', 'catno', 'barcode', 'track', 'submitter', 'contributor'])
 * @method \chillerlan\HTTP\HTTPResponseInterface submissions(string $username, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\HTTP\HTTPResponseInterface wantlist(string $username, array $params = ['page', 'per_page', 'sort', 'sort_order'])
 * @method \chillerlan\HTTP\HTTPResponseInterface wantlistAdd(string $username, string $release_id, array $body = ['notes', 'rating'])
 * @method \chillerlan\HTTP\HTTPResponseInterface wantlistRemove(string $username, string $release_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface wantlistUpdate(string $username, string $release_id, array $body = ['notes', 'rating'])
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
			'oauth_nonce'            => $this->nonce(),
			'oauth_signature'        => $this->options->secret.'&',
			'oauth_signature_method' => 'PLAINTEXT',
			'oauth_timestamp'        => (new DateTime())->format('U'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function request(string $path, array $params = null, string $method = null, $body = null, array $headers = null):HTTPResponseInterface{
		$method = $method ?? 'GET';

		$headers = $this->requestHeaders(
			$this->apiURL.$path,
			$params ?? [],
			$method,
			$headers,
			$this->storage->retrieveAccessToken($this->serviceName)
		);

		return $this->httpRequest($this->apiURL.$path, $params, $method, $body, $headers);
	}

}
