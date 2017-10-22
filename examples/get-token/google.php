<?php
/**
 * @filesource   google.php
 * @created      22.10.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

use chillerlan\OAuth\Providers\Google;

require_once __DIR__.'/../bootstrap.php';

$scopes = [
	Google::SCOPE_EMAIL,
	Google::SCOPE_PROFILE,
	Google::SCOPE_YOUTUBE,
	Google::SCOPE_YOUTUBE_GDATA,
];

/** @var \chillerlan\OAuth\Providers\Google $provider */
$provider = getProvider('Google', $scopes);

if(isset($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL(['access_type' => 'online']));
}
elseif(isset($_GET['code']) && isset($_GET['state'])){
	$token = $provider->getAccessToken($_GET['code'], $_GET['state']);

	// save the token & redirect
	saveToken($token, $provider->serviceName);
}
elseif(isset($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->request('/userinfo/v2/me')->json,true).'</pre>';
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
