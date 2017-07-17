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
use chillerlan\Database\Drivers\Native\MySQLiDriver;
use chillerlan\Database\Options;
use chillerlan\Database\Query\Dialects\MySQLQueryBuilder;
use chillerlan\OAuth\Storage\DBTokenStorage;
use chillerlan\OAuth\Token;
use Dotenv\Dotenv;

class DBTest extends TokenStorageTestAbstract{

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
		$db->connect();


		$this->storage = new DBTokenStorage($db, 'musicdb_token', 1);
		$this->token   = new Token(['accessToken' => 'foobar']);

	}


}
