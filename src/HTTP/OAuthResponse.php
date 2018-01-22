<?php
/**
 * Class OAuthResponse
 *
 * @filesource   OAuthResponse.php
 * @created      09.07.2017
 * @package      chillerlan\OAuth\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\HTTP;

use chillerlan\Traits\{
	Container, ContainerInterface
};

/**
 * @property string    $url
 * @property \stdClass $headers
 * @property string    $body
 * @property \stdClass $json
 * @property array     $json_array
 */
class OAuthResponse implements ContainerInterface{
	use Container;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var \stdClass
	 */
	protected $headers;

	/**
	 * @var string
	 */
	protected $body;

	/**
	 * @codeCoverageIgnore
	 *
	 * @param string $property
	 *
	 * @return null|mixed
	 */
	public function __get(string $property){

		if($property === 'json'){
			return json_decode($this->body);
		}
		elseif($property === 'json_array'){
			return json_decode($this->body, true);
		}
		elseif(property_exists($this, $property)){
			return $this->{$property};
		}

		return null;
	}


}
