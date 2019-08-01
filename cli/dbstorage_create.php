<?php
/**
 *
 * @filesource   dbstorage_create.php
 * @created      23.10.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthCLI;

use chillerlan\Database\Database;

/** @var \chillerlan\Database\Database $db */
$db = null;

/** @var \chillerlan\OAuthApp\OAuthAppOptions $options */
$options = null;

require_once __DIR__.'/bootstrap_cli.php';

createDB($db, $options->db_table_provider, $options->db_table_token);
