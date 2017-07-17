<?php
/**
 * @filesource   discogs.php
 * @created      10.07.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

require_once __DIR__.'/../bootstrap.php';

/** @var \chillerlan\OAuth\Providers\Discogs $provider */
$provider = getProvider('Discogs');

if(!empty($_GET['oauth_token'])){

	$token = $provider->getAccessToken(
		$_GET['oauth_token'],
		$_GET['oauth_verifier'],
		$storage->retrieveAccessToken($provider->serviceName)->requestTokenSecret
	);

	// save the token & redirect
	saveToken($token, $provider->serviceName);
}
elseif(!empty($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->request('/oauth/identity')->json,true).'</pre>';
}
elseif(!empty($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL(['oauth_token' => $provider->getRequestToken()->requestToken]));
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;




