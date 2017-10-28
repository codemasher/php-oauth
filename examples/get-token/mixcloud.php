<?php
/**
 *
 * @filesource   mixcloud.php
 * @created      28.10.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

require_once __DIR__.'/../bootstrap.php';

/** @var \chillerlan\OAuth\Providers\Mixcloud $provider */
$provider = getProvider('Mixcloud', []);

if(isset($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
elseif(isset($_GET['code'])){
	$token = $provider->getAccessToken($_GET['code']);

	// save the token & redirect
	saveToken($token, $provider->serviceName);
}
elseif(isset($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	// don't forget trailing slashes - mixcloud is picky
	echo '<pre>'.print_r($provider->request('/me/')->json,true).'</pre>';
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
