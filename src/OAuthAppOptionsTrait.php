<?php
/**
 * Trait OAuthAppOptionsTrait
 *
 * @filesource   OAuthAppOptionsTrait.php
 * @created      31.07.2019
 * @package      chillerlan\OAuthApp
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\OAuthApp;

use chillerlan\OAuth\OAuthException;

trait OAuthAppOptionsTrait{

	/**
	 * @var string
	 */
	protected $db_table_provider;

	/**
	 * @var string
	 */
	protected $db_table_token;

	/**
	 * @var int
	 */
	protected $db_user_id;

	/**
	 * @var bool
	 */
	protected $storageEncryption = true;

	/**
	 * @var string
	 */
	protected $storageCryptoKey;

	/**
	 * @var string
	 */
	protected $storageCryptoNonce = "\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0a\x0b\x0c\x0d\x0e\x0f\x10\x11\x12\x13\x14\x15\x16\x17\x18";

	/**
	 * @param string $key
	 *
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	protected function set_storageCryptoKey(string $key):void{

		if(\preg_match('/[a-f\d]/i',$key)){
			$key = \sodium_hex2bin($key);
		}

		if(\strlen($key) !== \SODIUM_CRYPTO_SECRETBOX_KEYBYTES){
			throw new OAuthException('invalid sodium cryptobox key');
		}

		$this->storageCryptoKey = $key;
	}

	/**
	 * @param string $nonce
	 *
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	protected function storageCryptoNonce(string $nonce):void{

		if(\preg_match('/[a-f\d]/i',$nonce)){
			$nonce = \sodium_hex2bin($nonce);
		}

		if(\strlen($nonce) !== \SODIUM_CRYPTO_SECRETBOX_NONCEBYTES){
			throw new OAuthException('invalid sodium cryptobox nonce');
		}

		$this->storageCryptoKey = $nonce;
	}

}
