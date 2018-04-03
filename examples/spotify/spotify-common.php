<?php
/**
 * @filesource   spotify-common.php
 * @created      04.04.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\OAuthExamples\Spotify;

use chillerlan\Database\{
	Database, DatabaseOptionsTrait, Drivers\MySQLiDrv
};
use chillerlan\HTTP\CurlClient;
use chillerlan\OAuth\{
	OAuthOptions, Providers\Spotify, Storage\DBTokenStorage
};
use chillerlan\Traits\DotEnv;

ini_set('date.timezone', 'Europe/Amsterdam');

require_once __DIR__.'/../../vendor/autoload.php';

$env = (new DotEnv(__DIR__.'/../../config', '.env'))->load();

$options = [
	// OAuthOptions
	'key'              => $env->get('SPOTIFY_KEY'),
	'secret'           => $env->get('SPOTIFY_SECRET'),
	'callbackURL'      => $env->get('SPOTIFY_CALLBACK_URL'),
	'dbUserID'         => 1,
	'dbTokenTable'     => 'storagetest',
	'dbProviderTable'  => 'storagetest_providers',
	'storageCryptoKey' => '000102030405060708090a0b0c0d0e0f101112131415161718191a1b1c1d1e1f',
	'tokenAutoRefresh' => true,

	// DatabaseOptions
	'driver'           => MySQLiDrv::class,
	'host'             => $env->get('MYSQL_HOST'),
	'port'             => $env->get('MYSQL_PORT'),
	'database'         => $env->get('MYSQL_DATABASE'),
	'username'         => $env->get('MYSQL_USERNAME'),
	'password'         => $env->get('MYSQL_PASSWORD'),

	// HTTPOptions
	'ca_info'          => __DIR__.'/../../config/cacert.pem',
	'userAgent'        => 'chillerlanPhpOAuth/2.0.0 +https://github.com/codemasher/php-oauth',
];

$options = new class($options) extends OAuthOptions{
	use DatabaseOptionsTrait;
};

$db      = new Database($options);
$storage = new DBTokenStorage($options, $db);

// import a token to the database if needed
#$token = unserialize(file_get_contents(__DIR__.'/../tokenstorage/Spotify.token'));
#$storage->storeAccessToken('Spotify', $token);

$spotify = new Spotify(new CurlClient($options), $storage, $options);




