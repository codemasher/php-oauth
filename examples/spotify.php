<?php
/**
 *
 * @filesource   spotify.php
 * @created      25.12.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthExamples;

use chillerlan\Database\{
	Database, DatabaseOptionsTrait, Drivers\MySQLiDrv
};
use chillerlan\HTTP\CurlClient;
use chillerlan\OAuth\{
	OAuthOptions, Providers\Spotify, Storage\DBTokenStorage
};
use chillerlan\Traits\DotEnv;

ini_set('date.timezone', 'Europe/Amsterdam');

require_once __DIR__.'/../vendor/autoload.php';

$env = (new DotEnv(__DIR__.'/../config', '.env'))->load();

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
	'ca_info'          => __DIR__.'/../config/cacert.pem',
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


// fetch the artists i'm following
$response = $spotify->meFollowing(['type' => 'artist', 'limit' => 50])->json;
$artists  = [];

while(true){

	foreach($response->artists->items as $artist){
		$artists[] = $artist->id;
	}

	if(empty($response->artists->cursors->after)){
		break;
	}

	$response = $spotify->meFollowing([
		'type'  => 'artist',
		'limit' => 50,
		'after' => $response->artists->cursors->after
	])->json;
}

// now crawl the artists' new releases
$newReleases = [];
$since       = mktime(0, 0, 0, 1, 1, 2017);
$until       = mktime(0, 0, 0, 12, 31, 2017);

foreach($artists as $id){
	$response = $spotify->artistAlbums($id)->json;

	if(isset($response->items)){

		foreach($response->items as $album){
			$rdate = strtotime($album->release_date);

			if($album->release_date_precision === 'day' && $rdate >= $since && $rdate <= $until){
				$newReleases[(int)date('Y', $rdate)][(int)date('m', $rdate)][(int)date('d', $rdate)][$album->id] = // $album;
					implode(', ', array_column($album->artists, 'name')).' ['.$album->name.']';
			}

		}

	}

}

// sort the array by release date (descending)
krsort($newReleases);

foreach($newReleases as $y => $year){
	krsort($newReleases[$y]);

	foreach($year as $m => $month){
		krsort($newReleases[$y][$m]);
	}
}

echo 'new releases by the artists i\'m following on spotify, from '.date('d.m.Y', $since).' until '.date('d.m.Y', $until).PHP_EOL.PHP_EOL;
print_r($newReleases);
