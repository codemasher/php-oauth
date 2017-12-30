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

use chillerlan\Database\Connection;
use chillerlan\Database\Drivers\PDO\PDOMySQLDriver;
use chillerlan\Database\Options;
use chillerlan\Database\Query\Dialects\MySQLQueryBuilder;
use chillerlan\OAuth\OAuthOptions;
use chillerlan\OAuth\Storage\DBTokenStorage;

class DBTest extends TokenStorageTestAbstract{

	protected $FQCN = TestDBStorage::class;

	/**
	 * @expectedException \chillerlan\OAuth\Storage\TokenStorageException
	 * @expectedExceptionMessage invalid table config
	 */
	public function testInvalidTable(){
		new DBTokenStorage(new OAuthOptions, new Connection(new Options(['driver' => PDOMySQLDriver::class, 'querybuilder' => MySQLQueryBuilder::class])),  1);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Storage\TokenStorageException
	 * @expectedExceptionMessage unknown service
	 */
	public function testStoreAccessTokenUnkownServiceException(){
		$this->storage->storeAccessToken('foo', $this->token);
	}

	/**
	 * coverage
	 * @runInSeparateProcess
	 */
	public function testTokenUpdate(){
		$this->storage->storeAccessToken(self::SERVICE_NAME, $this->token);
		$this->storage->storeAccessToken(self::SERVICE_NAME, $this->token);

		$this->assertTrue($this->storage->hasAccessToken(self::SERVICE_NAME));
		$this->assertSame('foobar', $this->storage->retrieveAccessToken(self::SERVICE_NAME)->accessToken);

	}


}
