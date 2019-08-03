<?php
/**
 * Class DBStorageTestAbstract
 *
 * @filesource   DBStorageTestAbstract.php
 * @created      31.07.2019
 * @package      chillerlan\OAuthAppTest\Storage
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\OAuthAppTest\Storage;

use chillerlan\Database\Database;
use chillerlan\Database\Drivers\MySQLiDrv;
use chillerlan\DotEnv\DotEnv;
use chillerlan\OAuth\Storage\OAuthStorageException;
use chillerlan\OAuthApp\OAuthAppOptions;
use chillerlan\OAuthApp\Storage\DBStorage;
use chillerlan\OAuthTest\OAuthTestLogger;
use chillerlan\OAuthTest\Storage\StorageTestAbstract;
use chillerlan\SimpleCache\MemoryCache;

abstract class DBStorageTestAbstract extends StorageTestAbstract{

	protected $tsn = 'Spotify'; // a service name from the provider table

	protected $CFGDIR = __DIR__.'/../../config';
	/** @var \chillerlan\OAuthApp\OAuthAppOptions */
	protected $options;
	/** @var \chillerlan\OAuthTest\OAuthTestLogger */
	protected $logger;
	/** @var \chillerlan\Database\Database */
	protected $db;

	protected function setUp():void{
		parent::setUp();

		$env = (new DotEnv($this->CFGDIR, file_exists($this->CFGDIR.'/.env') ? '.env' : '.env_travis'))->load();

		$options = [
			// OAuthOptions
			'db_table_provider' => 'oauth_test_providers',
			'db_table_token'    => 'oauth_test_tokens',
			'db_user_id'        => 1,
			// DatabaseOptions
			'driver'            => MySQLiDrv::class,
			'host'              => $env->DB_HOST,
			'port'              => $env->DB_PORT,
			'socket'            => $env->DB_SOCKET,
			'database'          => $env->DB_DATABASE,
			'username'          => $env->DB_USERNAME,
			'password'          => $env->DB_PASSWORD,
		];

		$this->options = new OAuthAppOptions($options);
		$this->logger  = new OAuthTestLogger('debug');
		$this->db      = new Database($this->options, new MemoryCache, $this->logger);
	}

	public function testStoreTokenUnknownServiceException(){
		$this->expectException(OAuthStorageException::class);
		$this->expectExceptionMessage('unknown service');

		$this->storage->storeAccessToken('foo', $this->token);
	}

	public function testConstructWithInvalidTable(){
		$this->expectException(OAuthStorageException::class);
		$this->expectExceptionMessage('invalid table config');

		unset($this->options->db_table_token, $this->options->db_table_provider);

		new DBStorage($this->db, $this->options);
	}

}
