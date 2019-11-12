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

/**
 * @var \Psr\Http\Client\ClientInterface $http
 * @var \chillerlan\Settings\SettingsContainerInterface $options
 * @var \chillerlan\OAuth\Storage\OAuthStorageInterface $storage
 * @var \Psr\Log\LoggerInterface $logger
 */

require_once __DIR__.'/../provider-example-common.php';

if(!$storage->hasAccessToken('Spotify')){
	$storage->storeAccessToken('Spotify', (new AccessToken)->fromJSON(file_get_contents($CFGDIR.'/Spotify.token.json')));
}

$spotify = new Spotify($http, $storage, $options, $logger);
