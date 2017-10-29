# chillerlan/php-oauth

[![version][packagist-badge]][packagist]
[![license][license-badge]][license]
[![Travis][travis-badge]][travis]
[![Coverage][coverage-badge]][coverage]
[![Scrunitizer][scrutinizer-badge]][scrutinizer]
[![Code Climate][codeclimate-badge]][codeclimate]
[![packagist][downloads-badge]][downloads]

[packagist-badge]: https://img.shields.io/packagist/v/chillerlan/php-oauth.svg
[packagist]: https://packagist.org/packages/chillerlan/php-oauth
[license-badge]: https://img.shields.io/packagist/l/chillerlan/php-oauth.svg
[license]: https://github.com/codemasher/php-oauth/blob/master/LICENSE
[travis-badge]: https://img.shields.io/travis/codemasher/php-oauth.svg
[travis]: https://travis-ci.org/codemasher/php-oauth
[coverage-badge]: https://img.shields.io/codecov/c/github/codemasher/php-oauth.svg
[coverage]: https://codecov.io/github/codemasher/php-oauth
[scrutinizer-badge]: https://img.shields.io/scrutinizer/g/codemasher/php-oauth.svg
[scrutinizer]: https://scrutinizer-ci.com/g/codemasher/php-oauth
[codeclimate-badge]: https://img.shields.io/codeclimate/github/codemasher/php-oauth.svg
[codeclimate]: https://codeclimate.com/github/codemasher/php-oauth
[downloads-badge]: https://img.shields.io/packagist/dt/chillerlan/php-oauth.svg
[downloads]: https://packagist.org/packages/chillerlan/php-oauth/stats


# Documentation

## Requirements
- PHP 7+
- cURL, PHP's stream wrapper or a HTTP client library of your choice

## Supported providers

- Oauth1
  - Discogs
  - Twitter
  - Tumblr
  - Flickr
- Oauth2
  - Amazon
  - Deezer
  - Foursquare
  - Github
  - Gitter
  - Google
  - GuildWars2 (no authentication)
  - Instagram
  - Mixcloud
  - MusicBrainz
  - Patreon
  - Slack
  - SoundCloud
  - Wordpress
  - Yahoo
- Oauth2 & client credentials
  - DeviantArt
  - Discord
  - Spotify
  - Twitch
  - Twitter2 (client credentials only)
  - Vimeo
- Native
  - Last.fm

(PR welcome!)

## Installation

