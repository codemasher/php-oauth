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

use chillerlan\OAuth\OAuthException;
use chillerlan\OAuth\Token;
use chillerlan\OAuth\HTTP\OAuthResponse;
use DateTime;

abstract class OAuth1Provider extends OAuthProvider implements OAuth1Interface{

	/**
	 * @var string
	 */
	protected $requestTokenEndpoint;

	/**
	 * @var string
	 */
	protected $tokenSecret = null;

	/**
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function getRequestToken():Token {

		$headers  = array_merge(['Authorization' => $this->tokenHeader()], $this->authHeaders);
		$response = $this->http->request($this->requestTokenEndpoint, [], 'POST', [], $headers);

		parse_str($response->body, $data);

		if(!$data || !is_array($data)){
			throw new OAuthException('unable to parse request token response');
		}
		elseif(!isset($data['oauth_callback_confirmed']) || $data['oauth_callback_confirmed'] !== 'true'){
			throw new OAuthException('error retrieving request token');
		}
		elseif(!isset($data['oauth_token']) || !isset($data['oauth_token_secret'])){
			throw new OAuthException('request token missing: '.$response->body);
		}

		$token = new Token([
			'requestToken'       => $data['oauth_token'],
			'requestTokenSecret' => $data['oauth_token_secret'],
			'accessToken'        => $data['oauth_token'],
			'accessTokenSecret'  => $data['oauth_token_secret'],
			'expires'            => Token::EOL_NEVER_EXPIRES,
		]);

		unset($data['oauth_token'], $data['oauth_token_secret']);

		$token->extraParams = $data;

		$this->storage->storeAccessToken($this->serviceName, $token);

		return $token;
	}

	/**
	 * @param string $url
	 * @param array  $params
	 * @param string $method
	 *
	 * @return string
	 */
	public function getSignature(string $url, array $params, string $method = 'POST'):string {
		parse_str(parse_url($url, PHP_URL_QUERY), $queryStringData);

		$signatureData = array_merge($queryStringData, $params);

		uksort($signatureData, 'strcmp');

		$baseString = strtoupper($method).'&'.rawurlencode($url).'&'.rawurlencode(http_build_query($signatureData));
		$signingKey = rawurlencode($this->options->secret).'&'.($this->tokenSecret !== null ? rawurlencode($this->tokenSecret) : '');

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

		$body    = ['oauth_verifier' => $verifier];
		$headers = array_merge([
			'Authorization' => $this->apiHeader('POST', $this->accessTokenEndpoint, $this->storage->retrieveAccessToken($this->serviceName), $body),
		], $this->authHeaders);

		$response = $this->http->request($this->accessTokenEndpoint, [], 'POST', $body, $headers);

		parse_str($response->body, $data);

		if(!$data || !is_array($data)){
			throw new OAuthException('unable to parse access token response');
		}
		elseif(isset($data['error'])){
			throw new OAuthException('access token error: '.$data['error']);
		}
		elseif(!isset($data['oauth_token']) || !isset($data['oauth_token_secret'])){
			throw new OAuthException('access token missing: '.$response->body);
		}

		$token = new Token([
			'requestToken'       => $data['oauth_token'],
			'requestTokenSecret' => $data['oauth_token_secret'],
			'accessToken'        => $data['oauth_token'],
			'accessTokenSecret'  => $data['oauth_token_secret'],
			'expires'            => Token::EOL_NEVER_EXPIRES,
		]);

		unset($data['oauth_token'], $data['oauth_token_secret']);

		$token->extraParams = $data;

		$this->storage->storeAccessToken($this->serviceName, $token);

		return $token;
	}

	/**
	 * @param array $params
	 *
	 * @return string
	 */
	protected function buildAuthHeader(array $params):string{
		$authHeader = 'OAuth ';
		$delimiter  = '';

		foreach($params as $key => $value){
			$authHeader .= $delimiter.rawurlencode($key).'="'.rawurlencode($value).'"';

			$delimiter = ', ';
		}

		return $authHeader;
	}

	/**
	 * @param array $extraParameters
	 *
	 * @return string
	 */
	protected function tokenHeader(array $extraParameters = []):string{

		$parameters = array_merge([
			'oauth_callback'         => $this->options->callbackURL,
			'oauth_consumer_key'     => $this->options->key,
			'oauth_nonce'            => bin2hex(random_bytes(32)),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp'        => (new DateTime())->format('U'),
			'oauth_version'          => '1.0',
		], $extraParameters);

		$parameters['oauth_signature'] = $this->getSignature($this->requestTokenEndpoint, $parameters, 'POST');

		return $this->buildAuthHeader($parameters);
	}

	/**
	 * @param string                  $method
	 * @param string                  $url
	 * @param \chillerlan\OAuth\Token $token
	 * @param array|null              $params
	 *
	 * @return string
	 */
	protected function apiHeader(string $method, string $url, Token $token, $params = null):string{

		$this->tokenSecret = $token->accessTokenSecret;

		$parameters = [
			'oauth_consumer_key'     => $this->options->key,
			'oauth_nonce'            => bin2hex(random_bytes(32)),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp'        => (new DateTime())->format('U'),
			'oauth_token'            => $token->accessToken,
			'oauth_version'          => '1.0',
		];

		$signatureParams = is_array($params)
			? array_merge($parameters, $params)
			: $parameters;

		$parameters['oauth_signature'] = $this->getSignature($url, $signatureParams, $method);

		if(!empty($params) && isset($params['oauth_session_handle'])){
			$parameters['oauth_session_handle'] = $params['oauth_session_handle'];
			unset($params['oauth_session_handle']);
		}
		return $this->buildAuthHeader($parameters);
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
		$auth = $this->apiHeader($method, $this->apiURL.$path, $this->storage->retrieveAccessToken($this->serviceName), $body ?? $params);

		$headers = array_merge(['Authorization' => $auth], array_merge($this->apiHeaders, $headers));

		return $this->http->request($this->apiURL.$path, $params, $method, $body, $headers);
	}

}
