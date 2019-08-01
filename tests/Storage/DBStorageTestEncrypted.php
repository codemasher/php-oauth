<?php
/**
 * Class DBStorageTestEncrypted
 *
 * @filesource   DBStorageTestEncrypted.php
 * @created      01.08.2019
 * @package      chillerlan\OAuthAppTest\Storage
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\OAuthAppTest\Storage;

use chillerlan\OAuthApp\Storage\DBStorage;

class DBStorageTestEncrypted extends DBStorageTestAbstract{

	protected function setUp():void{
		parent::setUp();

		$this->options->storageEncryption = true;
		$this->options->storageCryptoKey  = '000102030405060708090a0b0c0d0e0f101112131415161718191a1b1c1d1e1f';

		$this->storage = new DBStorage($this->db, $this->options, $this->logger);
	}

}
