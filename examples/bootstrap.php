<?php
/**
 * @filesource   bootstrap.php
 * @created      10.07.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

use chillerlan\OAuth\{
	OAuthOptions, HTTP\CurlClient, Storage\SessionTokenStorage, Token
};
use chillerlan\Traits\DotEnv;

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('date.timezone', 'Europe/Amsterdam');

require_once __DIR__.'/../vendor/autoload.php';

(new DotEnv(__DIR__.'/../config', '.env'))->load();

$storage = new SessionTokenStorage;

/**
 * @param string $name
 * @param array  $scopes
 *
 * @return mixed
 */
function getProvider(string $name, array $scopes = []){
	global $storage;

	$envvar = strtoupper($name);
	$provider = '\\chillerlan\\OAuth\\Providers\\'.$name;

	return new $provider(
		new CurlClient([
			CURLOPT_CAINFO => __DIR__.'/../config/cacert.pem',
			CURLOPT_USERAGENT => 'chillerlan-php-oauth-test',
		]),
		$storage,
		new OAuthOptions([
			'key'         => $_ENV[$envvar.'_KEY'],
			'secret'      => $_ENV[$envvar.'_SECRET'],
			'callbackURL' => $_ENV[$envvar.'_CALLBACK_URL'],
		]),
		$scopes
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
