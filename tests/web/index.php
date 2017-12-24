<?php
/**
 *
 * @filesource   index.php
 * @created      03.11.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\web;

use chillerlan\OAuthTest\Request\{
	TestRouter, OAuth1Request, OAuth2Request, LastFMRequest
};

require_once __DIR__.'/../../vendor/autoload.php';

$routes = array_merge(
	OAuth1Request::ROUTES,
	OAuth2Request::ROUTES,
	LastFMRequest::ROUTES
);

$router = new TestRouter($routes);

$path   = explode('?', $_SERVER['REQUEST_URI'] ?? null);
$route  = $router->dispatch($_SERVER['REQUEST_METHOD'] ?? null, $path[0]);

if($route[0] === 1){
	$json = false;

	if(isset($route[1]['headers']) && is_array($route[1]['headers'])){
		foreach($route[1]['headers'] as $header){
			$json = strpos($header, 'json') !== false;

			header($header);
		}
	}

	if(isset($route[1]['body'])){

		echo $json
			? json_encode($route[1]['body'])
			: http_build_query($route[1]['body']);

		exit;
	}

	var_dump($route, $path);
}

var_dump($route);
exit;
