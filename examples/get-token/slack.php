<?php
/**
 *
 * @filesource   slack.php
 * @created      28.10.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

require_once __DIR__.'/../bootstrap.php';

use chillerlan\OAuth\Providers\Slack;

$scopes = [
	Slack::SCOPE_IDENTITY_AVATAR,
	Slack::SCOPE_IDENTITY_BASIC,
	Slack::SCOPE_IDENTITY_EMAIL,
	Slack::SCOPE_IDENTITY_TEAM,
];

/** @var \chillerlan\OAuth\Providers\Slack $provider */
$provider = getProvider('Slack', $scopes);

if(isset($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
elseif(isset($_GET['code']) && isset($_GET['state'])){
	$token = $provider->getAccessToken($_GET['code'], $_GET['state']);

	// save the token & redirect
	saveToken($token, $provider->serviceName);
}
elseif(isset($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->request('/users.identity')->json,true).'</pre>';
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
