<?php
/**
 * @filesource   discord.php
 * @created      22.10.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

require_once __DIR__.'/../bootstrap.php';

use chillerlan\OAuth\Providers\Discord;

$scopes = [
#	Discord::SCOPE_BOT,
	Discord::SCOPE_CONNECTIONS,
	Discord::SCOPE_EMAIL,
	Discord::SCOPE_IDENTIFY,
	Discord::SCOPE_GUILDS,
	Discord::SCOPE_GUILDS_JOIN,
	Discord::SCOPE_GDM_JOIN,
	Discord::SCOPE_MESSAGES_READ,
#	Discord::SCOPE_RPC,
	Discord::SCOPE_RPC_API,
	Discord::SCOPE_RPC_NOTIFICATIONS_READ,
#	Discord::SCOPE_WEBHOOK_INCOMING,
];

/** @var \chillerlan\OAuth\Providers\Discord $provider */
$provider = getProvider('Discord', $scopes);

if(isset($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
elseif(isset($_GET['code']) && isset($_GET['state'])){
	$token = $provider->getAccessToken($_GET['code'], $_GET['state']);

	// save the token & redirect
	saveToken($token, $provider->serviceName);
}
elseif(isset($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	echo '<pre>'.print_r($provider->request('/users/@me')->json,true).'</pre>';
}
else{
	echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';
}

exit;
