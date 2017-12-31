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
	OAuthOptions,
	Token,
	Storage\TokenStorageInterface
};

/**
 * @property bool $supportsClientCredentials
 * @property bool $tokenRefreshable
 */
abstract class OAuth2Provider extends OAuthProvider implements OAuth2Interface{

	/**
	 * @var int
	 */
	protected $authMethod = self::HEADER_BEARER;

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
	protected $useCsrfToken = true;

	/**
	 * @var bool
	 */
	protected $accessTokenExpires = false;

	/**
	 * @var bool
	 */
	protected $accessTokenRefreshable = false;

	/**
	 * @var string
	 */
	protected $refreshTokenURL;

	/**
	 * @var bool
	 */
	protected $clientCredentials = false;

	/**
	 * @var string
	 */
	protected $clientCredentialsTokenURL;

	/**
	 * OAuth2Provider constructor.
	 *
	 * @param \chillerlan\OAuth\HTTP\HTTPClientInterface      $http
	 * @param \chillerlan\OAuth\Storage\TokenStorageInterface $storage
	 * @param \chillerlan\OAuth\OAuthOptions                  $options
	 * @param array                                           $scopes
	 */
	public function __construct(HTTPClientInterface $http, TokenStorageInterface $storage, OAuthOptions $options, array $scopes = null){
		parent::__construct($http, $storage, $options);

		$this->scopes = $scopes ?? [];
	}

	/**
	 * @return bool
	 */
	protected function magic_get_supportsClientCredentials():bool {
		return $this->clientCredentials;
	}

	/**
	 * @return bool
	 */
	protected function magic_get_tokenRefreshable():bool {
		return $this->accessTokenRefreshable;
	}

	/**
	 * @param array $params
	 *
	 * @return string
	 */
	public function getAuthURL(array $params = []):string{
		$params = $this->getAuthURLParams($params);

		if($this->useCsrfToken){

			if(!isset($params['state'])){
				$params['state'] = sha1(random_bytes(256));
			}

			$this->storage->storeAuthorizationState($this->serviceName, $params['state']);
		}

		return $this->authURL.'?'.$this->buildHttpQuery($params);
	}

	/**
	 * @param array $params
	 *
	 * @return array
	 */
	protected function getAuthURLParams(array $params):array {

		// this should not be here
		if(isset($params['client_secret'])){
			unset($params['client_secret']);
		}

		return array_merge($params, [
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
	 * @throws \chillerlan\OAuth\Providers\ProviderException
	 */
	protected function parseTokenResponse(OAuthResponse $response):Token{
		$data = $response->json_array;

		if(!is_array($data)){
			throw new ProviderException('unable to parse token response'.PHP_EOL.print_r($response, true));
		}

		foreach(['error_description', 'error'] as $field){

			if(isset($data[$field])){
				throw new ProviderException('error retrieving access token: "'.$data[$field].'"'.PHP_EOL.print_r($data, true));
			}

		}

		if(!isset($data['access_token'])){
			throw new ProviderException('token missing');
		}

		$token = new Token([
			'accessToken'  => $data['access_token'],
			'expires'      => $data['expires_in'] ?? Token::EOL_NEVER_EXPIRES,
			'refreshToken' => $data['refresh_token'] ?? null,
		]);

		unset($data['expires_in'], $data['refresh_token'], $data['access_token']);//$data['state'],

		$token->extraParams = $data;

		return $token;
	}

	/**
	 * @param string|null $state
	 *
	 * @return \chillerlan\OAuth\Providers\OAuth2Interface
	 * @throws \chillerlan\OAuth\Providers\ProviderException
	 */
	protected function checkState(string $state = null):OAuth2Interface{

		if(empty($state)){
			throw new ProviderException('invalid state');
		}

		if(!$this->storage->hasAuthorizationState($this->serviceName)){
			throw new ProviderException('invalid state for '.$this->serviceName);
		}

		$knownState = $this->storage->retrieveAuthorizationState($this->serviceName);

		if(!hash_equals($knownState, $state)){
			throw new ProviderException('invalid authorization state: '.$this->serviceName.' '.$state);
		}

#		$this->storage->clearAuthorizationState($this->serviceName);

		return $this;
	}

	/**
	 * @param string      $code
	 * @param string|null $state
	 *
	 * @return \chillerlan\OAuth\Token
	 */
	public function getAccessToken(string $code, string $state = null):Token{

		if($this->useCsrfToken){
			$this->checkState($state);
		}

		$token = $this->parseTokenResponse(
			$this->http->request(
				$this->accessTokenURL,
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
	 * @codeCoverageIgnore
	 * @return array
	 */
	protected function getAccessTokenHeaders():array {
		return $this->authHeaders;
	}

	/**
	 * @param array $scopes
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\Providers\ProviderException
	 */
	public function getClientCredentialsToken(array $scopes = []):Token {

		if(!$this->clientCredentials){
			throw new ProviderException('not supported');
		}

		$token = $this->parseTokenResponse(
			$this->http->request(
				$this->clientCredentialsTokenURL ?? $this->accessTokenURL,
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
			'grant_type' => 'client_credentials',
			'scope'      => implode($this->scopesDelimiter, $scopes),
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
	 * @throws \chillerlan\OAuth\Providers\ProviderException
	 */
	public function refreshAccessToken(Token $token = null):Token{

		if(!$this->accessTokenRefreshable){
			throw new ProviderException('Token is not refreshable.');
		}

		if($token === null){
			$token = $this->storage->retrieveAccessToken($this->serviceName);
		}

		if(!$token->refreshToken){
			throw new ProviderException(sprintf('Token expired on %s, no refresh token available.', date('Y-m-d h:i:s A', $token->expires))); // @codeCoverageIgnore
		}

		$newToken = $this->parseTokenResponse(
			$this->http->request(
				$this->refreshTokenURL ?? $this->accessTokenURL,
				[],
				'POST',
				$this->refreshAccessTokenBody($token),
				$this->refreshAccessTokenHeaders()
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
	 * @codeCoverageIgnore
	 * @return array
	 */
	protected function refreshAccessTokenHeaders():array{
		return $this->authHeaders;
	}

	/**
	 * @param string $path
	 * @param array  $params
	 * @param string $method
	 * @param null   $body
	 * @param array  $headers
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 * @throws \chillerlan\OAuth\Providers\ProviderException
	 */
	public function request(string $path, array $params = [], string $method = 'GET', $body = null, array $headers = []):OAuthResponse{
		$token = $this->storage->retrieveAccessToken($this->serviceName);

		// attempt to refresh an expired token
		if($this->accessTokenRefreshable && ($token->isExpired() || $token->expires === Token::EOL_UNKNOWN)){
			$token = $this->refreshAccessToken($token);
		}

		parse_str(parse_url($this->apiURL.$path, PHP_URL_QUERY), $query);

		$params = array_merge($query, $params);

		if(array_key_exists($this->authMethod, self::AUTH_METHODS_HEADER)){
			$headers = array_merge($headers, [
				'Authorization' => self::AUTH_METHODS_HEADER[$this->authMethod].$token->accessToken,
			]);
		}
		elseif(array_key_exists($this->authMethod, self::AUTH_METHODS_QUERY)){
			$params[self::AUTH_METHODS_QUERY[$this->authMethod]] = $token->accessToken;
		}
		else{
			throw new ProviderException('invalid auth type');
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
