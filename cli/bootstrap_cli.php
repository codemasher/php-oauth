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
use chillerlan\Traits\DotEnv;

const CFGDIR = __DIR__.'/../config';

$env = (new DotEnv(CFGDIR, file_exists(CFGDIR.'/.env') ? '.env' : '.env_travis'))->load();

$db = new Connection(new Options([
	'driver'       => MySQLiDriver::class,
	'querybuilder' => MySQLQueryBuilder::class,
	'host'         => $env->get('MYSQL_HOST'),
	'port'         => $env->get('MYSQL_PORT'),
	'database'     => $env->get('MYSQL_DATABASE'),
	'username'     => $env->get('MYSQL_USERNAME'),
	'password'     => $env->get('MYSQL_PASSWORD'),
]));



