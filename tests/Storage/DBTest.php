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

use chillerlan\Database\{
	Connection, Drivers\Native\MySQLiDriver, Options, Query\Dialects\MySQLQueryBuilder
};
use chillerlan\OAuth\{
	OAuthOptions, Storage\DBTokenStorage, Storage\TokenStorageInterface
};
use chillerlan\Traits\DotEnv;

/**
 * @property \chillerlan\OAuth\Storage\DBTokenStorage $storage
 */
class DBTest extends TokenStorageTestAbstract{

	const CFGDIR         = __DIR__.'/../../config';
	const TABLE_TOKEN    = 'storagetest';
	const TABLE_PROVIDER = 'storagetest_providers';

	/**
	 * @var \chillerlan\Traits\DotEnv
	 */
	protected $env;

	/**
	 * @var \chillerlan\Database\Connection
	 */
	protected $db;

	protected function setUp(){
		$this->env = (new DotEnv(self::CFGDIR, file_exists(self::CFGDIR.'/.env') ? '.env' : '.env_travis'))->load();

		$this->db = new Connection(new Options([
			'driver'       => MySQLiDriver::class,
			'querybuilder' => MySQLQueryBuilder::class,
			'host'         => $this->env->get('MYSQL_HOST'),
			'port'         => $this->env->get('MYSQL_PORT'),
			'database'     => $this->env->get('MYSQL_DATABASE'),
			'username'     => $this->env->get('MYSQL_USERNAME'),
			'password'     => $this->env->get('MYSQL_PASSWORD'),
		]));

		$this->options = new OAuthOptions([
			'dbTokenTable'     => self::TABLE_TOKEN,
			'dbProviderTable'  => self::TABLE_PROVIDER,
			'storageCryptoKey' => '000102030405060708090a0b0c0d0e0f101112131415161718191a1b1c1d1e1f',
			'dbUserID'         => 1,
		]);

		parent::setUp();
	}

	protected function initStorage():TokenStorageInterface{
		return new DBTokenStorage($this->options, $this->db);
	}

	/**
	 * @expectedException \chillerlan\OAuth\Storage\TokenStorageException
	 * @expectedExceptionMessage invalid table config
	 */
	public function testInvalidTable(){
		$this->options->dbTokenTable = '';
		$this->initStorage();
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
	 */
	public function testTokenUpdate(){
		$this->storage->storeAccessToken(self::SERVICE_NAME, $this->token);
		$this->storage->storeAccessToken(self::SERVICE_NAME, $this->token);

		$this->assertTrue($this->storage->hasAccessToken(self::SERVICE_NAME));
		$this->assertSame('foobar', $this->storage->retrieveAccessToken(self::SERVICE_NAME)->accessToken);
	}

}
