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

use chillerlan\OAuth\API\OAuthAPIClientException;
use chillerlan\OAuth\HTTP\HTTPClientInterface;
use chillerlan\OAuth\OAuthOptions;
use chillerlan\OAuth\Storage\TokenStorageInterface;
use chillerlan\OAuth\Token;
use chillerlan\OAuth\Traits\ClassLoader;
use chillerlan\OAuth\Traits\Magic;

/**
 * @property string $serviceName
 */
abstract class OAuthProvider implements OAuthInterface{
	use ClassLoader, Magic;

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
	protected $userRevokeURL = '';

	/**
	 * @var string
	 */
	protected $revokeURL = '';

	/**
	 * @var string
	 */
	protected $accessTokenEndpoint;

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
	 * @var string
	 */
	protected $scopesDelimiter = ' ';

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
	 * @param array $additionalParameters
	 *
	 * @return string
	 */
	public function getAuthURL(array $additionalParameters = []):string {

		$url = $this->authURL;

		if(!empty($additionalParameters)){
			$url .= '?'.http_build_query($additionalParameters);
		}

		return $url;
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
	 *
	 * @param string $name
	 * @param array  $arguments
	 *
	 * @return mixed
	 * @throws \chillerlan\OAuth\API\OAuthAPIClientException
	 */
	public function __call(string $name, array $arguments){
		if(array_key_exists($name, $this->apiMethods)){

			$endpoint      = $this->apiMethods->{$name}->path ?? '/';
			$method        = $this->apiMethods->{$name}->method ?? 'GET';
			$headers       = (array)$this->apiMethods->{$name}->headers ?? [];
			$params_in_url = count($this->apiMethods->{$name}->path_elements);

			$body      = null;
			$params    = $arguments[$params_in_url] ?? null;
			$urlparams = array_slice($arguments,0 , $params_in_url);

			if($params_in_url > 0){

				if(count($urlparams) < $params_in_url){
					throw new OAuthAPIClientException('too few URL params, required: '.implode(', ', $this->apiMethods->{$name}->path_elements));
				}

				$endpoint = sprintf($endpoint, ...$urlparams);
			}

			if(in_array($method, ['POST', 'PUT', 'DELETE'])){
				$body   = $arguments[$params_in_url + 1] ?? $params;
				$params = $params === $body ? null : $params;
			}

			$r = $this->request($endpoint, $this->checkParams($params ?? []), $method, $this->checkParams($body), $headers);

			return $r->json;
		}

		return null;
	}

	// todo: filter allowed params
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

			uksort($params, 'strcmp');
		}

		return $params;
	}


}
