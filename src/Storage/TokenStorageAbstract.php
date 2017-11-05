<?php
/**
 * Class TokenStorageAbstract
 *
 * @filesource   TokenStorageAbstract.php
 * @created      09.07.2017
 * @package      chillerlan\OAuth\Storage
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Storage;

use chillerlan\OAuth\OAuthOptions;

abstract class TokenStorageAbstract implements TokenStorageInterface{

	/**
	 * @var \chillerlan\OAuth\OAuthOptions
	 */
	protected $options;

	/**
	 * TokenStorageAbstract constructor.
	 *
	 * @param \chillerlan\OAuth\OAuthOptions|null $options
	 */
	public function __construct(OAuthOptions $options = null){
		$this->options = $options ?? new OAuthOptions;
	}

}
