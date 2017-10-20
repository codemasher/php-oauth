<?php
/**
 * @filesource   vimeo.php
 * @created      10.07.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

require_once __DIR__.'/../bootstrap.php';

use chillerlan\OAuth\Providers\Vimeo;

$scopes =  [
	Vimeo::SCOPE_PRIVATE,
	Vimeo::SCOPE_PUBLIC,
	Vimeo::SCOPE_PURCHASED,
	Vimeo::SCOPE_PURCHASE,
	Vimeo::SCOPE_CREATE,
	Vimeo::SCOPE_EDIT,
	Vimeo::SCOPE_DELETE,
	Vimeo::SCOPE_INTERACT,
	Vimeo::SCOPE_UPLOAD,
	Vimeo::SCOPE_PROMO_CODES,
	Vimeo::SCOPE_VIDEO_FILES,
];

/** @var \chillerlan\OAuth\Providers\Vimeo $provider */
$provider = getProvider('Vimeo', $scopes);

if(!empty($_GET['code'])){
	$token = $provider->getAccessToken($_GET['code'], $_GET['state'] ?? null);

	// save the token
	saveToken($token, $provider->serviceName);
}
elseif(!empty($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->request('/me')->json,true).'</pre>';
}
elseif(!empty($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
