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

use chillerlan\Database\Connection;
use chillerlan\OAuthTest\Storage\TestDBStorage;

/** @var \chillerlan\Database\Connection $db */
$db = null;

require_once __DIR__.'/bootstrap_cli.php';

createTable($db, TestDBStorage::TABLE_TOKEN, TestDBStorage::TABLE_PROVIDER);

/**
 * @param \chillerlan\Database\Connection $db
 * @param string                          $token_table
 * @param string                          $provider_table
 *
 * @return bool|\chillerlan\Database\Result
 */
function createTable(Connection $db, string $token_table, string $provider_table){
	$db->connect();

	$db->raw('DROP TABLE IF EXISTS '.$token_table);
	$db->create
		->table($token_table)
		->primaryKey('label')
		->varchar('label', 32, null, false)
		->int('user_id',10, null, false)
		->varchar('provider_id', 30, '', false)
		->text('token', null, true)
		->text('state')
		->int('expires',10, null, false)
		->execute();

	$db->raw('DROP TABLE IF EXISTS '.$provider_table);
	$db->create
		->table($provider_table)
		->primaryKey('provider_id')
		->tinyint('provider_id',10, null, false, 'UNSIGNED AUTO_INCREMENT')
		->varchar('servicename', 30, '', false)
		->execute();

	$providers = [
		 1 => 'Discogs',
		 2 => 'Twitter',
		 3 => 'Flickr',
		 4 => 'Foursquare',
		 5 => 'GitHub',
		 6 => 'Gitter',
		 7 => 'Google',
		 8 => 'Instagram',
		 9 => 'MusicBrainz',
		10 => 'SoundCloud',
		11 => 'Discord',
		12 => 'Spotify',
		13 => 'Twitch',
		14 => 'Vimeo',
		15 => 'LastFM',
		16 => 'GuildWars2',
		17 => 'Tumblr',
		18 => 'Patreon',
		19 => 'Twitter2',
		20 => 'Wordpress',
		21 => 'DeviantArt',
		22 => 'YahooSocial',
		23 => 'Deezer',
		24 => 'Mixcloud',
		25 => 'Slack',
		26 => 'Amazon',
		27 => 'BigCartel',
	];

	foreach($providers as $i => $provider){
		$db->insert
			->into($provider_table)
			->values(['provider_id' => $i, 'servicename' => $provider])
			->execute();
	}

	return true;
}

