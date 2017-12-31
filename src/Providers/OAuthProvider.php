<?php
/**
 * Class OAuthProvider
 *
 * @filesource   OAuthProvider.php
 * @created      09.07.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

use chillerlan\OAuth\{
	API\OAuthAPIClientException,
	HTTP\HTTPClientInterface,
	OAuthOptions,
	Storage\TokenStorageInterface

};
use chillerlan\Traits\Magic;

/**
 * @property string $serviceName
 */
abstract class OAuthProvider implements OAuthInterface{
	use Magic;

	/**
	 * @var \chillerlan\OAuth\HTTP\HTTPClientInterface
	 */
	protected $http;

	/**
	 * @var \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	protected $storage;

	/**
	 * @var \chillerlan\OAuth\OAuthOptions
	 */
	protected $options;

	/**
	 * @var string
	 */
	protected $serviceName;

	/**
	 * @var string
	 */
	protected $authURL;

	/**
	 * @var string
	 */
	protected $apiURL;

	/**
	 * @var string
	 */
	protected $userRevokeURL;

	/**
	 * @var string
	 */
	protected $revokeURL;

	/**
	 * @var string
	 */
	protected $accessTokenURL;

	/**
	 * @var array
	 */
	protected $authHeaders = [];

	/**
	 * @var array
	 */
	protected $apiHeaders = [];

	/**
	 * @var \stdClass method => [url, method, mandatory_params, params_in_url]
	 */
	protected $apiMethods;

	/**
	 * OAuthProvider constructor.
	 *
	 * @param \chillerlan\OAuth\HTTP\HTTPClientInterface      $http
	 * @param \chillerlan\OAuth\Storage\TokenStorageInterface $storage
	 * @param \chillerlan\OAuth\OAuthOptions                  $options
	 */
	public function __construct(HTTPClientInterface $http, TokenStorageInterface $storage, OAuthOptions $options){
		$this->http    = $http;
		$this->storage = $storage;
		$this->options = $options;

		$this->serviceName = (new \ReflectionClass($this))->getShortName();

		// @todo
		$file = __DIR__.'/../API/'.$this->serviceName.'.json';

		if(is_file($file)){
			$this->apiMethods = json_decode(file_get_contents($file));
		}

	}

	/**
	 * @return string
	 */
	protected function magic_get_serviceName():string {
		return $this->serviceName;
	}

	/**
	 * @return string
	 */
	public function getUserRevokeURL():string{
		return $this->userRevokeURL;
	}

	/**
	 * @return \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	public function getStorageInterface():TokenStorageInterface{
		return $this->storage;
	}

	/**
	 * ugly, isn't it?
	 * @todo WIP
	 *
	 * @param string $name
	 * @param array  $arguments
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse|null
	 * @throws \chillerlan\OAuth\API\OAuthAPIClientException
	 */
	public function __call(string $name, array $arguments){
		if(array_key_exists($name, $this->apiMethods)){

			$m = $this->apiMethods->{$name};

			$endpoint      = $m->path ?? '/';
			$method        = $m->method ?? 'GET';
			$body          = null;
			$headers       = isset($m->headers) && is_object($m->headers) ? (array)$m->headers : [];
			$path_elements = $m->path_elements ?? [];
			$params_in_url = count($path_elements);
			$params        = $arguments[$params_in_url] ?? null;
			$urlparams     = array_slice($arguments,0 , $params_in_url);

			if($params_in_url > 0){

				if(count($urlparams) < $params_in_url){
					throw new OAuthAPIClientException('too few URL params, required: '.implode(', ', $path_elements));
				}

				$endpoint = sprintf($endpoint, ...$urlparams);
			}

			if(in_array($method, ['POST', 'PATCH', 'PUT', 'DELETE'])){
				$body = $arguments[$params_in_url + 1] ?? $params;

				if($params === $body){
					$params = null;
				}

				if(is_array($body) && isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'json') !== false){
					$body = json_encode($body);
				}

			}

#			print_r([$endpoint,$params,$method,$body,$headers]);

			// uhhhh... @todo

			return $this->request(
				$endpoint,
				$this->checkParams($params ?? []),
				$method,
				$this->checkParams($body),
				$headers
			);

		}

		return null;
	}

	/**
	 * @param $params
	 *
	 * @return array
	 */
	protected function checkParams($params){

		if(is_array($params)){

			foreach($params as $key => $value){

				if(is_bool($value)){
					$params[$key] = (string)(int)$value;
				}
				elseif(is_null($value) || empty($value)){
					unset($params[$key]);
				}

			}

		}

		return $params;
	}

	/**
	 * @param $data
	 *
	 * @return array|string
	 */
	protected function rawurlencode($data){

		if(is_array($data)){
			return array_map([$this, 'rawurlencode'], $data);
		}
		elseif(is_scalar($data)){
			return rawurlencode($data);
		}

		return $data;
	}

	/**
	 * from https://github.com/abraham/twitteroauth/blob/master/src/Util.php
	 *
	 * @param array  $params
	 * @param bool   $urlencode
	 * @param string $delimiter
	 * @param string $enclosure
	 *
	 * @return string
	 */
	public function buildHttpQuery(array $params, bool $urlencode = null, string $delimiter = null, string $enclosure = null):string {

		if(empty($params)) {
			return '';
		}

		// urlencode both keys and values
		if($urlencode ?? true){
			$params = array_combine(
				$this->rawurlencode(array_keys($params)),
				$this->rawurlencode(array_values($params))
			);
		}

		// Parameters are sorted by name, using lexicographical byte value ordering.
		// Ref: Spec: 9.1.1 (1)
		uksort($params, 'strcmp');

		$pairs     = [];
		$enclosure = $enclosure ?? '';

		foreach($params as $parameter => $value){

			if(is_array($value)) {
				// If two or more parameters share the same name, they are sorted by their value
				// Ref: Spec: 9.1.1 (1)
				// June 12th, 2010 - changed to sort because of issue 164 by hidetaka
				sort($value, SORT_STRING);

				foreach ($value as $duplicateValue) {
					$pairs[] = $parameter.'='.$enclosure.$duplicateValue.$enclosure;
				}

			}
			else{
				$pairs[] = $parameter.'='.$enclosure.$value.$enclosure;
			}

		}

		// For each parameter, the name is separated from the corresponding value by an '=' character (ASCII code 61)
		// Each name-value pair is separated by an '&' character (ASCII code 38)
		return implode($delimiter ?? '&', $pairs);
	}

}
