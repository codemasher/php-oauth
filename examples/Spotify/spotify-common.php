<?php
/**
 *
 * @filesource   spotify-common.php
 * @created      03.08.2019
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */
namespace chillerlan\OAuthAppExamples\Spotify;

use chillerlan\OAuth\Core\AccessToken;
use chillerlan\OAuth\Providers\Spotify\Spotify;

$ENVVAR = 'SPOTIFY';
$CFGDIR = null;

/** @var \chillerlan\Settings\SettingsContainerInterface $options */
$options = null;

/** @var \Psr\Log\LoggerInterface $logger */
$logger = null;

/** @var \Psr\Http\Client\ClientInterface $http */
$http = null;

/** @var \chillerlan\OAuth\Storage\OAuthStorageInterface $storage */
$storage = null;

require_once __DIR__.'/../provider-example-common.php';

if(!$storage->hasAccessToken('Spotify')){
	$storage->storeAccessToken('Spotify', (new AccessToken)->fromJSON(file_get_contents($CFGDIR.'/Spotify.token.json')));
}

$spotify = new Spotify($http, $storage, $options, $logger);