Using [composer](https://getcomposer.org)

*Terminal*
```sh
composer require chillerlan/php-oauth:dev-master
```

*composer.json*
```json
{
	"require": {
		"php": ">=7.0.3",
		"chillerlan/php-oauth": "dev-master"
	}
}
```

Profit!

## Usage

### Getting started

In order to instance a provider you you'll need to init a `HTTPClientInterface`, `TokenStorageInterface` and `OAuthOptions` object first like follows:
```php
use chillerlan\OAuth\{
	Providers\<PROVIDER> as Provider,
	OAuthOptions, 
	HTTP\CurlClient, 
	Storage\SessionTokenStorage
};

// init a HTTPClientInterface
$http = new CurlClient([
	CURLOPT_CAINFO    => '/path/to/cacert.pem', // https://curl.haxx.se/ca/cacert.pem
	CURLOPT_USERAGENT => 'my-awesome-oauth-app',
]);

// init a TokenStorageInterface
// a persistent storage is required for authentication!
$storage = new SessionTokenStorage;

// set OAuthOptions
$options = new OAuthOptions([
	'key'         => '<API_KEY>',
	'secret'      => '<API_SECRET>',
	'callbackURL' => '<API_CALLBACK_URL>',
]);

// optional scopes for OAuth2 providers
$scopes = [
	Provider::SCOPE_WHATEVER,
];

// init and use the OAuthInterface
$provider = new Provider($http, $storage, $options, $scopes);
```

#### Authentication

The application flow may differ slightly depending on the provider; there's a working authentication example for each supported provider in the 
[examples folder](https://github.com/codemasher/php-oauth/tree/master/examples/get-token).

```php
// step 1 (optional): display a login link
echo '<a href="?login='.$provider->serviceName.'">Login with '.$provider->serviceName.'!</a>';

// step 2: redirect to the provider's login screen
if(isset($_GET['login']) && $_GET['login'] === $provider->serviceName){
	header('Location: '.$provider->getAuthURL());
}
```

#### OAuth1
```php
// step 3: receive the access token
elseif(isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])){
	$token = $provider->getAccessToken($_GET['oauth_token'], $_GET['oauth_verifier']);

	// save the token (only required when using a non-persistent storage)
	// do whatever you need to do, then redirect to step 4
	header('Location: ?granted='.$provider->serviceName);
}
```

#### OAuth2
```php
// step 3: receive the access token
elseif(isset($_GET['code'])){
	// usage of the <state> parameter depends on the provider
	$token = $provider->getAccessToken($_GET['code'], $_GET['state'] ?? null);

	// save & redirect
	header('Location: ?granted='.$provider->serviceName);
}
```

#### Auth granted
After receiving the access token, go on and verify it then use the API.
```php
// step 4: verify the token and use the API
elseif(isset($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	$response = $provider->doStuff();

	echo '<pre>'.print_r($response,true).'</pre>';
}
```

### The built-in API client

The API client is a very minimal implementation of available endpoints for the given provider, which returns the JSON responses as `\stdClass` object. Please refer to the [provider class docblocks](https://github.com/codemasher/php-oauth/tree/master/src/Providers) for method names and signatures.
The general method scheme looks as follows:

 - the method name is
   - the actual API method name if available
   - substituted from the path element names
 - `:path` elements become required parameters
 - query parameters become a `[$k => $v]` array

```php
// https://example.com/api/endpoint/:id/subendpoint/:name?param1=foo&param2=bar
$provider->endpointIdSubendpointName($id, $name, ['param1' => 'foo', 'param2' => 'bar']);
``` 

### Extensions

In order to use a provider, http client or storage, that is not yet supported, you'll need to implement the respective interfaces.

#### `HTTPClientInterface`
There's already a Guzzle client - what else do you need? (refer to the [`HTTPClientInterface` for more...](https://github.com/codemasher/php-oauth/tree/master/src/HTTP))

#### `TokenStorageInterface`

There are currently 3 different `TokenStorageInterface`, refer to these for implementation details:
- non-persistent
  - [`MemoryTokenStorage`](https://github.com/codemasher/php-oauth/blob/master/src/Storage/MemoryTokenStorage.php)
- half-persistent
  - [`SessionTokenStorage`](https://github.com/codemasher/php-oauth/blob/master/src/Storage/SessionTokenStorage.php)
- persistent
  - [`DBTokenStorage`](https://github.com/codemasher/php-oauth/blob/master/src/Storage/DBTokenStorage.php) 


#### `OAuth1Interface`
The OAuth1 implementation is close to Twitter's and *should* work for most other OAuth1 services.
```php
use chillerlan\OAuth\Providers\OAuth1Provider;

class MyOauth1Provider extends Oauth1Provider{
	
	protected $apiURL          = 'https://api.example.com';
	protected $requestTokenURL = 'https://example.com/oauth/request_token';
	protected $authURL         = 'https://example.com/oauth/authorize';
	protected $accessTokenURL  = 'https://example.com/oauth/access_token';
	
}
```

#### `OAuth2Interface`
[OAuth2 is a very straightforward mess](https://hueniverse.com/oauth-2-0-and-the-road-to-hell-8eec45921529). Please refer to your provider's docs for implementation details.
```php
use chillerlan\OAuth\Providers\OAuth2Provider;

class MyOauth2Provider extends Oauth2Provider{

	const SCOPE_WHATEVER = 'whatever';

	protected $apiURL                    = 'https://api.example.com';
	protected $authURL                   = 'https://example.com/oauth2/authorize';
	protected $accessTokenURL            = 'https://example.com/oauth2/token';
	protected $clientCredentialsTokenURL = 'https://example.com/oauth2/client_credentials';
	protected $authMethod                = self::HEADER_BEARER;
	protected $authHeaders               = ['Accept' => 'application/json'];
	protected $apiHeaders                = ['Accept' => 'application/json'];
	protected $scopesDelimiter           = ',';
	protected $accessTokenExpires        = true;  // a token refresh will be performed
	protected $csrfToken                 = false; // disables <state> parameter creation & check.
	protected $clientCredentials         = true;  // enables/allows fetching of Client Credentials Token

}
```

#### API Clients

The API client is rather a map of endpoints than a huge blob of redundant php code.
Simply place a `<providername>.json` in `/src/API`, which then will be parsed and checked against.

The JSON for `https://example.com/api/endpoint/:id/subendpoint/:name?param1=foo&param2=bar` would be
```json
{
    "endpointIdSubendpointName": {
        "path": "\/endpoint\/%1$s\/subendpoint\/%2$s",
        "method": "GET",
        "query": [
            "param1", 
            "param2"
        ],
        "path_elements": [
            "id",
            "name"
        ],
        "body": null,
        "headers": {
            "Accept": "application\/json"
        }
    }
}
```

# Disclaimer
OAuth tokens are secrets and should be treated as such. Store them in a safe place, 
[consider encryption](https://github.com/defuse/php-encryption).<br/>
I won't take responsibility for stolen auth tokens. Use at your own risk.
