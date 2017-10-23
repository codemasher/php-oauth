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
	Connection, Options, Drivers\Native\MySQLiDriver, Query\Dialects\MySQLQueryBuilder
};

use chillerlan\OAuth\{
	Storage\DBTokenStorage, Token
};

use Dotenv\Dotenv;

class DBTest extends TokenStorageTestAbstract{

	const TABLE_TOKEN    = 'storagetest';
	const TABLE_PROVIDER = 'storagetest_providers';

	protected $FQCN = DBTokenStorage::class;

	public function setUp(){

		(new Dotenv(__DIR__.'/../../config', '.env'))->load();

		$db = new Connection(new Options([
			'driver'       => MySQLiDriver::class,
			'querybuilder' => MySQLQueryBuilder::class,
			'host'         => getenv('MYSQL_HOST'),
			'port'         => getenv('MYSQL_PORT'),
			'database'     => getenv('MYSQL_DATABASE'),
			'username'     => getenv('MYSQL_USERNAME'),
			'password'     => getenv('MYSQL_PASSWORD'),
		]));

		$this->storage = new DBTokenStorage($db, self::TABLE_TOKEN, self::TABLE_PROVIDER, 1);
		$this->token   = new Token(['accessToken' => 'foobar']);
	}

	/**
	 * @expectedException \chillerlan\OAuth\OAuthException
	 * @expectedExceptionMessage unknown service
	 */
	public function testStoreAccessTokenUnkownServiceException(){
		$this->storage->storeAccessToken('foo', $this->token);
	}

}
