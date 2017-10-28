<?php
/**
 *
 * @filesource   deezer.php
 * @created      28.10.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

require_once __DIR__.'/../bootstrap.php';

use chillerlan\OAuth\Providers\Deezer;

$scopes = [
	Deezer::SCOPE_BASIC,
	Deezer::SCOPE_EMAIL,
	Deezer::SCOPE_OFFLINE_ACCESS,
	Deezer::SCOPE_MANAGE_LIBRARY,
	Deezer::SCOPE_MANAGE_COMMUNITY,
	Deezer::SCOPE_DELETE_LIBRARY,
	Deezer::SCOPE_LISTENING_HISTORY,
];

/** @var \chillerlan\OAuth\Providers\Deezer $provider */
$provider = getProvider('Deezer', $scopes);

if(isset($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
elseif(isset($_GET['code']) && isset($_GET['state'])){
	$token = $provider->getAccessToken($_GET['code'], $_GET['state']);

	// save the token & redirect
	saveToken($token, $provider->serviceName);
}
elseif(isset($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->request('/user/me')->json,true).'</pre>';
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
