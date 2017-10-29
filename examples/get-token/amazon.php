<?php
/**
 *
 * @filesource   amazon.php
 * @created      29.10.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

require_once __DIR__.'/../bootstrap.php';

use chillerlan\OAuth\Providers\Amazon;

$scopes =  [
	Amazon::SCOPE_PROFILE,
	Amazon::SCOPE_PROFILE_USER_ID,
	Amazon::SCOPE_POSTAL_CODE,
];

/** @var \chillerlan\OAuth\Providers\Amazon $provider */
$provider = getProvider('Amazon', $scopes);

if(isset($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
elseif(isset($_GET['code']) && isset($_GET['state'])){
	$token = $provider->getAccessToken($_GET['code'], $_GET['state']);

	// save the token
	saveToken($token, $provider->serviceName);
}
elseif(isset($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->request('/user/profile')->json,true).'</pre>';
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
