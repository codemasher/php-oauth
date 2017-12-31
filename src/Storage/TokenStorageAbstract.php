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

use chillerlan\OAuth\{OAuthOptions, Token};

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

		if($this->options->useEncryption === true && !function_exists('sodium_crypto_secretbox')){
			throw new TokenStorageException('sodium extension installed/enabled?');
		}

	}

	/**
	 * @param \chillerlan\OAuth\Token $token
	 *
	 * @return string
	 */
	public function toStorage(Token $token):string {
		$data = json_encode($token->__toArray());

		if($this->options->useEncryption === false){
			return $data;
		}

		$nonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);

		return sodium_bin2hex($nonce.sodium_crypto_secretbox($data, $nonce, sodium_hex2bin($this->options->storageCryptoKey)));
	}

	/**
	 * @param string $data
	 *
	 * @return \chillerlan\OAuth\Token
	 */
	public function fromStorage(string $data):Token{

		if($this->options->useEncryption === true){
			$data = sodium_hex2bin($data);
			$data = sodium_crypto_secretbox_open(substr($data, 24), substr($data, 0, 24), sodium_hex2bin($this->options->storageCryptoKey));
		}

		return new Token(json_decode($data, true));
	}

}
