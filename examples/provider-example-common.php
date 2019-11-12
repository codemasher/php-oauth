<?php
/**
 * @filesource   provider-example-common.php
 * @created      26.07.2019
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\OAuthAppExamples;

use chillerlan\Database\{Database, Drivers\MySQLiDrv};
use chillerlan\OAuthApp\{OAuthAppOptions, Storage\DBStorage};
use chillerlan\SimpleCache\MemoryCache;

require_once __DIR__.'/../vendor/autoload.php';

$CFGDIR = __DIR__.'/../config';

/**
 * @var \chillerlan\DotEnv\DotEnv $env
 * @var \Psr\Log\LoggerInterface $logger
 */

require_once __DIR__.'/../vendor/chillerlan/php-oauth-core/examples/oauth-example-common.php';

$dboptions = new OAuthAppOptions([
	'driver'      => MySQLiDrv::class,
	'host'        => $env->DB_HOST,
	'port'        => $env->DB_PORT,
	'socket'      => $env->DB_SOCKET,
	'database'    => $env->DB_DATABASE,
	'username'    => $env->DB_USERNAME,
	'password'    => $env->DB_PASSWORD,

	'db_table_provider' => 'oauth_providers',
	'db_table_token'    => 'oauth_tokens',
	'db_user_id'        => 1,
	'storageEncryption' => true,
	'storageCryptoKey'  => '000102030405060708090a0b0c0d0e0f101112131415161718191a1b1c1d1e1f'
]);

$db = new Database($dboptions, new MemoryCache, $logger);
$db->connect();

$storage = new DBStorage($db, $dboptions, $logger);
