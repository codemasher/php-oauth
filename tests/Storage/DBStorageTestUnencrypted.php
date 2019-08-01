<?php
/**
 * Class DBStorageTestUnencrypted
 *
 * @filesource   DBStorageTestUnencrypted.php
 * @created      01.08.2019
 * @package      chillerlan\OAuthAppTest\Storage
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\OAuthAppTest\Storage;

use chillerlan\OAuthApp\Storage\DBStorage;

class DBStorageTestUnencrypted extends DBStorageTestAbstract{

	protected function setUp():void{
		parent::setUp();

		$this->options->storageEncryption = false;

		$this->storage = new DBStorage($this->db, $this->options, $this->logger);
	}

}
