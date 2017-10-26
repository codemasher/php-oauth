<?php
/**
 * Class Token
 *
 * @filesource   Token.php
 * @created      09.07.2017
 * @package      chillerlan\OAuth
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth;

use chillerlan\OAuth\Traits\Container;

/**
 * Base token implementation for any OAuth version.
 *
 * // Oauth1
 * @property string $requestToken
 * @property string $requestTokenSecret
 * @property string $accessTokenSecret
 *
 * // Oauth1/2
 * @property string $accessToken
 * @property string $refreshToken
 * @property array  $extraParams
 * @property int    $expires
 */
class Token{
	use Container;

	/**
	 * Denotes an unknown end of life time.
	 */
	const EOL_UNKNOWN = -9001;

	/**
	 * Denotes a token which never expires, should only happen in OAuth1.
	 */
	const EOL_NEVER_EXPIRES = -9002;

	/**
	 * @var string
	 */
	protected $requestToken;

	/**
	 * @var string
	 */
	protected $requestTokenSecret;

	/**
	 * @var string
	 */
	protected $accessTokenSecret;

	/**
	 * @var string
	 */
	protected $accessToken;

	/**
	 * @var string
	 */
	protected $refreshToken;

	/**
	 * @var int
	 */
	protected $expires = self::EOL_UNKNOWN;


	/**
	 * @var array
	 */
	protected $extraParams = [];

	/**
	 * Token setter
	 *
	 * @param string $property
	 * @param mixed  $value
	 *
	 * @return void
	 */
	public function __set(string $property, $value){

		if(property_exists($this, $property)){
			$property === 'expires'
				? $this->setExpiry($value)
				: $this->{$property} = $value;
		}

	}

	/**
	 * @param int $expires
	 *
	 * @return \chillerlan\OAuth\Token
	 */
	public function setExpiry(int $expires = null):Token{
		$now = time();

		switch(true){
			case $expires === 0 || $expires === self::EOL_NEVER_EXPIRES:
				$this->expires = self::EOL_NEVER_EXPIRES;
				break;
			case (int)$expires >= $now:
				$this->expires = $expires; // @codeCoverageIgnore
				break;
			case (int)$expires > 0 && (int)$expires < $now:
				$this->expires = $now + $expires; // @codeCoverageIgnore
				break;
			default:
				$this->expires = self::EOL_UNKNOWN;
		}

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isExpired():bool{
		return $this->expires !== self::EOL_NEVER_EXPIRES
		       && $this->expires !== self::EOL_UNKNOWN // ??
		       && time() >= $this->expires;
	}

}
