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

use chillerlan\Database\Database;
use chillerlan\Database\Drivers\MySQLiDrv;
use chillerlan\DotEnv\DotEnv;
use chillerlan\OAuthApp\OAuthAppOptions;
use chillerlan\SimpleCache\MemoryCache;
use Psr\Log\AbstractLogger;

\ini_set('date.timezone', 'Europe/Amsterdam');

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/cli_functions.php';

const DIR_CFG = __DIR__.'/../config';

$env = (new DotEnv(DIR_CFG, file_exists(DIR_CFG.'/.env') ? '.env' : '.env_travis'))->load();

$o = [
	// DatabaseOptionsTrait
	'driver'      => MySQLiDrv::class,
	'host'        => $env->DB_HOST,
	'port'        => $env->DB_PORT,
	'socket'      => $env->DB_SOCKET,
	'database'    => $env->DB_DATABASE,
	'username'    => $env->DB_USERNAME,
	'password'    => $env->DB_PASSWORD,
	// HTTPOptionsTrait
	'ca_info'     => DIR_CFG.'/cacert.pem',
	'user_agent'  => 'GW1DB/1.0.0 +https://github.com/chillerlan/php-oauth',
	// OAuthAppOptionsTrait
	'db_table_provider' => 'oauth_test_providers',
	'db_table_token'    => 'oauth_test_tokens',
];

$options = new OAuthAppOptions($o);

$logger = new class() extends AbstractLogger{
	public function log($level, $message, array $context = []){
		echo sprintf('[%s][%s] %s', date('Y-m-d H:i:s'), substr($level, 0, 4), trim($message))."\n";
	}
};

$cache = new MemoryCache;
$db    = new Database($options, $cache, $logger);

$db->connect();
