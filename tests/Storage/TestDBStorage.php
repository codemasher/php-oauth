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
	Connection, Drivers\Native\MySQLiDriver, Drivers\PDO\PDOMySQLDriver, Options, Query\Dialects\MySQLQueryBuilder
};
use chillerlan\OAuth\{
	OAuthOptions, Token
};
use chillerlan\OAuth\Storage\{
	DBTokenStorage, TokenStorageAbstract, TokenStorageInterface
};
use chillerlan\Traits\DotEnv;

class TestDBStorage extends TokenStorageAbstract{

	const CFGDIR         = __DIR__.'/../../config';
	const TABLE_TOKEN    = 'storagetest';
	const TABLE_PROVIDER = 'storagetest_providers';

	/**
	 * @var \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	protected $storage;

	public function __construct(){

		$options                   = new OAuthOptions;
		$options->dbTokenTable     = self::TABLE_TOKEN;
		$options->dbProviderTable  = self::TABLE_PROVIDER;
		$options->storageCryptoKey = '000102030405060708090a0b0c0d0e0f101112131415161718191a1b1c1d1e1f';
		$options->dbUserID         = 1;

		parent::__construct($options);

		$env = (new DotEnv(self::CFGDIR, file_exists(self::CFGDIR.'/.env') ? '.env' : '.env_travis'))->load();

		$db = new Connection(new Options([
			'driver'       => MySQLiDriver::class,
			'querybuilder' => MySQLQueryBuilder::class,
			'host'         => $env->get('MYSQL_HOST'),
			'port'         => $env->get('MYSQL_PORT'),
			'database'     => $env->get('MYSQL_DATABASE'),
			'username'     => $env->get('MYSQL_USERNAME'),
			'password'     => $env->get('MYSQL_PASSWORD'),
		]));

		$this->storage = new DBTokenStorage($this->options, $db);
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
