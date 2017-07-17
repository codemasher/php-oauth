<?php
/**
 * @filesource   lastfm.php
 * @created      10.07.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

require_once __DIR__.'/../bootstrap.php';

/** @var \chillerlan\OAuth\Providers\LastFM $provider */
$provider = getProvider('LastFM');

if(!empty($_GET['token'])){
	$token = $provider->getAccessToken($_GET['token']);

	// save the token
	saveToken($token, $provider->serviceName);
}
elseif(!empty($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->request('/', ['method' => 'user.getInfo'])->json,true).'</pre>';
}
elseif(!empty($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
