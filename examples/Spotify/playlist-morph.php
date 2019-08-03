<?php
/**
 * Spotify playlist morph - proof of concept
 *
 * Creates a new playlist from a given playlist while it replaces each track with
 * another one from the same album or a random track from the same artist.
 *
 * @filesource   playlist-morph.php
 * @created      04.04.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\OAuthAppExamples\Spotify;

use chillerlan\HTTP\Psr7;

/** @var \chillerlan\OAuth\Providers\Spotify\Spotify $spotify */
$spotify = null;

require_once __DIR__.'/spotify-common.php';

$me      = Psr7\get_json($spotify->me());
$market  = $me->country; // market???

// @todo: fetch from URI, $me or given user (list public playlists)
$playlist_user = 'chillerlan';
$playlist_id   = '72UW68EZzeXY8FnLmrBpA9'; // 2018

$userPlaylist = Psr7\get_json($spotify->userPlaylist($playlist_user, $playlist_id, ['fields' => 'name,description', 'market' => $market]));

$offset    = 0;
$limit     = 100; // API max = 100 tracks
$max_size  = 500;
$oldalbums = [];
$artists   = [];
$trackinfo = [];
$newtracks = [];

$sleeptimer = 250000; // sleep between requests (µs)

// fetch all tracks of a given playlist, including artist & album ids
while(true){
	$userPlaylistTracks = Psr7\get_json($spotify->userPlaylistTracks($playlist_user, $playlist_id, [
		'fields' => 'total,items(track(id,name,album(id),artists(id,name)))',
		'offset' => $offset,
		'limit'  => $limit,
		'market' => $market,
	]));

	foreach($userPlaylistTracks->items as $t){
		$track  = $t->track->id;
		$artist = $t->track->artists[0];

		$oldalbums[$track] = $t->track->album->id;
		$artists[$track]   = $artist->id;
		$trackinfo[$track] = $artist->name.' - '.$t->track->name;

		$logger->info('- '.$trackinfo[$track]);
	}

	// crawl through the pagination
	if($userPlaylistTracks->total ?? false){
		$offset += $limit;

		if($offset > $userPlaylistTracks->total || $offset >= $max_size){
			break;
		}
	}

	usleep($sleeptimer);
}

// now fetch the tracklist for each track's album
foreach(array_chunk($oldalbums, 20, true) as $chunk){ // API max = 20 albums
	$albums = Psr7\get_json($spotify->albums(['ids' => implode(',', $chunk), 'market' => $market]));

	if(!isset($albums->albums)){
		$logger->error('expected album list, got nothing');
		continue;
	}

	foreach(array_combine(array_keys($chunk), $albums->albums) as $oldtrack_id => $album){

		if(!isset($album->tracks)){
			continue;
		}

		// diff the old track against the album tracks
		$diff = array_diff(array_column($album->tracks->items, 'id'), [$oldtrack_id]);

		if(!empty($diff)){
			// randomize the leftover tracks and pick the first
			shuffle($diff);
			$newtracks[$oldtrack_id] =  array_shift($diff);
			$logger->info('+ ['.$trackinfo[$oldtrack_id].']');

			continue;
		}

		// no leftover tracks - try to pick a different track from the same artist
		// this is quite exhausting - 2 requests/each
		// @todo: options -> do nothing/pick different album
		// @todo: skip the "Various Artists"

		// WTB bulk endpoint /artists/albums?ids=artist_id1,artist_id2,...
		$artistAlbums = Psr7\get_json($spotify->artistAlbums($artists[$oldtrack_id], ['market' => $market]));

		usleep($sleeptimer);

		if(!isset($artistAlbums->items)){
			continue;
		}

		// diff the old album vs the artist's albums
		$artistAlbums = array_diff(array_column($artistAlbums->items, 'id'), [$album->id]);

		if(empty($artistAlbums)){
			continue;
		}

		// @todo options -> pick random/first (most recent)/last (oldest) album
		shuffle($artistAlbums);

		// WTB bulk endpoint /albums/tracks?ids=album_id1,album_id2,...
		$albumTracks = Psr7\get_json($spotify->albumTracks(array_shift($artistAlbums), ['market' => $market]));

		if(isset($albumTracks->items)){
			shuffle($albumTracks->items);
		}

		$newtrack = array_shift($albumTracks->items);
		$newtracks[$oldtrack_id] = $newtrack->id ?? $oldtrack_id;

		$logger->info('* ['.$trackinfo[$oldtrack_id].'] '.$newtrack->name);

		usleep($sleeptimer);
	}

	usleep($sleeptimer);
}

// ...and create a new playlist for them
$hash         = sha1(implode(array_keys($newtracks)).implode(array_values($newtracks)));
$playlistname = $userPlaylist->name.' morphed-'.substr($hash, 0, 8);

$playlistCreate = Psr7\get_json($spotify->playlistCreate($me->id, [
	'name'          => $playlistname,
	'public'        => false,
	'collaborative' => false,
	// can you please autolink Spotify URIs in the description?
	'description'   => 'Playlist morphed from spotify:user:'.$playlist_user.':playlist:'.$playlist_id.' ['.$hash.']'
	                   .(!empty($userPlaylist->description) ? '('.$userPlaylist->description.')' : ''),
]));

$logger->info('created playlist: '.$playlistname.' ('.count($newtracks).' tracks total)');
$logger->info('spotify:user:'.$me->id.':playlist:'.$playlistCreate->id);
$logger->info('https://open.spotify.com/user/'.$me->id.'/playlist/'.$playlistCreate->id);

// create the URIs for playlistAddTracks
$uris = array_chunk(array_map(function($t){
	return 'spotify:track:'.$t; // why not just ids???
}, $newtracks), 100);  // API max = 100 track URIs

// add the tracks
foreach($uris as $i => $chunk){
	$playlistAddTracks = $spotify->playlistAddTracks($me->id, $playlistCreate->id, ['uris' => $chunk]);

	$playlistAddTracks->getStatusCode() === 201
		? $logger->info('added tracks '.++$i.'/'.count($uris).' ['.Psr7\get_json($playlistAddTracks)->snapshot_id.']')
		: $logger->error($playlistAddTracks->getReasonPhrase()); // idc
	usleep($sleeptimer);
}

exit;
