<?php
/**
 * Class CurlClient
 *
 * @filesource   CurlClient.php
 * @created      21.10.2017
 * @package      chillerlan\OAuth\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\HTTP;

use chillerlan\OAuth\OAuthException;

class CurlClient extends HTTPClientAbstract{

	/**
	 * @var array
	 */
	protected $options;

	/**
	 * @var resource
	 */
	protected $curl;

	/**
	 * @var \stdClass
	 */
	protected $responseHeaders;

	/**
	 * CurlClient constructor.
	 *
	 * @param array $curl_options
	 *
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function __construct(array $curl_options){

		if(!isset($curl_options[CURLOPT_CAINFO]) || !is_file($curl_options[CURLOPT_CAINFO])){
			throw new OAuthException('invalid CA file');
		}

		$this->curl = curl_init();

		curl_setopt_array($this->curl, $curl_options);

		curl_setopt_array($this->curl, [
			CURLOPT_HEADER         => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_PROTOCOLS      => CURLPROTO_HTTP|CURLPROTO_HTTPS,
			CURLOPT_SSL_VERIFYPEER => true,
			CURLOPT_SSL_VERIFYHOST => 2,
			CURLOPT_TIMEOUT        => 5,
		]);

		$this->options = $curl_options;
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
		$this->responseHeaders = new \stdClass;

		try{
			$parsedURL = parse_url($url);

			if(!isset($parsedURL['host']) || !in_array($parsedURL['scheme'], ['http', 'https'])){
				trigger_error('invalid URL');
			}

			$method    = strtoupper($method);
			$headers   = $this->normalizeRequestHeaders($headers);
			$options   = [CURLOPT_CUSTOMREQUEST => $method];

			if(in_array($method, ['PATCH', 'POST', 'PUT', 'DELETE'], true)){

				if($method === 'POST'){
					$options = [CURLOPT_POST => true];

					if(!isset($headers['Content-type']) && is_array($body)){
						$headers += ['Content-type: application/x-www-form-urlencoded'];
						$body = http_build_query($body, '', '&', PHP_QUERY_RFC1738);
					}

				}

				$options += [CURLOPT_POSTFIELDS => $body];
			}

			$headers += [
				'Host: '.$parsedURL['host'],
				'Connection: close',
			];

			$url = $url.(!empty($params) ? '?'.http_build_query($params) : '');

			$options += [
				CURLOPT_URL => $url,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_HEADERFUNCTION => [$this, 'headerLine'],
			];

			curl_setopt_array($this->curl, $options);

			$response = curl_exec($this->curl);

			return new OAuthResponse([
				'headers' => $this->responseHeaders,
				'body'    => $response,
			]);

		}
		catch(\Exception $e){
			throw new OAuthException($e->getMessage());
		}

	}

	/**
	 * @param resource $curl
	 * @param string   $header_line
	 *
	 * @return int
	 *
	 * @link http://php.net/manual/function.curl-setopt.php CURLOPT_HEADERFUNCTION
	 */
	protected function headerLine(/** @noinspection PhpUnusedParameterInspection */$curl, $header_line){
		$header = explode(':', $header_line, 2);

		if(count($header) === 2){
			$this->responseHeaders->{trim(strtolower($header[0]))} = trim($header[1]);
		}
		elseif(substr($header_line, 0, 4) === 'HTTP'){
			$status = explode(' ', $header_line, 3);

			$this->responseHeaders->httpversion = explode('/', $status[0], 2)[1];
			$this->responseHeaders->statuscode  = intval($status[1]);
			$this->responseHeaders->statustext  = trim($status[2]);
		}

		return strlen($header_line);
	}

}
