<?php
/**
 * @filesource   spotify.php
 * @created      25.12.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthExamples\Spotify;

require_once __DIR__.'/spotify-common.php';

// fetch the artists you're following
// this will take a while, depending on how many artists you're following

/** @var chillerlan\OAuth\Providers\Spotify $response */
$response = $spotify->meFollowing(['type' => 'artist', 'limit' => 50])->json;
$artists  = [];

while(true){

	foreach($response->artists->items as $artist){
		$artists[] = $artist->id;
	}

	if(empty($response->artists->cursors->after)){
		break;
	}

	$response = $spotify->meFollowing([
		'type'  => 'artist',
		'limit' => 50,
		'after' => $response->artists->cursors->after
	])->json;
}

$now = time();

$since       = $now - 7 * 86400; // last week
$until       = $now + 0; // adjust to your likes

// now crawl the artists' new releases
$newReleases = [];

foreach($artists as $id){
	$response = $spotify->artistAlbums($id)->json;

	if(isset($response->items)){

		foreach($response->items as $album){
			$rdate = strtotime($album->release_date);

			if($album->release_date_precision === 'day' && $rdate >= $since && $rdate <= $until){
				$newReleases[(int)date('Y', $rdate)][(int)date('m', $rdate)][(int)date('d', $rdate)][$album->id] = // $album;
					implode(', ', array_column($album->artists, 'name')).' ['.$album->name.']';
			}

		}

	}

}

// sort the array by release date (descending)
krsort($newReleases);

foreach($newReleases as $y => $year){
	krsort($newReleases[$y]);

	foreach($year as $m => $month){
		krsort($newReleases[$y][$m]);
	}
}

echo 'new releases by the artists i\'m following on spotify, from '.date('d.m.Y', $since).' until '.date('d.m.Y', $until).PHP_EOL.PHP_EOL;

print_r($newReleases);
