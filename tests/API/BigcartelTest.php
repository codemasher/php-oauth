<?php
/**
 * Class BigcartelTest
 *
 * @filesource   BigcartelTest.php
 * @created      31.10.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\Bigcartel;

class BigcartelTest extends APITestAbstract{

	protected $providerClass = Bigcartel::class;
	protected $envvar        = 'BIGCARTEL';

	/**
	 * @var int
	 */
	protected $account_id;

	/**
	 * @var \chillerlan\OAuth\Providers\Bigcartel
	 */
	protected $provider;

	protected function setUp(){
		parent::setUp();

		$token            = $this->storage->retrieveAccessToken($this->provider->serviceName);
		$this->account_id = $token->extraParams['account_id'];
	}

	public function testAccount(){
		$this->response = $this->provider->account();
		$this->assertSame($this->account_id, (int)$this->response->json->data[0]->id);
	}

	public function testGetAccount(){
		$this->response = $this->provider->getAccount($this->account_id);
		$this->assertSame($this->account_id, (int)$this->response->json->data->id);
	}

	public function testArtists(){
		$this->response = $this->provider->getArtists($this->account_id);
		$this->assertSame('account.artists-disabled', $this->response->json->errors[0]->code);
	}

	public function testCategories(){
		// undocumented -> https://developers.bigcartel.com/api/v1#status-codes
		// HTTP/409 Conflict - the supplied body doesn't match the expected format

		// create category
		$body           = ['data' => ['type' => 'categories', 'attributes' => ['name' => 'test']]];
		$this->response = $this->provider->createCategory($this->account_id, $body);
		$this->assertSame(201, $this->response->headers->statuscode);

		// categories list
		$this->response = $this->provider->getCategories($this->account_id);
		$cat_id         = $this->response->json->data[0]->id;
		$this->assertSame('test', $this->response->json->data[0]->attributes->name);

		// category item
		$this->response = $this->provider->getCategory($this->account_id, $cat_id);
		$this->assertSame($cat_id, $this->response->json->data->id);
		$this->assertSame('test', $this->response->json->data->attributes->name);

		//update
		$body           = ['data' => ['id' => $cat_id, 'type' => 'categories', 'attributes' => ['name' => 'updatetest']]];
		$this->response = $this->provider->updateCategory($this->account_id, $cat_id, $body);
		$this->assertSame(200, $this->response->headers->statuscode);

		// verify the update
		$this->response = $this->provider->getCategory($this->account_id, $cat_id);
		$this->assertSame('updatetest', $this->response->json->data->attributes->name);

		//delete
		$this->response = $this->provider->deleteCategory($this->account_id, $cat_id);
		$this->assertSame(204, $this->response->headers->statuscode);
	}

	public function testCountries(){
		$this->response = $this->provider->countries();

		// yup, it exists!
		$this->assertGreaterThan(200, $this->response->json->meta->count);
	}

	public function testDiscounts(){
		$this->markTestSkipped();
	}

	public function testOrders(){
		$this->markTestSkipped();
	}

	public function testProducts(){
		// requires a product named "test"

		//products list
		$this->response = $this->provider->getProducts($this->account_id);
		$product_id     = $this->response->json->data[0]->id;
		$this->assertSame('test', $this->response->json->data[0]->attributes->name);

		// product item
		$this->response = $this->provider->getProduct($this->account_id, $product_id);
		$this->assertSame($product_id, $this->response->json->data->id);
		$this->assertSame('test', $this->response->json->data->attributes->name);
	}

}
