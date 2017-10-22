<?php
/**
 * Class OAuth2Provider
 *
 * @filesource   OAuth2Provider.php
 * @created      09.07.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

use chillerlan\OAuth\HTTP\HTTPClientInterface;
use chillerlan\OAuth\HTTP\OAuthResponse;
use chillerlan\OAuth\OAuthException;
use chillerlan\OAuth\OAuthOptions;
use chillerlan\OAuth\Token;
use chillerlan\OAuth\Storage\TokenStorageInterface;

abstract class OAuth2Provider extends OAuthProvider implements OAuth2Interface{

	/**
	 * @var array
	 */
	protected $scopes;

	/**
	 * @var bool
	 */
	protected $csrfToken = true;

	/**
	 * @var bool
	 */
	protected $accessTokenExpires  = false;

	/**
	 * @var int
	 */
	protected $authMethod = self::HEADER_OAUTH;

	/**
	 * OAuth2Provider constructor.
	 *
	 * @param \chillerlan\OAuth\HTTP\HTTPClientInterface      $http
	 * @param \chillerlan\OAuth\Storage\TokenStorageInterface $storage
	 * @param \chillerlan\OAuth\OAuthOptions                  $options
	 * @param array                                           $scopes
	 */
	public function __construct(HTTPClientInterface $http, TokenStorageInterface $storage, OAuthOptions $options, array $scopes = []){
		parent::__construct($http, $storage, $options);

		$this->scopes         = $scopes;
	}

	/**
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function getAuthURL(array $parameters = []):string{

		$parameters = array_merge($parameters, [
			'type'          => 'web_server',
			'client_id'     => $this->options->key,
			'redirect_uri'  => $this->options->callbackURL,
			'response_type' => 'code',
			'scope'         => implode($this->scopesDelimiter, $this->scopes),
		]);

		if($this->csrfToken){

			if(!isset($parameters['state'])){
				$parameters['state'] = sha1(random_bytes(256));
			}

			$this->storage->storeAuthorizationState($this->serviceName, $parameters['state']);
		}

		return $this->authURL.'?'.http_build_query($parameters);
	}

	/**
	 * @param string      $code
	 * @param string|null $state
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function getAccessToken(string $code, string $state = null):Token{

		if($this->csrfToken && is_string($state) && (
			!$this->storage->hasAuthorizationState($this->serviceName)
			|| $this->storage->retrieveAuthorizationState($this->serviceName) !== $state
		)){
			throw new OAuthException('invalid authorization state');
		}

		$body = [
			'code'          => $code,
			'client_id'     => $this->options->key,
			'client_secret' => $this->options->secret,
			'redirect_uri'  => $this->options->callbackURL,
			'grant_type'    => 'authorization_code',
		];

		$token = $this->parseResponse($this->http->request($this->accessTokenEndpoint, [], 'POST',$body, $this->authHeaders));

		$this->storage->storeAccessToken($this->serviceName, $token);

		return $token;
	}

	/**
	 * @param \chillerlan\OAuth\Token $token
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function refreshAccessToken(Token $token = null):Token{

		if(is_null($token)){
			$token = $this->storage->retrieveAccessToken($this->serviceName);
		}

		$refreshToken = $token->refreshToken;

		if(empty($refreshToken)){
			throw new OAuthException('no refresh token available'); // @codeCoverageIgnore
		}

		$body = [
			'grant_type'    => 'refresh_token',
			'type'          => 'web_server',
			'client_id'     => $this->options->key,
			'client_secret' => $this->options->secret,
			'refresh_token' => $refreshToken,
		];

		$token = $this->parseResponse($this->http->request($this->accessTokenEndpoint, [], 'POST', $body, $this->authHeaders));

		if(!$token->refreshToken){
			$token->refreshToken = $refreshToken;
		}

		$this->storage->storeAccessToken($this->serviceName, $token);

		return $token;
	}

	/**
	 * @param OAuthResponse $response
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	protected function parseResponse(OAuthResponse $response):Token{
		$data = $response->json_array;

		if(!is_array($data)){
			throw new OAuthException('unable to parse access token response'.print_r($data, true));
		}
		elseif(isset($data['error_description'])){
			throw new OAuthException('error retrieving access token #1: "'.$data['error_description'].'"'.print_r($data, true));
		}
		elseif(isset($data['error'])){
			throw new OAuthException('error retrieving access token #2: "'.$data['error'].'"'.print_r($data, true));
		}

		$token = new Token(['accessToken' => $data['access_token']]);

		if($this->accessTokenExpires){

			if(isset($data['expires_in'])){
				$token->expires = $data['expires_in'];
				unset($data['expires_in']);
			}

			if(isset($data['refresh_token'])){
				$token->refreshToken = $data['refresh_token'];
				unset($data['refresh_token']);
			}

		}
		else{
			$token->expires = Token::EOL_NEVER_EXPIRES;
		}

		unset($data['access_token']);

		$token->extraParams = $data;

		return $token;
	}

	/**
	 * @param string $path
	 * @param array  $params
	 * @param string $method
	 * @param null   $body
	 * @param array  $headers
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function request(string $path, array $params = [], string $method = 'GET', $body = null, array $headers = []):OAuthResponse{
		$token = $this->storage->retrieveAccessToken($this->serviceName);

		if($this->accessTokenExpires && $token->isExpired()){
			throw new OAuthException(sprintf('Token expired on %s at %s', date('m/d/Y', $token->expires), date('h:i:s A', $token->expires))); // @codeCoverageIgnore
		}

		parse_str(parse_url($this->apiURL.$path, PHP_URL_QUERY), $query);

		$params = array_merge($query, $params);

		if(array_key_exists($this->authMethod, self::AUTH_METHODS_HEADER)){
			$headers = array_merge($headers, [
				'Authorization' => self::AUTH_METHODS_HEADER[$this->authMethod].$token->accessToken
			]);
		}
		elseif(array_key_exists($this->authMethod, self::AUTH_METHODS_QUERY)){
			$params[self::AUTH_METHODS_QUERY[$this->authMethod]] = $token->accessToken;
		}
		else{
			throw new OAuthException('invalid auth type'); // @codeCoverageIgnore
		}

		return $this->http->request(
			$this->apiURL.explode('?', $path)[0],
			$params,
			$method,
			$body,
			array_merge($this->apiHeaders, $headers)
		);
	}


}
