<?php
/**
 *
 * @filesource   bootstrap_cli.php
 * @created      23.10.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthCLI;

require_once __DIR__.'/../vendor/autoload.php';

use chillerlan\Database\{
	Connection,
	Options,
	Drivers\Native\MySQLiDriver,
	Query\Dialects\MySQLQueryBuilder
};
use Dotenv\Dotenv;

(new Dotenv(__DIR__.'/../config', '.env'))->load();

$db = new Connection(new Options([
	'driver'       => MySQLiDriver::class,
	'querybuilder' => MySQLQueryBuilder::class,
	'host'         => getenv('MYSQL_HOST'),
	'port'         => getenv('MYSQL_PORT'),
	'database'     => getenv('MYSQL_DATABASE'),
	'username'     => getenv('MYSQL_USERNAME'),
	'password'     => getenv('MYSQL_PASSWORD'),
]));



