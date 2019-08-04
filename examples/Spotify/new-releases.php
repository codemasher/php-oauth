<?php
/**
 * Spotify new releases - proof of concept (The Friday-Script)
 *
 * Crawls the releases of the artists the user follows and looks for new releases for a given date range.
 *
 * @link https://twitter.com/codemasher/status/974755990053834752
 *
 * @filesource   new-releases.php
 * @created      16.03.2018
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthAppExamples\Spotify;

use chillerlan\HTTP\Psr7;

/** @var \chillerlan\OAuth\Providers\Spotify\Spotify $spotify */
$spotify = null;
/** @var \Psr\Log\LoggerInterface $logger */
$logger = null;

require_once __DIR__.'/spotify-common.php';

$me      = Psr7\get_json($spotify->me());
$market  = $me->country; // market???
$now     = time();
$since   = $now - 7 * 86400; // last week
$until   = $now + 0; // adjust to your likes
$datestr = date('d.m.Y', $since).' - '.date('d.m.Y', $until);

$sleeptimer = 250000; // sleep between requests (µs)

$artists     = [];
$newalbums   = [];
$newtracks   = [];
$releaseinfo = [];
$after       = null;

// fetch the artists you're following
while(true){

	$meFollowing = $spotify->meFollowing([
		'type'  => 'artist',
		'limit' => 50, // API max = 50 artists
		'after' => $after
	]);

	$data = Psr7\get_json($meFollowing);

	if($meFollowing->getStatusCode() === 200){

		foreach($data->artists->items as $artist){
			$logger->info('+ '.$artist->name);
			$artists[] = $artist->id;
		}

		$after = $data->artists->cursors->after ?? null;

		if(empty($after)){
			break;
		}

	}
	elseif(isset($data->error)){
		$logger->error($data->error->message.' ('.$data->error->status.')');
#		throw new \Exception($data->error->message, $data->error->status);
	}

	usleep($sleeptimer);
}

// now crawl the artists' new releases
foreach($artists as $id){
	// WTB bulk endpoint /artists/albums?ids=artist_id1,artist_id2,...
	$artistAlbums = Psr7\get_json($spotify->artistAlbums($id, ['market' => $market]));

	foreach($artistAlbums->items ?? [] as $album){
		$rdate = strtotime($album->release_date);

		if($album->release_date_precision === 'day' && $rdate >= $since && $rdate <= $until){

			// skip the "Various Artists" samplers
			if(isset($album->artists) && !empty($album->artists) && strtolower($album->artists[0]->name) === 'various artists'){
				continue;
			}

			$newalbums[] = $album->id;

			$releaseinfo[(int)date('Y', $rdate)][(int)date('m', $rdate)][(int)date('d', $rdate)][$album->id] = $album;

			$logger->info('* '.$album->name);
		}
	}

	usleep($sleeptimer);
}

// fetch the album tracks (why aren't the tracks in the artistAlbums response???)
foreach(array_chunk($newalbums, 20, true) as $chunk){ // API max = 20 albums
	$albums = Psr7\get_json($spotify->albums(['ids' => implode(',', $chunk), 'market' => $market]));

	foreach($albums->albums ?? [] as $album){
		$tracks = array_column($album->tracks->items, 'id');
#		shuffle($tracks);

		$newtracks[] = array_shift($tracks);
	}

	usleep($sleeptimer);
}

// create a new playlist
$playlistCreate = Psr7\get_json($spotify->playlistCreate($me->id, [
	'name'          => 'new releases '.$datestr,
	'public'        => false,
	'collaborative' => false,
	'description'   => 'new releases by the artists i\'m following, '.$datestr,
]));

$logger->info(
	'created playlist: new releases '.$datestr.' ('.count($newtracks).
	' tracks, spotify:user:'.$me->id.':playlist:'.$playlistCreate->id.')'
);

// add the tracks to the playlist
$uris = array_map(function($t){
	return 'spotify:track:'.$t; // why not just ids???
}, $newtracks);

$uris = array_chunk($uris, 100);  // API max = 100 track URIs

foreach($uris as $i => $chunk){
	$playlistAddTracks = $spotify->playlistAddTracks($me->id, $playlistCreate->id, ['uris' => $chunk]);

	$playlistAddTracks->getStatusCode() === 201
		? $logger->info('added tracks '.++$i.'/'.count($uris).' ['.Psr7\get_json($playlistAddTracks)->snapshot_id.']')
		: $logger->error($playlistAddTracks->getStatusCode()); // idc
}

// sort the $releaseinfo array by release date (descending)
krsort($releaseinfo);

foreach($releaseinfo as $y => $year){
	krsort($year);

	foreach($year as $m => $month){
		krsort($month);

		foreach($month as $d => $day){
			sort($day);

			$logger->info('');
			$logger->info('--- '.date('l, jS F Y\:', mktime(0, 0, 0, $m, $d, $y)).' ---');
			$logger->info('');

			foreach($day as $id => $release){
				$logger->info('['.++$id.'] '.implode(', ', array_column($release->artists, 'name')).' - '.$release->name);
			}
		}
	}
}

exit;
