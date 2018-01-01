<?php
/**
 * Class GuzzleClient
 *
 * @filesource   GuzzleClient.php
 * @created      23.10.2017
 * @package      chillerlan\OAuth\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\HTTP;

use GuzzleHttp\Client;
use Psr\Http\Message\StreamInterface;

class GuzzleClient extends HTTPClientAbstract{

	/**
	 * @var \GuzzleHttp\Client
	 */
	protected $http;

	/**
	 * GuzzleClient constructor.
	 *
	 * @param \GuzzleHttp\Client $http
	 */
	public function __construct(Client $http){
		$this->http = $http;
	}

	/**
	 * @param string $url
	 * @param array  $params
	 * @param string $method
	 * @param mixed  $body
	 * @param array  $headers
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 * @throws \chillerlan\OAuth\HTTP\HTTPClientException
	 */
	public function request(string $url, array $params = null, string $method = null, $body = null, array $headers = null):OAuthResponse{

		try{
			$parsedURL = parse_url($url);
			$method    = strtoupper($method ?? 'POST');

			if(!isset($parsedURL['host']) || !in_array($parsedURL['scheme'], ['http', 'https'], true)){
				trigger_error('invalid URL');
			}

			// @link http://docs.guzzlephp.org/en/stable/request-options.html
			$options = [
				'query'       => $params ?? [],
				'headers'     => $headers ?? [],
				'http_errors' => false, // no exceptions on HTTP errors plz
			];

			if(in_array($method, ['PATCH', 'POST', 'PUT', 'DELETE'], true)){

				if(is_scalar($body) || $body instanceof StreamInterface){
					$options['body'] = $body; // @codeCoverageIgnore
				}
				elseif(in_array($method, ['PATCH', 'POST', 'PUT'], true) && is_array($body)){
					$options['form_params'] = $body;
				}

			}

			$response = $this->http->request($method, explode('?', $url)[0], $options);

			$responseHeaders              = $this->parseResponseHeaders($response->getHeaders());
			$responseHeaders->statuscode  = $response->getStatusCode();
			$responseHeaders->statustext  = $response->getReasonPhrase();
			$responseHeaders->httpversion = $response->getProtocolVersion();

			return new OAuthResponse([
				'headers' => $responseHeaders,
				'body'    => $response->getBody(),
			]);

		}
		catch(\Exception $e){
			throw new HTTPClientException('fetch error: '.$e->getMessage());
		}

	}

	/**
	 * @param array $headers
	 *
	 * @return \stdClass
	 */
	protected function parseResponseHeaders(array $headers):\stdClass {
		$h = new \stdClass;

		foreach($headers as $k => $v){
			$h->{strtolower($k)} = $v[0] ?? null;
		}

		return $h;
	}

}
