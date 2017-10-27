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
use chillerlan\OAuthTest\Storage\DBTest;

/** @var \chillerlan\Database\Connection $db */
$db = null;

require_once __DIR__.'/bootstrap_cli.php';

createTable($db, DBTest::TABLE_TOKEN, DBTest::TABLE_PROVIDER);

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
		['provider_id' => 1, 'servicename' => 'Discogs'],
		['provider_id' => 2, 'servicename' => 'Twitter'],
		['provider_id' => 3, 'servicename' => 'Flickr'],
		['provider_id' => 4, 'servicename' => 'Foursquare'],
		['provider_id' => 5, 'servicename' => 'GitHub'],
		['provider_id' => 6, 'servicename' => 'Gitter'],
		['provider_id' => 7, 'servicename' => 'Google'],
		['provider_id' => 8, 'servicename' => 'Instagram'],
		['provider_id' => 9, 'servicename' => 'MusicBrainz'],
		['provider_id' => 10, 'servicename' => 'SoundCloud'],
		['provider_id' => 11, 'servicename' => 'Discord'],
		['provider_id' => 12, 'servicename' => 'Spotify'],
		['provider_id' => 13, 'servicename' => 'Twitch'],
		['provider_id' => 14, 'servicename' => 'Vimeo'],
		['provider_id' => 15, 'servicename' => 'LastFM'],
		['provider_id' => 16, 'servicename' => 'GuildWars2'],
		['provider_id' => 17, 'servicename' => 'Tumblr'],
		['provider_id' => 18, 'servicename' => 'Patreon'],
		['provider_id' => 19, 'servicename' => 'Twitter2'],
		['provider_id' => 20, 'servicename' => 'Wordpress'],
		['provider_id' => 21, 'servicename' => 'DeviantArt'],
		['provider_id' => 22, 'servicename' => 'YahooSocial'],
		['provider_id' => 23, 'servicename' => 'Deezer'],
	];

	return $db->insert
		->into($provider_table)
		->values($providers)
		->execute();
}

