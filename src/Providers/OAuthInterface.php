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
use chillerlan\OAuth\Token;

/**
 * @property string $serviceName
 */
interface OAuthInterface{

	/**
	 * @param array $additionalParameters
	 *
	 * @return string
	 */
	public function getAuthURL(array $additionalParameters = []):string;

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

}
