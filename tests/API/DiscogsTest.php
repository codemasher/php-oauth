<?php
/**
 * Class DiscogsTest
 *
 * @filesource   DiscogsTest.php
 * @created      10.07.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\Discogs;

/**
 * Discogs API test & usage examples
 *
 * @todo
 *
 * marketplaceCreateListing
 * marketplaceListing
 * marketplaceOrder
 * marketplaceOrderAddMessage
 * marketplaceOrderMessages
 * marketplaceOrders
 * marketplaceRemoveListing
 * marketplaceUpdateListing
 * marketplaceUpdateOrder
 *
 *
 * @property \chillerlan\OAuth\Providers\Discogs $provider
 */
class DiscogsTest extends APITestAbstract{

	const USER = '<DISCOGS_USERNAME>'; // @todo: change this to your username

	protected $providerClass = Discogs::class;
	protected $envvar        = 'DISCOGS';

	public function testIdentity(){
		$this->response = $this->provider->identity();
		$this->assertSame(self::USER, $this->response->json->username);
	}

	public function testProfile(){
		$this->response = $this->provider->profile(self::USER);
		$this->assertSame(self::USER, $this->response->json->username);
#		$this->provider->profileUpdate(self::USER, ['location' => 'new new york']);
	}

	/**
	 *
	 * // label, artist, title, catno, format, rating, added, year
	 * @return array
	 */
	public function paginatedEndpointDataProvider(){
		return [
			['artistReleases', ['198669'], 'releases'],
			['collectionRelease', [self::USER, '10149101'], 'releases'],
			['contributions', [self::USER, ['sort' => 'artist', 'sort_order' => 'desc']], 'contributions'],
			['inventory', [self::USER, ['sort' => 'artist', 'sort_order' => 'desc']], 'listings'],
			['labelReleases', ['800623', ['page' => 1, 'per_page' => 10]], 'releases'],
			['lists', [self::USER], 'lists'],
			['masterVersions', ['152693'], 'versions'],
			['submissions', [self::USER], 'submissions'],
		];
	}

	/**
	 * @dataProvider paginatedEndpointDataProvider
	 *
	 * @param $method
	 * @param $params
	 * @param $field
	 */
	public function testPaginatedEndpoint($method, $params, $field){
		$this->response = $this->provider->{$method}(...$params);
		$this->assertTrue(isset($this->response->json->pagination->items));
		$this->assertTrue(isset($this->response->json->{$field}));
	}

	public function endpointDataProvider(){
		return [
			['artist', ['198669'], 'id'],
			['collectionFields', [self::USER], 'fields'],
			['collectionFolders', [self::USER], 'folders'],
			['collectionValue', [self::USER], 'median'],
			['label', ['800623'], 'id'],
			['list', ['198961'], 'items'],
			['marketplaceFee', ['10.00'], 'currency'],
			['marketplaceFeeCurrency', ['10.00', 'EUR'], 'currency'],
			['master', ['152693'], 'id'],
			['releasePriceSuggestion', ['2039886'], 'Mint (M)'],
			['releaseRating', ['10149101'], 'release_id'],
			['releaseUserRating', ['10149101', self::USER], 'release_id'],
		];
	}

	/**
	 * @dataProvider endpointDataProvider
	 *
	 * @param $method
	 * @param $params
	 * @param $field
	 */
	public function testEndpoints($method, $params, $field){
		$this->response = $this->provider->{$method}(...$params);
		$this->assertTrue(isset($this->response->json->{$field}));
	}

	public function testCollection(){
		$name = 'test_'.md5(microtime(true));
		$release_id = 10149101; // Helium - The Dirt Of Luck RM
		$this->response = $this->provider->collectionCreateFolder(self::USER, ['name' => $name]);
		$folder_id = $this->response->json->id;
		$this->assertSame($name, $this->response->json->name);

		$this->response = $this->provider->collectionUpdateFolder(self::USER, $folder_id, ['name' => 'testy'.$name]);
		$this->assertSame('testy'.$name, $this->response->json->name);

		$this->response = $this->provider->collectionFolder(self::USER, $folder_id);
		$this->assertSame(0, $this->response->json->count);
		$this->assertSame($folder_id, $this->response->json->id);

		$this->response = $this->provider->collectionFolderAddRelease(self::USER, $folder_id, $release_id);
		$this->assertSame(201, $this->response->headers->statuscode);
		$instance_id = $this->response->json->instance_id;

		$this->response = $this->provider->collectionFolderRateRelease(self::USER, $folder_id, $release_id, $instance_id, ['rating' => 5]);
		$this->assertSame(204, $this->response->headers->statuscode);

		$this->response = $this->provider->collectionFolderReleases(self::USER, $folder_id);
		$release_item = $this->response->json->releases[0];
		$this->assertSame($instance_id, $release_item->instance_id);
		$this->assertSame($folder_id, $release_item->folder_id);
		$this->assertSame($release_id, $release_item->id);
		$this->assertSame(5, $release_item->rating);

		$this->response = $this->provider->collectionFolderUpdateReleaseField(self::USER, $folder_id, $release_id, $instance_id, '3', ['value' => 'test']);
		$this->assertSame(204, $this->response->headers->statuscode);

		$this->response = $this->provider->collectionFolderRemoveRelease(self::USER, $folder_id, $release_id, $instance_id);
		$this->assertSame(204, $this->response->headers->statuscode);

		$this->response =$this->provider->collectionDeleteFolder(self::USER, $folder_id);
		$this->assertSame(204, $this->response->headers->statuscode);
	}

	public function testWantlist(){
		// fetch the most recently added wantlist item
		$params = ['page' => 1, 'per_page' => 1, 'sort' => 'added', 'sort_order' => 'desc'];
		$this->response = $this->provider->wantlist(self::USER, $params);
		$id = $this->response->json->wants[0]->id;

		// remove it
		$this->response = $this->provider->wantlistRemove(self::USER, $id);
		$this->assertSame(204, $this->response->headers->statuscode);

		// re-add
		$this->response = $this->provider->wantlistAdd(self::USER, $id, ['notes' => 'test', 'rating' => 3]);
		$this->assertSame('test', $this->response->json->notes);

		// verify
		$this->response = $this->provider->wantlist(self::USER, $params);
		$this->assertSame($id, $this->response->json->wants[0]->id);

		// edit
		$this->response = $this->provider->wantlistUpdate(self::USER, $id, ['notes' => 'testytest', 'rating' => 5]);
		$this->assertSame('testytest', $this->response->json->notes);
		$this->assertSame(5, $this->response->json->rating);
	}

	public function testRelease(){
		$release_id = 10298211; // Helium - The Magic City RM

		$this->response = $this->provider->release($release_id);
		$this->assertSame(2017, $this->response->json->year);
		$this->assertSame($release_id, $this->response->json->id);

		$this->response = $this->provider->releaseRemoveUserRating($release_id, self::USER);
		$this->assertSame(204, $this->response->headers->statuscode);

		$this->response = $this->provider->releaseUpdateUserRating($release_id, self::USER, ['rating' => 5]);
		$this->assertSame(201, $this->response->headers->statuscode);
		$this->assertSame($release_id, $this->response->json->release_id);

		$this->response = $this->provider->releaseUserRating($release_id, self::USER);
		$this->assertSame(5, $this->response->json->rating);
	}

}
