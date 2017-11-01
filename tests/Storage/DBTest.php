<?php
/**
 *
 * @filesource   DBTest.php
 * @created      11.07.2016
 * @package      chillerlan\OAuthTest\Storage
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2016 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Storage;

class DBTest extends TokenStorageTestAbstract{

	protected $FQCN = TestDBStorage::class;

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage unknown service
	 */
	public function testStoreAccessTokenUnkownServiceException(){
		$this->storage->storeAccessToken('foo', $this->token);
	}

}
