<?php
/**
 * @filesource   instagram.php
 * @created      10.07.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

require_once __DIR__.'/../bootstrap.php';

use chillerlan\OAuth\Providers\Instagram;

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

if(isset($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
elseif(isset($_GET['code']) && isset($_GET['state'])){
	$token = $provider->getAccessToken($_GET['code'], $_GET['state']);

	// save the token & redirect
	saveToken($token, $provider->serviceName);
}
elseif(isset($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->profile('self'),true).'</pre>';
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
