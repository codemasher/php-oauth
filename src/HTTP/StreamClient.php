<?php
/**
 * Class StreamClient
 *
 * @filesource   StreamClient.php
 * @created      21.10.2017
 * @package      chillerlan\OAuth\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\HTTP;

use chillerlan\OAuth\OAuthException;

class StreamClient extends HTTPClientAbstract{

	/**
	 * @var string
	 *
	 * @link https://curl.haxx.se/ca/cacert.pem
	 */
	protected $cacert;

	/**
	 * @var string
	 */
	protected $userAgent;

	/**
	 * StreamClient constructor.
	 *
	 * @param string $cacert
	 * @param string $userAgent
	 *
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function __construct(string $cacert, string $userAgent){

		if(!is_file($cacert)){
			throw new OAuthException('invalid CA file');
		}

		$this->cacert    = $cacert;
		$this->userAgent = $userAgent;
	}

	/**
	 * @param string $url
	 * @param array  $params
	 * @param string $method
	 * @param mixed  $body
	 * @param array  $headers
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function request(string $url, array $params = [], string $method = 'POST', $body = null, array $headers = []):OAuthResponse{

		$parsedURL = parse_url($url);

		if(!isset($parsedURL['host']) || !in_array($parsedURL['scheme'], ['http', 'https'])){
			throw new OAuthException('invalid URL');
		}

		try{
			$method = strtoupper($method);
			$headers = $this->normalizeRequestHeaders($headers);

			if(in_array($method, ['PATCH', 'POST', 'PUT', 'DELETE']) && is_array($body)){
				$body = http_build_query($body, '', '&', PHP_QUERY_RFC1738);

				$headers['Content-Type']   = 'Content-Type: application/x-www-form-urlencoded';
				$headers['Content-length'] = 'Content-length: '.strlen($body);
			}

			$headers['Host']           = 'Host: '.$parsedURL['host'].(!empty($parsedURL['port']) ? ':'.$parsedURL['port'] : '');
			$headers['Connection']     = 'Connection: close';

			$url = $url.(!empty($params) ? '?'.http_build_query($params) : '');

			$context = stream_context_create([
				'http' => [
					'method'           => $method,
					'header'           => $headers,
					'content'          => $body,
					'protocol_version' => '1.1',
					'user_agent'       => $this->userAgent,
					'max_redirects'    => 0,
					'timeout'          => 5,
				],
				'ssl' => [
					'cafile'              => $this->cacert,
					'verify_peer'         => true,
					'verify_depth'        => 3,
					'peer_name'           => $parsedURL['host'],
					'ciphers'             => 'HIGH:!SSLv2:!SSLv3',
					'disable_compression' => true,
				],
			]);

			$response         = file_get_contents($url, false, $context);
			$responseHeaders  = get_headers($url, 1);

			return new OAuthResponse([
				'headers' => $this->parseResponseHeaders($responseHeaders),
				'body'    => trim($response),
			]);

		}
		catch(\Exception $e){
			throw new OAuthException($e->getMessage());
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

			if($k === 0 && substr($v, 0, 4) === 'HTTP'){
				$status = explode(' ', $v, 3);

				$h->httpversion = explode('/', $status[0], 2)[1];
				$h->statuscode  = intval($status[1]);
				$h->statustext  = trim($status[2]);
			}
			else{
				$h->{strtolower($k)} = $v;
			}

		}

		return $h;
	}

}
