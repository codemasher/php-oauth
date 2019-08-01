<?php
/**
 * Class OAuthAppOptions
 *
 * @filesource   OAuthAppOptions.php
 * @created      31.07.2019
 * @package      chillerlan\OAuthApp
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\OAuthApp;

use chillerlan\Database\DatabaseOptionsTrait;
use chillerlan\OAuth\OAuthOptions;

/**
 * @property string $db_table_provider
 * @property string $db_table_token
 * @property int    $db_user_id
 * @property bool   $storageEncryption
 * @property string $storageCryptoKey
 * @property string $storageCryptoNonce
 */
class OAuthAppOptions extends OAuthOptions{
	use OAuthAppOptionsTrait, DatabaseOptionsTrait;
}
