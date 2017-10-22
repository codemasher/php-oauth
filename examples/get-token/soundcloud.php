<?php
/**
 * @filesource   soundcloud.php
 * @created      22.10.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

use chillerlan\OAuth\Providers\SoundCloud;

require_once __DIR__.'/../bootstrap.php';

/** @var \chillerlan\OAuth\Providers\SoundCloud $provider */
$provider = getProvider('SoundCloud', [SoundCloud::SCOPE_NONEXPIRING]);

if(isset($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
elseif(isset($_GET['code'])){
	$token = $provider->getAccessToken($_GET['code']);

	// save the token
	saveToken($token, $provider->serviceName);
}
elseif(isset($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->request('/me.json')->json,true).'</pre>';
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
