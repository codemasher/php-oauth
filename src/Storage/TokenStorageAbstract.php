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

	protected const TOKEN_NONCE = "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x01";

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

	/**
	 * @param \chillerlan\OAuth\Token $token
	 *
	 * @return string
	 */
	public function toStorage(Token $token):string {
		$data = $token->__toJSON();

		if($this->options->useEncryption === true){
			return $this->encrypt($data, $this->options->storageCryptoKey);
		}

		return $data;
	}

	/**
	 * @param string $data
	 *
	 * @return \chillerlan\OAuth\Token
	 */
	public function fromStorage(string $data):Token{

		if($this->options->useEncryption === true){
			$data = $this->decrypt($data, $this->options->storageCryptoKey);
		}

		return (new Token)->__fromJSON($data);
	}

	/**
	 * @param string $data
	 * @param string $key
	 *
	 * @return string
	 * @throws \chillerlan\OAuth\Storage\TokenStorageException
	 */
	public function encrypt(string $data, string $key):string {

		if(function_exists('sodium_crypto_secretbox')){
			return sodium_bin2hex(sodium_crypto_secretbox($data, $this::TOKEN_NONCE, sodium_hex2bin($key)));
		}

		throw new TokenStorageException('sodium not installed'); // @codeCoverageIgnore
	}

	/**
	 * @param string $box
	 * @param string $key
	 *
	 * @return string
	 * @throws \chillerlan\OAuth\Storage\TokenStorageException
	 */
	public function decrypt(string $box, string $key):string {

		if(function_exists('sodium_crypto_secretbox_open')){
			$box = sodium_hex2bin($box);

			return sodium_crypto_secretbox_open($box, $this::TOKEN_NONCE, sodium_hex2bin($key));
		}

		throw new TokenStorageException('sodium not installed'); // @codeCoverageIgnore
	}

}
