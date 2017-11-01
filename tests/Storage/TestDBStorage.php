<?php
/**
 * Class TestDBStorage
 *
 * @filesource   TestDBStorage.php
 * @created      01.11.2017
 * @package      chillerlan\OAuthTest\Storage
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Storage;

use chillerlan\Database\{
	Connection, Drivers\PDO\PDOMySQLDriver, Query\Dialects\MySQLQueryBuilder, Options
};
use chillerlan\OAuth\Storage\{
	DBTokenStorage, TokenStorageAbstract, TokenStorageInterface
};
use chillerlan\OAuth\Token;
use Dotenv\Dotenv;

class TestDBStorage extends TokenStorageAbstract{

	const CFGDIR         = __DIR__.'/../../config';
	const TABLE_TOKEN    = 'storagetest';
	const TABLE_PROVIDER = 'storagetest_providers';

	/**
	 * @var \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	protected $storage;

	public function __construct(){
		$env = file_exists(self::CFGDIR.'/.env') ? '.env' : '.env_travis';

		(new Dotenv(self::CFGDIR, $env))->load();

		$db = new Connection(new Options([
			'driver'       => PDOMySQLDriver::class,
			'querybuilder' => MySQLQueryBuilder::class,
			'host'         => getenv('MYSQL_HOST'),
			'port'         => getenv('MYSQL_PORT'),
			'database'     => getenv('MYSQL_DATABASE'),
			'username'     => getenv('MYSQL_USERNAME'),
			'password'     => getenv('MYSQL_PASSWORD'),
		]));

		$this->storage = new DBTokenStorage($db, self::TABLE_TOKEN, self::TABLE_PROVIDER, 1);
	}

	public function storeAccessToken(string $service, Token $token):TokenStorageInterface{
		$this->storage->storeAccessToken($service, $token);
		return $this;
	}

	public function retrieveAccessToken(string $service):Token{
		return $this->storage->retrieveAccessToken($service);
	}

	public function hasAccessToken(string $service):bool{
		return $this->storage->hasAccessToken($service);
	}

	public function clearAccessToken(string $service):TokenStorageInterface{
		$this->storage->clearAccessToken($service);

		return $this;
	}

	public function clearAllAccessTokens():TokenStorageInterface{
		$this->storage->clearAllAccessTokens();

		return $this;
	}

	public function storeAuthorizationState(string $service, string $state):TokenStorageInterface{
		$this->storage->storeAuthorizationState($service, $state);

		return $this;
	}

	public function retrieveAuthorizationState(string $service):string{
		return $this->storage->retrieveAuthorizationState($service);
	}

	public function hasAuthorizationState(string $service):bool{
		return $this->storage->hasAuthorizationState($service);
	}

	public function clearAuthorizationState(string $service):TokenStorageInterface{
		$this->storage->clearAuthorizationState($service);

		return $this;
	}

	public function clearAllAuthorizationStates():TokenStorageInterface{
		$this->storage->clearAllAuthorizationStates();

		return $this;
	}
}
