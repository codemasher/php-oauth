<?php
/**
 * @filesource   instagram.php
 * @created      10.07.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

use chillerlan\OAuth\Providers\Instagram;

require_once __DIR__.'/../bootstrap.php';

$scopes = [
	Instagram::SCOPE_BASIC,
	Instagram::SCOPE_COMMENTS,
	Instagram::SCOPE_RELATIONSHIPS,
	Instagram::SCOPE_LIKES,
	Instagram::SCOPE_PUBLIC_CONTENT,
	Instagram::SCOPE_FOLLOWER_LIST,
];

/** @var \chillerlan\OAuth\Providers\Instagram $provider */
$provider = getProvider('Instagram', $scopes);

if(!empty($_GET['code'])){
	$token = $provider->getAccessToken($_GET['code'], isset($_GET['state']) ? $_GET['state'] : null);

	// save the token & redirect
	saveToken($token, $provider->serviceName);
}
elseif(!empty($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->request('/users/self')->json,true).'</pre>';
}
elseif(!empty($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
