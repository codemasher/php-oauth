<?php
/**
 * @filesource   twitter.php
 * @created      20.10.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

use chillerlan\OAuth\Providers\Flickr;

require_once __DIR__.'/../bootstrap.php';

/** @var \chillerlan\OAuth\Providers\Flickr $provider */
$provider = getProvider('Flickr');

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
	echo '<pre>'.print_r($provider->request('flickr.test.login')->json,true).'</pre>';
}
elseif(!empty($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL([
		'oauth_token' => $provider->getRequestToken()->requestToken,
		'perms' => Flickr::PERM_DELETE,
	]));
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
