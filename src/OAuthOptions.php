<?php
/**
 * Class OAuthOptions
 *
 * @filesource   OAuthOptions.php
 * @created      09.07.2017
 * @package      chillerlan\OAuth
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth;

use chillerlan\Traits\{
	Container, ContainerInterface
};

/**
 * @property string     $key
 * @property string     $secret
 * @property string     $callbackURL
 * @property bool       $sandboxMode
 * @property bool       $sessionStart
 * @property string     $sessionTokenVar
 * @property string     $sessionStateVar
 * @property bool       $useEncryption
 * @property string     $storageCryptoKey
 * @property string     $dbLabelHashAlgo
 * @property string     $dbLabelFormat
 * @property string|int $dbUserID
 *
 * @property string     $dbTokenTable
 * @property string     $dbTokenTableExpires
 * @property string     $dbTokenTableLabel
 * @property string     $dbTokenTableProviderID
 * @property string     $dbTokenTableState
 * @property string     $dbTokenTableToken
 * @property string     $dbTokenTableUser
 *
 * @property string     $dbProviderTable
 * @property string     $dbProviderTableID
 * @property string     $dbProviderTableName
 */
class OAuthOptions implements ContainerInterface{
	use Container{
		__construct as protected containerConstruct;
	}

	/**
	 * @var string
	 */
	protected $key;

	/**
	 * @var string
	 */
	protected $secret;

	/**
	 * @var string
	 */
	protected $callbackURL;

	/**
	 * @var bool
	 */
	protected $sandboxMode = false;

	/**
	 * @var bool
	 */
	protected $sessionStart = true;

	/**
	 * @var string
	 */
	protected $sessionTokenVar = 'chillerlan-oauth-token';

	/**
	 * @var string
	 */
	protected $sessionStateVar = 'chillerlan-oauth-state';

	/**
	 * @var bool
	 */
	protected $useEncryption;

	/**
	 * a 32 byte string, hex encoded
	 *
	 * @see sodium_crypto_box_secretkey()
	 *
	 * @var string
	 */
	protected $storageCryptoKey;

	/**
	 * @var string
	 */
	protected $dbLabelHashAlgo = 'md5';

	/**
	 * @var string
	 */
	protected $dbLabelFormat   = '%1$s@%2$s'; // user@service

	/**
	 * @var int|string
	 */
	protected $dbUserID;

	protected $dbTokenTable;
	protected $dbTokenTableExpires    = 'expires';
	protected $dbTokenTableLabel      = 'label';
	protected $dbTokenTableProviderID = 'provider_id';
	protected $dbTokenTableState      = 'state';
	protected $dbTokenTableToken      = 'token';
	protected $dbTokenTableUser       = 'user_id';

	protected $dbProviderTable;
	protected $dbProviderTableID      = 'provider_id';
	protected $dbProviderTableName    = 'servicename';

	/**
	 * OAuthOptions constructor.
	 *
	 * @param array|null $properties
	 */
	public function __construct(array $properties = null){
		// enable encryption by default if possible...
		$this->useEncryption = extension_loaded('sodium');

		// ... then load and override the settings
		$this->containerConstruct($properties);
	}

}
