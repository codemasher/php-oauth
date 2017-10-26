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

use chillerlan\OAuth\{
	HTTP\HTTPClientInterface,
	HTTP\OAuthResponse,
	OAuthException,
	OAuthOptions,
	Token,
	Storage\TokenStorageInterface
};

/**
 * @property bool supportsClientCredentials
 */
abstract class OAuth2Provider extends OAuthProvider implements OAuth2Interface{

	/**
	 * @var array
	 */
	protected $scopes;

	/**
	 * @var string
	 */
	protected $scopesDelimiter = ' ';

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
	 * @var bool
	 */
	protected $clientCredentials = false;

	/**
	 * @var string
	 */
	protected $ccTokenEndpoint;

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

		$this->scopes = $scopes;
	}

	/**
	 * @return bool
	 */
	protected function magic_get_supportsClientCredentials():bool {
		return $this->clientCredentials;
	}

	/**
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function getAuthURL(array $parameters = []):string{
		$parameters = $this->getAuthURLBody($parameters);

		if($this->csrfToken){

			if(!isset($parameters['state'])){
				$parameters['state'] = sha1(random_bytes(256));
			}

			$this->storage->storeAuthorizationState($this->serviceName, $parameters['state']);
		}

		return $this->authURL.'?'.http_build_query($parameters);
	}

	/**
	 * @param array $parameters
	 *
	 * @return array
	 */
	protected function getAuthURLBody(array $parameters):array {
		return array_merge($parameters, [
			'client_id'     => $this->options->key,
			'redirect_uri'  => $this->options->callbackURL,
			'response_type' => 'code',
			'scope'         => implode($this->scopesDelimiter, $this->scopes),
			'type'          => 'web_server',
		]);
	}

	/**
	 * @param OAuthResponse $response
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	protected function parseResponse(OAuthResponse $response):Token{
		$data = $response->json_array;

		switch(true){
			case !is_array($data):
				throw new OAuthException('unable to parse access token response: '.$response->body);
			case isset($data['error_description']):
				throw new OAuthException('error retrieving access token #1: "'.$data['error'].'": %$2s'.$response->body);
			case isset($data['error']):
				throw new OAuthException('error retrieving access token #2: "'.$data['error'].'": '.$response->body);
		}

		$token = new Token([
			'accessToken'  => $data['access_token'],
			'expires'      => $data['expires_in'] ?? Token::EOL_NEVER_EXPIRES,
			'refreshToken' => $data['refresh_token'] ?? null,
		]);

		unset($data['expires_in'], $data['refresh_token'], $data['access_token']);

		$token->extraParams = $data;

		return $token;
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

		$token = $this->parseResponse(
			$this->http->request(
				$this->accessTokenEndpoint,
				[],
				'POST',
				$this->getAccessTokenBody($code),
				$this->getAccessTokenHeaders()
			)
		);

		$this->storage->storeAccessToken($this->serviceName, $token);

		return $token;
	}

	/**
	 * @param string $code
	 *
	 * @return array
	 */
	protected function getAccessTokenBody(string $code):array {
		return [
			'client_id'     => $this->options->key,
			'client_secret' => $this->options->secret,
			'code'          => $code,
			'grant_type'    => 'authorization_code',
			'redirect_uri'  => $this->options->callbackURL,
		];
	}

	/**
	 * @return array
	 */
	protected function getAccessTokenHeaders():array {
		return $this->authHeaders;
	}

	/**
	 * @param array $scopes
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function getClientCredentialsToken(array $scopes = []):Token {

		if(!$this->clientCredentials){
			throw new OAuthException('not supported');
		}

		$token = $this->parseResponse(
			$this->http->request(
				$this->ccTokenEndpoint ?? $this->accessTokenEndpoint,
				[],
				'POST',
				$this->getClientCredentialsTokenBody($scopes),
				$this->getClientCredentialsTokenHeaders()
			)
		);

		$this->storage->storeAccessToken($this->serviceName, $token);

		return $token;
	}

	/**
	 * @param array $scopes
	 *
	 * @return array
	 */
	protected function getClientCredentialsTokenBody(array $scopes):array {
		return [
			'grant_type'    => 'client_credentials',
			'scope'         => implode($this->scopesDelimiter, $scopes),
		];
	}

	/**
	 * @return array
	 */
	protected function getClientCredentialsTokenHeaders():array {
		return array_merge($this->authHeaders, [
			'Authorization' => 'Basic '.base64_encode($this->options->key.':'.$this->options->secret),
		]);
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

		if(!$token->refreshToken){
			throw new OAuthException(sprintf('Token expired on %s, no refresh token available.', date('Y-m-d h:i:s A', $token->expires))); // @codeCoverageIgnore
		}

		$newToken = $this->parseResponse(
			$this->http->request(
				$this->accessTokenEndpoint,
				[],
				'POST',
				$this->refreshAccessTokenBody($token),
				$this->authHeaders
			)
		);

		if(!$newToken->refreshToken){
			$newToken->refreshToken = $token->refreshToken;
		}

		$this->storage->storeAccessToken($this->serviceName, $newToken);

		return $newToken;
	}

	/**
	 * @param \chillerlan\OAuth\Token $token
	 *
	 * @return array
	 */
	protected function refreshAccessTokenBody(Token $token):array {
		return [
			'client_id'     => $this->options->key,
			'client_secret' => $this->options->secret,
			'grant_type'    => 'refresh_token',
			'refresh_token' => $token->refreshToken,
			'type'          => 'web_server',
		];
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

		// attempt to refresh an expired token
		if($this->accessTokenExpires && $token->isExpired()){
			$token = $this->refreshAccessToken($token);
		}

		parse_str(parse_url($this->apiURL.$path, PHP_URL_QUERY), $query);

		$params = array_merge($query, $params);

		switch(true){
			case array_key_exists($this->authMethod, self::AUTH_METHODS_HEADER):
				$headers = array_merge($headers, [
					'Authorization' => self::AUTH_METHODS_HEADER[$this->authMethod].$token->accessToken,
				]);
				break;
			case array_key_exists($this->authMethod, self::AUTH_METHODS_QUERY):
				$params[self::AUTH_METHODS_QUERY[$this->authMethod]] = $token->accessToken;
				break;
			default:
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
