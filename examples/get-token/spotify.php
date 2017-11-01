<?php
/**
 *
 * @filesource   spotify.php
 * @created      10.07.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

require_once __DIR__.'/../bootstrap.php';

use chillerlan\OAuth\Providers\Spotify;

$scopes =  [
	Spotify::SCOPE_PLAYLIST_READ_PRIVATE,
	Spotify::SCOPE_PLAYLIST_READ_COLLABORATIVE,
	Spotify::SCOPE_PLAYLIST_MODIFY_PUBLIC,
	Spotify::SCOPE_PLAYLIST_MODIFY_PRIVATE,
	Spotify::SCOPE_USER_FOLLOW_MODIFY,
	Spotify::SCOPE_USER_FOLLOW_READ,
	Spotify::SCOPE_USER_LIBRARY_READ,
	Spotify::SCOPE_USER_LIBRARY_MODIFY,
	Spotify::SCOPE_USER_TOP_READ,
	Spotify::SCOPE_USER_READ_PRIVATE,
	Spotify::SCOPE_USER_READ_BIRTHDATE,
	Spotify::SCOPE_USER_READ_EMAIL,
	Spotify::SCOPE_STREAMING,
	Spotify::SCOPE_USER_READ_PLAYBACK_STATE,
	Spotify::SCOPE_USER_MODIFY_PLAYBACK_STATE,
	Spotify::SCOPE_USER_READ_CURRENTLY_PLAYING,
	Spotify::SCOPE_USER_READ_RECENTLY_PLAYED,
];

/** @var \chillerlan\OAuth\Providers\Spotify $provider */
$provider = getProvider('Spotify', $scopes);

if(isset($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
elseif(isset($_GET['code']) && isset($_GET['state'])){
	$token = $provider->getAccessToken($_GET['code'], $_GET['state']);

	// save the token
	saveToken($token, $provider->serviceName);
}
elseif(isset($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->me()->json,true).'</pre>';
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
