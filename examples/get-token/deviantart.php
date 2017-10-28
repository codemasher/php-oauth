<?php
/**
 *
 * @filesource   deviantart.php
 * @created      27.10.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */


require_once __DIR__.'/../bootstrap.php';

use chillerlan\OAuth\Providers\DeviantArt;

$scopes = [
	DeviantArt::SCOPE_BASIC,
	DeviantArt::SCOPE_BROWSE,
];

/** @var \chillerlan\OAuth\Providers\DeviantArt $provider */
$provider = getProvider('DeviantArt', $scopes);

if(isset($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
elseif(isset($_GET['code']) && isset($_GET['state'])){
	$token = $provider->getAccessToken($_GET['code'], $_GET['state']);

	// save the token & redirect
	saveToken($token, $provider->serviceName);
}
elseif(isset($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->request('/user/whoami')->json,true).'</pre>';
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
