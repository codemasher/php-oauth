<?php
/**
 * @filesource   twitch.php
 * @created      22.10.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

use chillerlan\OAuth\Providers\Twitch;

require_once __DIR__.'/../bootstrap.php';

/** @var \chillerlan\OAuth\Providers\Twitch $provider */
$provider = getProvider('Twitch', [Twitch::SCOPE_USER_READ]);

if(isset($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
elseif(isset($_GET['code']) && isset($_GET['state'])){
	$token = $provider->getAccessToken($_GET['code'], $_GET['state']);

	// save the token
	saveToken($token, $provider->serviceName);
}
elseif(isset($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->request('/user')->json,true).'</pre>';
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
