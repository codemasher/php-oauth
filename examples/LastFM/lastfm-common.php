<?php
/**
 * @filesource   lastfm-common.php
 * @created      03.08.2019
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\OAuthAppExamples\LastFM;

use chillerlan\OAuth\Core\AccessToken;
use chillerlan\OAuth\Providers\LastFM\LastFM;

$ENVVAR = 'LASTFM';
$CFGDIR = null;

/**
 * @var \Psr\Http\Client\ClientInterface $http
 * @var \chillerlan\Settings\SettingsContainerInterface $options
 * @var \chillerlan\OAuth\Storage\OAuthStorageInterface $storage
 * @var \Psr\Log\LoggerInterface $logger
 */

require_once __DIR__.'/../provider-example-common.php';

if(!$storage->hasAccessToken('LastFM')){
	$storage->storeAccessToken('LastFM', (new AccessToken)->fromJSON(file_get_contents($CFGDIR.'/LastFM.token.json')));
}

$lfm = new LastFM($http, $storage, $options, $logger);
