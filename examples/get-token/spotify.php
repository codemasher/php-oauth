<?php
/**
 *
 * @filesource   spotify.php
 * @created      10.07.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

use chillerlan\OAuth\Providers\Spotify;

require_once __DIR__.'/../bootstrap.php';

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

if(!empty($_GET['code'])){
	$token = $provider->getAccessToken($_GET['code']);

	// save the token
	saveToken($token, $provider->serviceName);
}
elseif(!empty($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->request('/me')->json,true).'</pre>';
}
elseif(!empty($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;