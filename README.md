# chillerlan/php-oauth
A PHP7+ OAuth1/2 client with an integrated API wrapper, [loosely based](https://github.com/codemasher/PHPoAuthLib) on [Lusitanian/PHPoAuthLib](https://github.com/Lusitanian/PHPoAuthLib). 

[![Packagist version][packagist-badge]][packagist]
[![License][license-badge]][license]
[![Travis CI][travis-badge]][travis]
[![CodeCov][coverage-badge]][coverage]
[![Scrunitizer CI][scrutinizer-badge]][scrutinizer]
[![Gemnasium][gemnasium-badge]][gemnasium]
[![Packagist downloads][downloads-badge]][downloads]
[![PayPal donate][donate-badge]][donate]

[packagist-badge]: https://img.shields.io/packagist/v/chillerlan/php-oauth.svg?style=flat-square
[packagist]: https://packagist.org/packages/chillerlan/php-oauth
[license-badge]: https://img.shields.io/github/license/codemasher/php-oauth.svg?style=flat-square
[license]: https://github.com/codemasher/php-oauth/blob/master/LICENSE
[travis-badge]: https://img.shields.io/travis/codemasher/php-oauth.svg?style=flat-square
[travis]: https://travis-ci.org/codemasher/php-oauth
[coverage-badge]: https://img.shields.io/codecov/c/github/codemasher/php-oauth.svg?style=flat-square
[coverage]: https://codecov.io/github/codemasher/php-oauth
[scrutinizer-badge]: https://img.shields.io/scrutinizer/g/codemasher/php-oauth.svg?style=flat-square
[scrutinizer]: https://scrutinizer-ci.com/g/codemasher/php-oauth
[gemnasium-badge]: https://img.shields.io/gemnasium/codemasher/php-oauth.svg?style=flat-square
[gemnasium]: https://gemnasium.com/github.com/codemasher/php-oauth
[downloads-badge]: https://img.shields.io/packagist/dt/chillerlan/php-oauth.svg?style=flat-square
[downloads]: https://packagist.org/packages/chillerlan/php-oauth/stats
[donate-badge]: https://img.shields.io/badge/donate-paypal-ff33aa.svg?style=flat-square
[donate]: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WLYUNAT9ZTJZ4

# Documentation
## Requirements
- PHP 7.2+
- the [Sodium](http://php.net/manual/book.sodium.php) extension for token encryption
- cURL, PHP's stream wrapper or a HTTP client library of your choice

## Supported Providers

- Oauth1
  - [Discogs](https://www.discogs.com/developers/)
  - [Twitter](https://developer.twitter.com/en/docs/api-reference-index)
  - [Tumblr](https://www.tumblr.com/docs/en/api/v2)
  - [Flickr](https://www.flickr.com/services/api/)
- Oauth2
  - [Amazon](https://login.amazon.com/)
  - [Big Cartel](https://developers.bigcartel.com/api/v1)
  - [Deezer](https://developers.deezer.com/api/oauth)
  - [Foursquare](https://developer.foursquare.com/docs/)
  - [Github](https://developer.github.com/v3/)
  - [Gitter](https://developer.gitter.im/)
  - [Google](https://developers.google.com/oauthplayground/)
  - [GuildWars2](https://wiki.guildwars2.com/wiki/API:Main) (no authentication)
  - [Instagram](https://www.instagram.com/developer)
  - [Mixcloud](https://www.mixcloud.com/developers/)
  - [MusicBrainz](https://musicbrainz.org/doc/Development)
  - [Patreon](https://docs.patreon.com/)
  - [Slack](https://api.slack.com/docs/oauth)
  - [SoundCloud](https://developers.soundcloud.com/)
  - [Stripe](https://stripe.com/docs/api)
  - [Wordpress](https://developer.wordpress.com/docs/api/)
  - [Yahoo](https://developer.yahoo.com/oauth2/guide/)
- Oauth2 & client credentials
  - [DeviantArt](https://www.deviantart.com/developers/)
  - [Discord](https://discordapp.com/developers/)
  - [Spotify](https://developer.spotify.com/web-api/)
  - [Twitch](https://dev.twitch.tv/docs)
  - [Twitter2](https://developer.twitter.com/en/docs/basics/authentication/overview/application-only) (application only)
  - [Vimeo](https://developer.vimeo.com/)
- Native
  - [Last.fm](https://www.last.fm/api/)

(PR welcome!)

## Installation
**requires [composer](https://getcomposer.org)**

`composer.json` (note: replace `dev-master` with a version boundary)
```json
{
	"require": {
		"php": ">=7.2.0",
		"chillerlan/php-oauth": "dev-master"
	}
}
```
If you plan to use encryption (via [sodium](http://php.net/manual/book.sodium.php)), you may add `"ext-sodium": "*"`.

**Manual Installation**

Download the desired version of the package from [master](https://github.com/codemasher/php-oauth/archive/master.zip) or 
[release](https://github.com/codemasher/php-oauth/releases) and extract the contents to your project folder.  After that:
- run `composer install` to install the required dependencies and generate `/vendor/autoload.php`.
- if you use a custom autoloader, point the namespace `chillerlan\OAuth` to the folder `src` of the package 

Profit!

## Usage
### Getting Started
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

### Authentication
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

### OAuth1
```php
// step 3: receive the access token
elseif(isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])){
	$token = $provider->getAccessToken($_GET['oauth_token'], $_GET['oauth_verifier']);

	// save the token (only required when using a non-persistent storage)
	// do whatever you need to do, then redirect to step 4
	header('Location: ?granted='.$provider->serviceName);
}
```

### OAuth2
```php
// step 3: receive the access token
elseif(isset($_GET['code'])){
	// usage of the <state> parameter depends on the provider
	$token = $provider->getAccessToken($_GET['code'], $_GET['state'] ?? null);

	// save & redirect
	header('Location: ?granted='.$provider->serviceName);
}
```

### Auth Granted
After receiving the access token, go on and verify it then use the API.
```php
// step 4: verify the token and use the API
elseif(isset($_GET['granted']) && $_GET['granted'] === $provider->serviceName){
	$response = $provider->doStuff();

	echo '<pre>'.print_r($response,true).'</pre>';
}
```
### Call the Provider's API
After successfully receiving the Token, we're ready to make API requests:
```php
// import a token to the database if needed
$storage->storeAccessToken('Spotify', $token);

// make a request
$response = $provider->request('/some/endpoint', ['q' => 'param'], 'POST', ['data' => 'content'], ['content-type' => 'whatever']);

// use the data
$headers = $response->headers;
$data    = $response->json; 
``` 

### The built-in API Client
The API client is a very minimal implementation of available endpoints for the given provider, which returns the JSON responses as `\stdClass` object. 
Please refer to the [provider class docblocks](https://github.com/codemasher/php-oauth/tree/master/src/Providers) for method names and signatures, 
as well as to [the live API tests](https://github.com/codemasher/php-oauth/tree/master/tests/API) (which are not enabled on Travis) for usage examples.
The general method scheme looks as follows:

 - the method name is either
   - the actual API method name if available
   - substituted from the path element names
 - `:path` elements become required parameters
 - `?query=` parameters become a `[$k => $v]` array
 - `POST|PUT|PATCH|DELETE` body parameters become a `[$k => $v]` array
 
```php
// the general signature
function endpointName([$path_element_n, ... , ] $query_params = null, $body_params = null):OAuthResponse;

// https://example.com/api/endpoint/:id/subendpoint/:name?param1=foo&param2=bar
$provider->endpointIdSubendpointName($id, $name, ['param1' => 'foo', 'param2' => 'bar']);
``` 

## Extensions
In order to use a provider, http client or storage, that is not yet supported, you'll need to implement the respective interfaces:

### [`HTTPClientInterface`](https://github.com/codemasher/php-oauth/tree/master/src/HTTP/HTTPClientInterface.php)
There's already a Guzzle client - what else do you need? :wink: Just extend `HTTPClientAbstract`! Have a look at the [built-in clients](https://github.com/codemasher/php-oauth/tree/master/tests/HTTP) and the [test http client](https://github.com/codemasher/php-oauth/blob/master/tests/API/APITestAbstract.php#L127-L161).

### [`TokenStorageInterface`](https://github.com/codemasher/php-oauth/tree/master/src/Storage/TokenStorageInterface.php)
There are currently 3 different `TokenStorageInterface`, refer to these for implementation details (extend `TokenStorageAbstract`):
- [`MemoryTokenStorage`](https://github.com/codemasher/php-oauth/tree/master/src/Storage/MemoryTokenStorage.php): non-persistent, to store a token during script runtime and then discard it. 
- [`SessionTokenStorage`](https://github.com/codemasher/php-oauth/tree/master/src/Storage/SessionTokenStorage.php): half-persistent, stores a token for as long a user's session is alive.
- [`DBTokenStorage`](https://github.com/codemasher/php-oauth/tree/master/src/Storage/DBTokenStorage.php): persistent, multi purpose database driven storage with encryption support

### [`OAuth1Interface`](https://github.com/codemasher/php-oauth/tree/master/src/Providers/OAuth1Provider.php)
The OAuth1 implementation is close to Twitter's specs and *should* work for most other OAuth1 services.

```php
use chillerlan\OAuth\Providers\OAuth1Provider;

class MyOauth1Provider extends Oauth1Provider{
	
	protected $apiURL          = 'https://api.example.com';
	protected $requestTokenURL = 'https://example.com/oauth/request_token';
	protected $authURL         = 'https://example.com/oauth/authorize';
	protected $accessTokenURL  = 'https://example.com/oauth/access_token';
	
}
```

### [`OAuth2Interface`](https://github.com/codemasher/php-oauth/tree/master/src/Providers/OAuth2Provider.php)
[OAuth2 is a very straightforward... mess](https://hueniverse.com/oauth-2-0-and-the-road-to-hell-8eec45921529). Please refer to your provider's docs for implementation details.
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
	protected $accessTokenExpires        = true;  
	protected $accessTokenRefreshable    = true;  // a token refresh will be performed
	protected $useCsrfToken              = false; // disables <state> parameter creation & check.
	protected $clientCredentials         = true;  // enables/allows fetching of Client Credentials Token

}
```

### API Clients
The API client is rather a map of endpoints than a huge blob of redundant php code.
Simply place a `<providername>.json` in [`/src/API`](https://github.com/codemasher/php-oauth/tree/master/src/API), which then will be parsed and checked against.

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

## API
### `OAuthInterface`
method | return
------ | ------
`__construct(HTTPClientInterface $http, TokenStorageInterface $storage, OAuthOptions $options)` | - 
`__call(string $name, array $arguments)` | `OAuthResponse`, returns `null` if the method was not found
`buildHttpQuery(array $params, bool $urlencode = null, string $delimiter = null, string $enclosure = null)` | `string` 
`getAuthURL(array $params = null)` | string 
`getUserRevokeURL()` | string 
`getStorageInterface()` | `TokenStorageInterface` 
`request(string $path, array $params = null, string $method = null, $body = null, array $headers = null)` | `OAuthResponse` 

property | description 
-------- | ----------- 
`$serviceName` | the classname for the current provider

### `OAuth1Interface`
method | return 
------ | ------ 
`getAccessToken(string $token, string $verifier, string $tokenSecret = null)` | `Token` 
`getRequestToken()` | `Token` 
`getSignature(string $url, array $params, string $method = null)` | string 

### `OAuth2Interface`
method | return 
------ | ------ 
`getAccessToken(string $code, string $state = null)` | `Token` 
`getClientCredentialsToken(array $scopes = null)` | `Token` 
`refreshAccessToken(Token $token = null)` | `Token` 

property | description 
-------- | ----------- 
`$supportsClientCredentials` | bool
`$tokenRefreshable` | bool

### `HTTPClientInterface`
method | return 
------ | ------ 
`request(string $url, array $params = null, string $method = null, $body = null, array $headers = null)` | `OAuthResponse` 
`normalizeRequestHeaders(array $headers)` | array

### `TokenStorageInterface`
method | return 
------ | ------ 
`storeAccessToken(string $service, Token $token)` | `TokenStorageInterface`
`retrieveAccessToken(string $service)` | `Token`
`hasAccessToken(string $service)` | `Token`
`clearAccessToken(string$service)` | `TokenStorageInterface`
`clearAllAccessTokens()` | `TokenStorageInterface`
`storeAuthorizationState(string $service, string $state)` | `TokenStorageInterface`
`retrieveAuthorizationState(string $service)` | string
`hasAuthorizationState(string $service)` | bool
`clearAuthorizationState(string $service)` | `TokenStorageInterface`
`clearAllAuthorizationStates()` | `TokenStorageInterface`

### [`Token`](https://github.com/codemasher/php-oauth/tree/master/src/Token.php)
method | return | description
------ | ------ | -----------
`__construct(array $properties = null)` | - | 
`__set(string $property, $value)` | void | overrides `chillerlan\Traits\Container`
`__toArray()` | array | from `chillerlan\Traits\Container`
`setExpiry(int $expires = null)` | `Token` | 
`isExpired()` | `bool` | 

property | type | default | allowed | description
-------- | ---- | ------- | ------- | -----------
`$requestToken` | string | null | * | OAuth1 only
`$requestTokenSecret` | string | null | * | OAuth1 only
`$accessTokenSecret` | string | null | * | OAuth1 only
`$accessToken` | string | null | * | 
`$refreshToken` | string | null | * | 
`$extraParams` | array | `[]` |  | 
`$expires` | int | `Token::EOL_UNKNOWN` |  | 

### [`OAuthOptions`](https://github.com/codemasher/php-oauth/tree/master/src/OAuthOptions.php)
property | type | default | allowed | description
-------- | ---- | ------- | ------- | -----------
`$key` | string | - | * | the client id from your OAuth provider
`$secret` | string | - | * | the client secret
`$callbackURL` | string | - | * | the URL where the OAuth provider redirects to after successful authentication
`$sessionStart` | bool | `true` | - | whether to start the session when using the `SessionTokenStorage`
`$sessionTokenVar` | string | 'chillerlan-oauth-token' | * | name of the token array in `$_SESSION`
`$sessionStateVar` | string | 'chillerlan-oauth-state' | * | name of the csrf state array in `$_SESSION`
`$useEncryption` | bool | ? | - | `true` if PHP >= 7.2 & sodium extension enabled, `false` otherwise 
`$storageCryptoKey` | string | null | a 64 character hex string (32 byte) | see [`sodium_crypto_box_secretkey()`](http://php.net/manual/function.sodium-crypto-box-secretkey.php)
`$dbLabelHashAlgo` | string | 'md5' | a [valid hash algorithm](http://php.net/manual/function.hash-algos.php) | only used for internal labels
`$dbLabelFormat` | string | '%1$s@%2$s' | * | passed to [sprinf()](http://php.net/manual/function.sprintf.php)
`$dbUserID` | int, string | null | * | the user id for the current OAuth session
`$dbTokenTable` | string | null | * | the token storage table, see [`dbstorage_create.php`](https://github.com/codemasher/php-oauth/blob/master/cli/dbstorage_create.php)
`$dbTokenTableExpires` | string | 'expires' | * | 
`$dbTokenTableLabel` | string | 'label' | * | 
`$dbTokenTableProviderID` | string | 'provider_id' | * | 
`$dbTokenTableState` | string | 'state' | * | 
`$dbTokenTableToken` | string | 'token' | * | 
`$dbTokenTableUser` | string | 'user_id' | * | 
`$dbProviderTable` | string | null | * | the provider table, see [`dbstorage_create.php`](https://github.com/codemasher/php-oauth/blob/master/cli/dbstorage_create.php)
`$dbProviderTableID` | string | 'provider_id' | * | 
`$dbProviderTableName` | string | 'servicename' | * | 

# Disclaimer
OAuth tokens are secrets and should be treated as such. Store them in a safe place, 
[consider encryption](http://php.net/manual/book.sodium.php).<br/>
I won't take responsibility for stolen auth tokens. Use at your own risk.
