<?php
/**
 * Class LastFMTest
 *
 * @filesource   LastFMTest.php
 * @created      10.07.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\LastFM;

class LastFMTest extends APITestAbstract{

	const USER = 'smiley-1'; // you're welcome

	protected $providerClass = LastFM::class;
	protected $envvar        = 'LASTFM';

	/**
	 * @var \chillerlan\OAuth\Providers\LastFM
	 */
	protected $provider;

	/**
	 * @dataProvider MethodDataProvider
	 *
	 * @param string $method
	 * @param string $return
	 * @param array  $params
	*/
	public function testMethod(string $method, string $return, array $params){
		$r = $this->provider->{$method}($params);

		$this->assertTrue(isset($r->{$return}));

		print_r($r->{$return});
	}

	public function MethodDataProvider(){
		return [
			['albumGetInfo', 'album', [
				'mbid'        => null, // ???
				'album'       => 'the magic city',
				'artist'      => 'helium',
				'username'    => null,
				'lang'        => null,
				'autocorrect' => true,
			]],
			['artistGetCorrection', 'corrections', [
				'artist'  => 'sleater kinney',
			]],
			['artistGetInfo', 'artist', [
				'mbid'  => null,
				'artist'  => 'sleater kinney',
				'username'  => null,
				'lang'  => 'en',
				'autocorrect'  => true,
			]],
			['trackGetCorrection', 'corrections', [
				'artist'  => 'sleater kinney',
				'track'  => 'oh',
			]],
			['trackGetInfo', 'track', [
				'mbid'  => null,
				'artist'  => 'sleater kinney',
				'track'  => 'oh',
				'username'  => null,
				'autocorrect'  => true,
			]],
			['albumGetTags', 'tags', [
				'mbid'        => null, // ???
				'album'       => 'the magic city',
				'artist'      => 'helium',
				'user'        => null,
				'autocorrect' => true,
			]],
			['albumGetTopTags', 'toptags', [
				'mbid'        => null, // ???
				'album'       => 'the magic city',
				'artist'      => 'helium',
				'autocorrect' => true,
			]],
			['albumSearch', 'results', [
				'album'  => 'the magic city',
				'limit'  => null,
				'page'   => null,
			]],
			['artistGetSimilar', 'similarartists', [
				'mbid'  => null,
				'artist'  => 'sleater kinney',
				'limit'  => 5,
				'autocorrect'  => true,
			]],
			['artistGetTags', 'tags', [
				'mbid'  => null,
				'artist'  => 'sleater kinney',
				'user'  => null,
				'autocorrect'  => true,
			]],
			['artistGetTopAlbums', 'topalbums', [
				'mbid'  => null,
				'artist'  => 'sleater kinney',
				'autocorrect'  => true,
				'page'  => null,
				'limit'  => null,
			]],
			['artistGetTopTags', 'toptags', [
				'mbid'  => null,
				'artist'  => 'sleater kinney',
				'autocorrect'  => true,
			]],
			['artistGetTopTracks', 'toptracks', [
				'mbid'  => null,
				'artist'  => 'sleater kinney',
				'autocorrect'  => true,
				'page'  => null,
				'limit'  => null,
			]],
			['artistSearch', 'results', [
				'artist'  => 'sleater kinney',
				'page'  => null,
				'limit'  => null,
			]],
			['chartGetTopArtists', 'artists', [
				'page'  => null,
				'limit'  => 10,
			]],
			['chartGetTopTags', 'tags', [
				'page'  => null,
				'limit'  => 10,
			]],
			['chartGetTopTracks', 'tracks', [
				'page'  => null,
				'limit'  => 10,
			]],
			['geoGetTopArtists', 'topartists', [
				'country'  => 'germany',
				'location'  => 'berlin',
				'page'  => null,
				'limit'  => 10,
			]],
			['geoGetTopTracks', 'tracks', [
				'country'  => 'germany',
				'location'  => 'berlin',
				'page'  => null,
				'limit'  => 10,
			]],
			['libraryGetArtists', 'artists', [
				'user'  => self::USER,
				'page'  => null,
				'limit'  => 10,
			]],
			['trackGetSimilar', 'similartracks', [
				'mbid'  => '9ef0e5a6-fd45-462e-83c0-f59b8c2d102f',
				'artist'  => null,
				'track'  => null,
				'limit'  => null,
				'autocorrect'  => true,
			]],
			['trackGetTags', 'tags', [
				'mbid'  => null,
				'artist'  => 'sleater kinney',
				'track'  => 'jumpers',
				'user'  => null,
				'autocorrect'  => true,
			]],
			['trackGetTopTags', 'toptags', [
				'mbid'  => null,
				'artist'  => 'sleater kinney',
				'track'  => 'jumpers',
				'autocorrect'  => true,
			]],
			['trackSearch', 'results', [
				'artist'  => 'sleater kinney',
				'track'  => 'jumpers',
				'page'  => null,
				'limit'  => 10,
			]],
			['trackUpdateNowPlaying', 'nowplaying', [
				'mbid'  => null,
				'artist'  => 'sleater kinney',
				'track'  => 'jumpers',
				'album'  => 'the woods',
				'trackNumber'  => null,
				'context'  => null,
				'duration'  => null,
				'albumArtist'  => null,
			]],
			['userGetArtistTracks', 'artisttracks', [
				'user'  => self::USER,
				'artist'  => 'Helium',
				'limit'  => 5,
				'page'  => null,
				'startTimestamp'  => null,
				'endTimestamp'  => null,
			]],
			['userGetFriends', 'friends', [
				'user'  => self::USER,
				'limit'  => 5,
				'page'  => null,
				'recenttracks'  => true,
			]],
			['userGetInfo', 'user', [
				'user'  => self::USER,
			]],
			['userGetLovedTracks', 'lovedtracks', [
				'user'  => self::USER,
				'limit'  => 5,
				'page'  => null,
			]],
			['userGetPersonalTags', 'taggings', [
				'user'  => self::USER,
				'limit'  => 5,
				'page'  => null,
				'tag'  => '<3',
				'taggingtype'  => 'album',
			]],
			['userGetRecentTracks', 'recenttracks', [
				'user'  => self::USER,
				'limit'  => 5,
				'page'  => null,
				'from'  => null,
				'to'  => null,
				'extended'  => true,
			]],
			['userGetTopAlbums', 'topalbums', [
				'user'  => self::USER,
				'limit'  => 5,
				'page'  => null,
				'period'  => LastFM::PERIOD_7DAY,
			]],
			['userGetTopArtists', 'topartists', [
				'user'  => self::USER,
				'limit'  => 5,
				'page'  => null,
				'period'  => LastFM::PERIOD_7DAY,
			]],
			['userGetTopTags', 'toptags', [
				'user'  => self::USER,
				'limit'  => 5,
				'page'  => null,
			]],
			['userGetWeeklyAlbumChart', 'weeklyalbumchart', [
				'user'  => self::USER,
				'from'  => null,
				'to'  => null,
			]],
			['userGetWeeklyArtistChart', 'weeklyartistchart', [
				'user'  => self::USER,
				'from'  => null,
				'to'  => null,
			]],
			['userGetWeeklyTrackChart', 'weeklytrackchart', [
				'user'  => self::USER,
				'from'  => null,
				'to'  => null,
			]],
			['tagGetInfo', 'tag', [
				'tag'  => 'Disco',
				'lang'  => 'en',
			]],
			['tagGetSimilar', 'similartags', [
				'tag'  => 'Disco',
			]],
			['tagGetTopAlbums', 'albums', [
				'tag'  => 'Disco',
				'limit'  => 5,
				'page'  => null,
			]],
			['tagGetTopArtists', 'topartists', [
				'tag'  => 'Disco',
				'limit'  => 5,
				'page'  => null,
			]],
			['tagGetTopTags', 'toptags', []],
			['tagGetTopTracks', 'tracks', [
				'tag'  => 'Disco',
				'limit'  => 5,
				'page'  => null,
			]],
			['tagGetWeeklyChartList', 'weeklychartlist', [
				'tag'  => 'Disco',
			]],
		];
	}

}
