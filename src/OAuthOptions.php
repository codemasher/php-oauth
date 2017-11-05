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

use chillerlan\OAuth\Traits\Container;

/**
 * @property string $key
 * @property string $secret
 * @property string $callbackURL
 * @property bool   $useEncryption
 * @property string $cryptoKey
 * @property string $dbLabelHashAlgo
 * @property string $dbLabelFormat
 * @property string $dbTokenTable
 * @property string $dbTokenTableExpires
 * @property string $dbTokenTableLabel
 * @property string $dbTokenTableProviderID
 * @property string $dbTokenTableState
 * @property string $dbTokenTableToken
 * @property string $dbTokenTableUser
 * @property string $dbProviderTable
 * @property string $dbProviderTableID
 * @property string $dbProviderTableName
 */
class OAuthOptions{
	use Container;

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

	protected $useEncryption = false;
	protected $cryptoKey;

	protected $dbLabelHashAlgo = 'md5';
	protected $dbLabelFormat   = '%1$s@%2$s'; // user@service

	protected $dbTokenTable;
	protected $dbTokenTableExpires    = 'expires';
	protected $dbTokenTableLabel      = 'label';
	protected $dbTokenTableProviderID = 'provider_id';
	protected $dbTokenTableState      = 'state';
	protected $dbTokenTableToken      = 'token';
	protected $dbTokenTableUser       = 'user_id';

	protected $dbProviderTable;
	protected $dbProviderTableID   = 'provider_id';
	protected $dbProviderTableName = 'servicename';

}
