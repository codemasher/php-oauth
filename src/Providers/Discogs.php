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
 * @method mixed artist(string $artist_id)
 * @method mixed artistReleases(string $artist_id, array $params = ['sort', 'sort_order'])
 * @method mixed collectionCreateFolder(string $username, $body = null)
 * @method mixed collectionDeleteFolder(string $username, string $folder_id)
 * @method mixed collectionFields(string $username)
 * @method mixed collectionFolder(string $username, string $folder_id)
 * @method mixed collectionFolderAddRelease(string $username, string $folder_id, string $release_id)
 * @method mixed collectionFolderRateRelease(string $username, string $folder_id, string $release_id, string $instance_id, $body = null)
 * @method mixed collectionFolderReleases(string $username, string $folder_id)
 * @method mixed collectionFolderRemoveRelease(string $username, string $folder_id, string $release_id, string $instance_id)
 * @method mixed collectionFolderUpdateReleaseField(string $username, string $folder_id, string $release_id, string $instance_id, string $field_id, array $params = ['value'], $body = null)
 * @method mixed collectionFolders(string $username)
 * @method mixed collectionRelease(string $username, string $release_id)
 * @method mixed collectionUpdateFolder(string $username, string $folder_id, $body = null)
 * @method mixed collectionValue(string $username)
 * @method mixed contributions(string $username, array $params = ['sort', 'sort_order'])
 * @method mixed identity()
 * @method mixed inventory(string $username, array $params = ['status', 'sort', 'sort_order'])
 * @method mixed label(string $label_id)
 * @method mixed labelReleases(string $label_id, array $params = ['page', 'per_page'])
 * @method mixed list(string $list_id)
 * @method mixed lists(string $username)
 * @method mixed marketplaceCreateListing($body = null)
 * @method mixed marketplaceFee(string $price)
 * @method mixed marketplaceFeeCurrency(string $price, string $currency)
 * @method mixed marketplaceListing(string $listing_id, array $params = ['curr_abbr'])
 * @method mixed marketplaceOrder(string $order_id)
 * @method mixed marketplaceOrderAddMessage(string $order_id, $body = null)
 * @method mixed marketplaceOrderMessages(string $order_id)
 * @method mixed marketplaceOrders(array $params = ['status', 'sort', 'sort_order'])
 * @method mixed marketplaceRemoveListing(string $listing_id)
 * @method mixed marketplaceUpdateListing(string $listing_id, array $params = ['curr_abbr'], $body = null)
 * @method mixed marketplaceUpdateOrder(string $order_id, $body = null)
 * @method mixed master(string $master_id)
 * @method mixed masterVersions(string $master_id, array $params = ['page', 'per_page'])
 * @method mixed profile(string $username)
 * @method mixed profileUpdate(string $username, $body = null)
 * @method mixed release(string $release_id, array $params = ['curr_abbr'])
 * @method mixed releasePriceSuggestion(string $release_id)
 * @method mixed releaseRating(string $release_id)
 * @method mixed releaseRemoveUserRating(string $release_id, string $username)
 * @method mixed releaseUpdateUserRating(string $release_id, string $username, $body = null)
 * @method mixed releaseUserRating(string $release_id, string $username)
 * @method mixed search(array $params = ['q', 'query', 'type', 'title', 'release_title', 'credit', 'artist', 'anv', 'label', 'genre', 'style', 'country', 'year', 'format', 'catno', 'barcode', 'track', 'submitter', 'contributor'])
 * @method mixed submissions(string $username)
 * @method mixed wantlist(string $username)
 * @method mixed wantlistAdd(string $username, string $release_id, $body = null)
 * @method mixed wantlistRemove(string $username, string $release_id)
 * @method mixed wantlistUpdate(string $username, string $release_id, $body = null)
 */
class Discogs extends OAuth1Provider{

	protected $requestTokenEndpoint = 'https://api.discogs.com/oauth/request_token';
	protected $apiURL               = 'https://api.discogs.com';
	protected $authURL              = 'https://www.discogs.com/oauth/authorize';
	protected $userRevokeURL        = 'https://www.discogs.com/settings/applications';
	protected $accessTokenEndpoint  = 'https://api.discogs.com/oauth/access_token';
	protected $apiHeaders           = ['Accept' => 'application/vnd.discogs.v2.discogs+json'];

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
