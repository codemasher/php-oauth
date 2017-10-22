<?php
/**
 *
 * @filesource   musicbrainz.php
 * @created      22.10.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

use chillerlan\OAuth\Providers\MusicBrainz;

require_once __DIR__.'/../bootstrap.php';

$scopes = [
	MusicBrainz::SCOPE_PROFILE,
	MusicBrainz::SCOPE_EMAIL,
	MusicBrainz::SCOPE_TAG,
	MusicBrainz::SCOPE_RATING,
	MusicBrainz::SCOPE_COLLECTION,
	MusicBrainz::SCOPE_SUBMIT_ISRC,
	MusicBrainz::SCOPE_SUBMIT_BARCODE,
];

/** @var \chillerlan\OAuth\Providers\MusicBrainz $provider */
$provider = getProvider('MusicBrainz', $scopes);

if(isset($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
elseif(isset($_GET['code']) && isset($_GET['state'])){
	$token = $provider->getAccessToken($_GET['code'], $_GET['state']);

	// save the token
	saveToken($token, $provider->serviceName);
}
elseif(isset($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->request('/artist/e36e78eb-3ace-4acd-882c-16789e700ab7', ['inc' => 'url-rels annotation'])->json,true).'</pre>';
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
