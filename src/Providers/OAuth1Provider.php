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
	protected $requestTokenURL;

	/**
	 * @var string
	 */
	protected $tokenSecret;

	/**
	 * @param array $params
	 *
	 * @return string
	 */
	public function getAuthURL(array $params = null):string {

		$params = array_merge(
			$params ?? [],
			['oauth_token' => $this->getRequestToken()->requestToken]
		);

		return $this->authURL.'?'.http_build_query($params);
	}

	/**
	 * @param array $data
	 *
	 * @return \chillerlan\OAuth\Token
	 */
	protected function getOAuth1Token(array $data):Token {

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
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function getRequestToken():Token {

		$response = $this->http->request(
			$this->requestTokenURL,
			[],
			'POST',
			null,
			array_merge($this->authHeaders, [
				'Authorization' => $this->encodeAuthHeader($this->getRequestTokenHeaderParams())
			])
		);

		parse_str($response->body, $data);

		$error = null;

		if(!$data || !is_array($data)){
			$error = 'unable to parse access token response: ';
		}
		elseif(!isset($data['oauth_callback_confirmed']) || $data['oauth_callback_confirmed'] !== 'true'){
			$error = 'error retrieving request token: ';
		}
		elseif(!isset($data['oauth_token']) || !isset($data['oauth_token_secret'])){
			$error = 'request token missing: ';
		}

		if($error){
			throw new OAuthException($error.PHP_EOL.print_r($response, true));
		}

		return $this->getOAuth1Token($data);
	}

	/**
	 * @return array
	 */
	protected function getRequestTokenHeaderParams():array {

		$params = [
			'oauth_callback'         => $this->options->callbackURL,
			'oauth_consumer_key'     => $this->options->key,
			'oauth_nonce'            => bin2hex(random_bytes(32)),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp'        => (new DateTime())->format('U'),
			'oauth_version'          => '1.0',
		];

		$params['oauth_signature'] = $this->getSignature($this->requestTokenURL, $params, 'POST');

		return $params;
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

		$data = array_merge($query, $params);

		uksort($data, 'strcmp');

		return base64_encode(
			hash_hmac(
				'sha1',
				strtoupper($method).'&'.rawurlencode($url).'&'.rawurlencode(http_build_query($data)),
				rawurlencode($this->options->secret).'&'.rawurlencode($this->tokenSecret ?? ''),
				true
			)
		);
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
			$this->accessTokenURL,
			[],
			'POST',
			$body,
			$this->getAccessTokenHeaders($body)
		);

		parse_str($response->body, $data);

		$error = null;

		if(!$data || !is_array($data)){
			$error = 'unable to parse access token response';
		}
		elseif(isset($data['error'])){
			$error = 'access token error: '.$data['error'];
		}
		elseif(!isset($data['oauth_token']) || !isset($data['oauth_token_secret'])){
			$error = 'access token missing: '.$response->body;
		}

		if($error){
			throw new OAuthException($error.PHP_EOL.print_r($response, true));
		}

		return $this->getOAuth1Token($data);
	}

	/**
	 * @param array $body
	 *
	 * @return array
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	protected function getAccessTokenHeaders(array $body):array {
		return $this->getApiHeaders(
			$this->accessTokenURL,
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
	protected function encodeAuthHeader(array $params):string{
		$authHeader = 'OAuth';
		$delimiter  = ' ';

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
			'Authorization' => $this->encodeAuthHeader($parameters),
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
