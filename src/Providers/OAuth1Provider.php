<?php
/**
 * Class OAuth1Provider
 *
 * @filesource   OAuth1Provider.php
 * @created      09.07.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

use chillerlan\OAuth\{
	OAuthException,
	Token,
	HTTP\OAuthResponse
};
use DateTime;

abstract class OAuth1Provider extends OAuthProvider implements OAuth1Interface{

	/**
	 * @var string
	 */
	protected $requestTokenEndpoint;

	/**
	 * @var string
	 */
	protected $tokenSecret;

	/**
	 * @param string $oauth_token
	 * @param string $oauth_token_secret
	 *
	 * @return \chillerlan\OAuth\Token
	 */
	protected function getOauth1Token(string $oauth_token, string $oauth_token_secret):Token {
		return new Token([
			'requestToken'       => $oauth_token,
			'requestTokenSecret' => $oauth_token_secret,
			'accessToken'        => $oauth_token,
			'accessTokenSecret'  => $oauth_token_secret,
			'expires'            => Token::EOL_NEVER_EXPIRES,
		]);
	}

	/**
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function getRequestToken():Token {

		$response = $this->http->request(
			$this->requestTokenEndpoint,
			[],
			'POST',
			null,
			array_merge($this->authHeaders, [
				'Authorization' => $this->getAuthHeader($this->getRequestTokenHeaderParams())
			])
		);

		parse_str($response->body, $data);

		switch(true){
			case !$data || !is_array($data):
				throw new OAuthException(sprintf('unable to parse access token response: %$1s', print_r($response, true) ?? ''));
			case !isset($data['oauth_callback_confirmed']) || $data['oauth_callback_confirmed'] !== 'true':
				throw new OAuthException('error retrieving request token: '.print_r($response, true));
			case !isset($data['oauth_token']) || !isset($data['oauth_token_secret']):
				throw new OAuthException(sprintf('request token missing:  %$1s', print_r($response, true) ?? ''));
		}

		$token = $this->getOauth1Token($data['oauth_token'], $data['oauth_token_secret']);

		unset($data['oauth_token'], $data['oauth_token_secret']);

		$token->extraParams = $data;

		$this->storage->storeAccessToken($this->serviceName, $token);

		return $token;
	}

	/**
	 * @return array
	 */
	protected function getRequestTokenHeaderParams():array {
		$parameters = [
			'oauth_callback'         => $this->options->callbackURL,
			'oauth_consumer_key'     => $this->options->key,
			'oauth_nonce'            => bin2hex(random_bytes(32)),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp'        => (new DateTime())->format('U'),
			'oauth_version'          => '1.0',
		];

		$parameters['oauth_signature'] = $this->getSignature($this->requestTokenEndpoint, $parameters, 'POST');

		return $parameters;
	}

	/**
	 * @param string $url
	 * @param array  $params
	 * @param string $method
	 *
	 * @return string
	 */
	public function getSignature(string $url, array $params, string $method = 'POST'):string {
		parse_str(parse_url($url, PHP_URL_QUERY), $query);

		$signatureData = array_merge($query, $params);

		uksort($signatureData, 'strcmp');

		$baseString = strtoupper($method).'&'.rawurlencode($url).'&'.rawurlencode(http_build_query($signatureData));
		$signingKey = rawurlencode($this->options->secret).'&'.rawurlencode($this->tokenSecret ?? '');

		return base64_encode(hash_hmac('sha1', $baseString, $signingKey, true));
	}

	/**
	 * @param string      $token
	 * @param string      $verifier
	 * @param string|null $tokenSecret
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function getAccessToken(string $token, string $verifier, string $tokenSecret = null):Token {

		if(!$tokenSecret){
			$tokenSecret = $this->storage->retrieveAccessToken($this->serviceName)->requestTokenSecret;
		}

		$this->tokenSecret = $tokenSecret;

		$body = ['oauth_verifier' => $verifier];

		$response = $this->http->request(
			$this->accessTokenEndpoint,
			[],
			'POST',
			$body,
			$this->getAccessTokenHeaders($body)
		);

		parse_str($response->body, $data);

		switch(true){
			case !$data || !is_array($data):
				throw new OAuthException('unable to parse access token response');
			case isset($data['error']):
				throw new OAuthException('access token error: '.$data['error']);
			case !isset($data['oauth_token']) || !isset($data['oauth_token_secret']):
				throw new OAuthException('access token missing: '.$response->body);
		}

		$token = $this->getOauth1Token($data['oauth_token'], $data['oauth_token_secret']);

		unset($data['oauth_token'], $data['oauth_token_secret']);

		$token->extraParams = $data;

		$this->storage->storeAccessToken($this->serviceName, $token);

		return $token;
	}

	/**
	 * @param array $body
	 *
	 * @return array
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	protected function getAccessTokenHeaders(array $body):array {
		return $this->getApiHeaders(
			$this->accessTokenEndpoint,
			$body,
			'POST',
			[],
			$this->storage->retrieveAccessToken($this->serviceName)
		);
	}

	/**
	 * @param array $params
	 *
	 * @return string
	 */
	protected function getAuthHeader(array $params):string{
		$authHeader = 'OAuth ';
		$delimiter  = '';

		foreach($params as $key => $value){
			$authHeader .= $delimiter.rawurlencode($key).'="'.rawurlencode($value).'"';

			$delimiter = ', ';
		}

		return $authHeader;
	}

	/**
	 * @param string                  $url
	 * @param array|string            $params
	 * @param string                  $method
	 * @param array                   $headers
	 * @param \chillerlan\OAuth\Token $token
	 *
	 * @return array
	 * @throws \Exception
	 */
	protected function getApiHeaders(string $url, $params = null, string $method, array $headers, Token $token):array{
		$this->tokenSecret = $token->accessTokenSecret;
		$parameters        = $this->getApiHeaderParams($token);

		$signatureParams = is_array($params)
			? array_merge($params, $parameters)
			: $parameters;

		$parameters['oauth_signature'] = $this->getSignature($url, $signatureParams, $method);

		if(isset($params['oauth_session_handle'])){
			$parameters['oauth_session_handle'] = $params['oauth_session_handle'];
			unset($params['oauth_session_handle']);
		}

		return array_merge($headers, $this->apiHeaders, [
			'Authorization' => $this->getAuthHeader($parameters),
		]);
	}

	/**
	 * @param \chillerlan\OAuth\Token $token
	 *
	 * @return array
	 * @throws \Exception
	 */
	protected function getApiHeaderParams(Token $token):array {
		return [
			'oauth_consumer_key'     => $this->options->key,
			'oauth_nonce'            => bin2hex(random_bytes(32)),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp'        => (new DateTime())->format('U'),
			'oauth_token'            => $token->accessToken,
			'oauth_version'          => '1.0',
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
	 */
	public function request(string $path, array $params = [], string $method = 'GET', $body = null, array $headers = []):OAuthResponse{

		$headers = $this->getApiHeaders(
			$this->apiURL.$path,
			$body ?? $params,
			$method,
			$headers,
			$this->storage->retrieveAccessToken($this->serviceName)
		);

		return $this->http->request($this->apiURL.$path, $params, $method, $body, $headers);
	}

}
