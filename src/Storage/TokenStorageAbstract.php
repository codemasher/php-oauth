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
	 *
	 * @throws \chillerlan\OAuth\Storage\TokenStorageException
	 */
	public function __construct(OAuthOptions $options = null){
		$this->options = $options ?? new OAuthOptions;

		// https://github.com/travis-ci/travis-ci/issues/8863
		if($this->options->useEncryption === true && !function_exists('sodium_crypto_secretbox') && !function_exists('\\Sodium\\crypto_secretbox')){
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

		if($this->options->useEncryption !== true){
			return $data;
		}

		return $this->encrypt($data, $this->options->storageCryptoKey);
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

		return new Token(json_decode($data, true));
	}

	/**
	 * @param string $data
	 * @param string $key
	 *
	 * @return string
	 * @throws \chillerlan\OAuth\Storage\TokenStorageException
	 */
	public function encrypt(string $data, string $key):string {
		$nonce = random_bytes(24);

		if(function_exists('sodium_crypto_secretbox')){
			return sodium_bin2hex($nonce.sodium_crypto_secretbox($data, $nonce, sodium_hex2bin($key)));
		}
		elseif(function_exists('\\Sodium\\crypto_secretbox')){
			return \Sodium\bin2hex($nonce.\Sodium\crypto_secretbox($data, $nonce, \Sodium\hex2bin($key)));
		}
		// else{ openssl encrypt? }

		throw new TokenStorageException('encryption error');
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

			return sodium_crypto_secretbox_open(substr($box, 24), substr($box, 0, 24), sodium_hex2bin($key));
		}
		elseif(function_exists('\\Sodium\\crypto_secretbox_open')){
			$box = \Sodium\hex2bin($box);

			return \Sodium\crypto_secretbox_open(substr($box, 24), substr($box, 0, 24), \Sodium\hex2bin($key));
		}
		// else{ openssl decrypt? }

		throw new TokenStorageException('decryption error');
	}

}
