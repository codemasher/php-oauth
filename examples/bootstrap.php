<?php
/**
 * @filesource   bootstrap.php
 * @created      10.07.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

require_once __DIR__.'/../vendor/autoload.php';

use chillerlan\OAuth\{
	OAuthOptions, HTTP\TinyCurlClient, Storage\SessionTokenStorage, Token
};
use chillerlan\TinyCurl\{Request, RequestOptions};
use Dotenv\Dotenv;

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('date.timezone', 'Europe/Amsterdam');

(new Dotenv(__DIR__.'/../config', '.env'))->load();

$storage = new SessionTokenStorage;

/**
 * @param string $name
 * @param array  $scopes
 * @param bool   $stateparam
 *
 * @return mixed
 */
function getProvider(string $name, array $scopes = [], bool $stateparam = false){
	global $storage;

	$envvar = strtoupper($name);
	$provider = '\\chillerlan\\OAuth\\Providers\\'.$name;

	return new $provider(
		new TinyCurlClient(new Request(new RequestOptions(['ca_info' => __DIR__.'/../config/cacert.pem']))),
		$storage,
		new OAuthOptions([
			'key'         => getenv($envvar.'_KEY'),
			'secret'      => getenv($envvar.'_SECRET'),
			'callbackURL' => getenv($envvar.'_CALLBACK_URL'),
		]),
		$scopes,
		$stateparam
	);
}

/**
 * @param \chillerlan\OAuth\Token $token
 * @param string                  $servicename
 *
 * @throws \Exception
 */
function saveToken(Token $token, string $servicename){

	if(@file_put_contents(__DIR__.'/../tokenstorage/'.$servicename.'.token', serialize($token)) === false){
		throw new \Exception('unable to access file storage');
	}

	header('Location: ?granted='.$servicename);
}
