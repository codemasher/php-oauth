<?php
/**
 * Interface OAuthInterface
 *
 * @filesource   OAuthInterface.php
 * @created      09.07.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

use chillerlan\OAuth\HTTP\OAuthResponse;
use chillerlan\OAuth\Storage\TokenStorageInterface;

/**
 * @property string $serviceName
 */
interface OAuthInterface{

	/**
	 * @param array $params
	 *
	 * @return string
	 */
	public function getAuthURL(array $params = []):string;

	/**
	 * @return string
	 */
	public function getUserRevokeURL():string;

	/**
	 * @param string $path
	 * @param array  $params
	 * @param string $method
	 * @param null   $body
	 * @param array  $headers
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 */
	public function request(string $path, array $params = [], string $method = 'GET', $body = null, array $headers = []):OAuthResponse;

	/**
	 * @return \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	public function getStorageInterface():TokenStorageInterface;

	/**
	 * http_build_query() replacement
	 *
	 * @param array  $params
	 * @param bool   $urlencode
	 * @param string $delimiter
	 * @param string $enclosure
	 *
	 * @return string
	 */
	public function buildHttpQuery(array $params, bool $urlencode = null, string $delimiter = null, string $enclosure = null):string;

}
