<?php
/**
 * Class SpotifyAPITest
 *
 * @filesource   SpotifyAPITest.php
 * @created      10.07.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\Spotify;

/**
 * Spotify API usage tests/examples
 *
 * @link https://developer.spotify.com/web-api/endpoint-reference/
 *
 * @property \chillerlan\OAuth\Providers\Spotify $provider
 */
class SpotifyAPITest extends APITestAbstract{

	const USER = '<SPOTIFY_USERNAME>'; // @todo: change this to your username

	protected $FQCN   = Spotify::class;
	protected $envvar = 'SPOTIFY';

	public function testAlbum(){
		$this->response = $this->provider->album('4KJaUvkYQ93TH4MxnJfpPh', ['market' => 'de']);
		$this->assertSame('The Dirt of Luck', $this->response->json->name);
	}

	public function testAlbumTracks(){
		$this->response = $this->provider->albumTracks('4KJaUvkYQ93TH4MxnJfpPh', ['market' => 'de']);
		$this->assertCount(12, $this->response->json->items);
	}

	public function testAlbums(){
		$this->response = $this->provider->albums(['ids' => '4KJaUvkYQ93TH4MxnJfpPh,3TVrfbEBIQTimq6UtUe3vv,5ZcpjhmeKnRTsVyGKtHGP0', 'market' => 'de']);
		$this->assertSame(['The Dirt of Luck', 'Pirate Prude', 'The Magic City'], array_column($this->response->json->albums, 'name'));
	}

	public function testArtistAlbums(){
		$this->response = $this->provider->artistAlbums('7mefbdlQXxJVKgEbfAeKjL', ['album_type' => 'album', 'market' => 'de']);
		$this->assertSame(['3It5ZloS0KnWomY5Jv4Isu','5ZcpjhmeKnRTsVyGKtHGP0','4KJaUvkYQ93TH4MxnJfpPh','3TVrfbEBIQTimq6UtUe3vv'], array_column($this->response->json->items, 'id'));
	}

	public function testArtistRelatedArtists(){
		$this->response = $this->provider->artistRelatedArtists('7mefbdlQXxJVKgEbfAeKjL');
		$this->assertContains('Mary Timony', array_column($this->response->json->artists, 'name'));
	}

	public function testArtistToptracks(){
		$this->response = $this->provider->artistTopTracks('7mefbdlQXxJVKgEbfAeKjL', ['country' => 'de']);
		$this->assertSame('Helium', $this->response->json->tracks[0]->artists[0]->name);
	}

	public function testArtists(){
		$ids      = ['7mefbdlQXxJVKgEbfAeKjL', '1FFaHFtnhdnHuY0xGZcnD1', '4wLIbcoqmqI4WZHDiBxeCB','4G3PykZuN4ts87LgYKI9Zu'];
		$expected = ['Helium', 'Mary Timony', 'Sleater-Kinney', 'WILD FLAG'];

		$this->response = $this->provider->artists(['ids' => implode(',', $ids)]);

		if(isset($this->response->json->artists)){
			foreach($this->response->json->artists as $k => $artist){
				$this->assertSame($expected[$k], $artist->name);
			}
		}

	}

	public function testAudioAnalysis(){
		$this->response = $this->provider->audioAnalysis('10ghIZM3y03CSwjTu1mVin');
		$this->assertSame(7271502, $this->response->json->track->num_samples);
	}

	public function testAudioFeatures(){
		$this->response = $this->provider->audioFeatures('10ghIZM3y03CSwjTu1mVin');
		$this->assertSame(329773, $this->response->json->duration_ms);
	}

	public function testAudioFeaturesAll(){
		$this->response = $this->provider->audioFeaturesAll(['ids' => '4wKwANW5UUn5K9WJJWIllV,10ghIZM3y03CSwjTu1mVin']);
		$this->assertSame([190627, 329773], array_column($this->response->json->audio_features, 'duration_ms'));
	}

	public function testCategories(){
		$this->response = $this->provider->categories();
		$this->assertSame('https://api.spotify.com/v1/browse/categories?offset=0&limit=20', $this->response->json->categories->href);
	}

	public function testCategory(){
		$this->response = $this->provider->category('toplists',  ['locale' => 'de']);
		$this->assertSame('Top-Listen', $this->response->json->name);
	}

	public function testCategoryPlaylists(){
		$this->response = $this->provider->categoryPlaylists('toplists');
		$this->assertTrue(isset($this->response->json->playlists));
	}

	public function testFeaturedPlaylists(){
		$this->response = $this->provider->featuredPlaylists(['country' => 'DE', 'locale' => 'de']);
		$this->assertTrue(isset($this->response->json->playlists));
	}

	public function testMe(){
		$this->response = $this->provider->me();
		$this->assertSame(self::USER, $this->response->json->id);
	}

	public function testMePlaylists(){
		$this->response = $this->provider->mePlaylists(['limit' => 10]);
		$this->assertCount(10, $this->response->json->items);
	}

	public function testMeTop(){
		$this->response = $this->provider->meTop('artists', ['limit' => 10]);
		$this->assertCount(10, $this->response->json->items);
	}

	public function testNewReleases(){
		$this->response = $this->provider->newReleases(['country' => 'DE', 'locale' => 'de']);
		$this->assertSame('https://api.spotify.com/v1/browse/new-releases?country=DE&locale=de&offset=0&limit=20', $this->response->json->albums->href);
	}

	public function testRecentlyPlayed(){
		$this->response = $this->provider->recentlyPlayed();
		$this->assertSame('https://api.spotify.com/v1/me/player/recently-played', $this->response->json->href);
	}

	public function testRecommendations(){
		$this->response = $this->provider->recommendations(['seed_artists' => '4wLIbcoqmqI4WZHDiBxeCB']);
		$this->assertSame('4wLIbcoqmqI4WZHDiBxeCB', $this->response->json->seeds[0]->id);
	}

	public function searchDataProvider():array {
		return  [
			[['q' => 'sleater-kinney', 'type' => 'artist'], 'artists', '4wLIbcoqmqI4WZHDiBxeCB'],
			[['q' => 'wild flag', 'type' => 'artist'], 'artists', '4G3PykZuN4ts87LgYKI9Zu'],
			[['q' => 'album:the woods artist:sleater-kinney', 'type' => 'album'], 'albums', '0U6Z6EVDwVMqwmr2zEcH4L'],
			[['q' => 'track:one beat artist:sleater-kinney', 'type' => 'track'], 'tracks', '3IAFRGBtVWIDGlHL9jIEXe'],
		];
	}

	/**
	 * @dataProvider searchDataProvider
	 *
	 * @param array  $params
	 * @param string $field
	 * @param string $expected
	 */
	public function testSearch(array $params, string $field, string $expected){
		$this->response = $this->provider->search($params);
		$this->assertSame($expected, $this->response->json->{$field}->items[0]->id);
	}

	public function testTrack(){
		$this->response = $this->provider->track('4wKwANW5UUn5K9WJJWIllV', ['market' => 'de']);
		$this->assertSame('Medusa', $this->response->json->name);
	}

	public function testTracks(){
		$this->response = $this->provider->tracks(['ids' => '4wKwANW5UUn5K9WJJWIllV,10ghIZM3y03CSwjTu1mVin', 'market' => 'de']);
		$this->assertSame(['Medusa', 'Oh The Wind And Rain'], array_column($this->response->json->tracks, 'name'));
	}

	public function testUser(){
		$this->response = $this->provider->user('spotify');
		$this->assertSame('spotify', $this->response->json->id);
	}

	public function testUserPlaylists(){
		$this->response = $this->provider->userPlaylists(self::USER, ['limit' => 10]);
		$this->assertSame('https://api.spotify.com/v1/users/'.self::USER.'/playlists?offset=0&limit=10', $this->response->json->href);
	}

	/**
	 * follow
	 * followPlaylist
	 * meFollowing
	 * meFollowingContains
	 * unfollow
	 * unfollowPlaylist
	 * userPlaylistFollowersContains
	 */
	public function testFollow(){
		// unfollow
		$this->response = $this->provider->unfollow(['type' => 'user'], ['ids' => ['spotify']]);
		$this->assertSame(204, $this->response->headers->statuscode);

		// verify unfollow
		$this->response = $this->provider->meFollowingContains(['type' => 'user', 'ids' => 'spotify']);
		$this->assertFalse($this->response->json[0]);

		// follow again
		// @todo: OAuthProvider::__call()
#		$this->response = $this->provider->follow(['type' => 'user', 'ids' => 'spotify']);
		$this->response = $this->provider->follow(['type' => 'user'], ['ids' => ['spotify']]);
		$this->assertSame(204, $this->response->headers->statuscode);

		// check if we follow spotify again
		$this->response = $this->provider->meFollowingContains(['type' => 'user', 'ids' => 'spotify']);
		$this->assertTrue($this->response->json[0]);

		// do we follow the demogorgon playlist?
		$this->response = $this->provider->userPlaylistFollowersContains('spotify', '37i9dQZF1DX9Oqi0gBNbHz', ['ids' => self::USER]);
		$this->assertFalse($this->response->json[0]);

		// follow...
		$this->response = $this->provider->followPlaylist('spotify', '37i9dQZF1DX9Oqi0gBNbHz', ['public' => false]);
		$this->assertSame(200, $this->response->headers->statuscode);

		// ...
		$this->response = $this->provider->userPlaylistFollowersContains('spotify', '37i9dQZF1DX9Oqi0gBNbHz', ['ids' => self::USER]);
		$this->assertTrue($this->response->json[0]);

		// unfollow
		$this->response = $this->provider->unfollowPlaylist('spotify', '37i9dQZF1DX9Oqi0gBNbHz');
		$this->assertSame(200, $this->response->headers->statuscode);

		// finally...!
		$this->response = $this->provider->userPlaylistFollowersContains('spotify', '37i9dQZF1DX9Oqi0gBNbHz', ['ids' => self::USER]);
		$this->assertFalse($this->response->json[0]);

		// yes, we do follow some artists...
		$this->response = $this->provider->meFollowing(['type' => 'artist', 'limit' => 10]);
		$this->assertCount(10, $this->response->json->artists->items);
	}

	/**
	 * meSavedAlbums
	 * meSavedAlbumsContains
	 * saveAlbums
	 * removeSavedAlbums
	 */
	public function testSavedAlbums(){
		// get a random album
		$this->response = $this->provider->meSavedAlbums(['limit' => 1]);
		$album_id = $this->response->json->items[0]->album->id;

		$this->response = $this->provider->removeSavedAlbums(['ids' => [$album_id]]);
		$this->assertSame(200, $this->response->headers->statuscode);

		// it's gone!
		$this->response = $this->provider->meSavedAlbumsContains(['ids' => $album_id]);
		$this->assertFalse($this->response->json[0]);

		// re-add
		$this->response = $this->provider->saveAlbums(['ids' => [$album_id]]);
		$this->assertSame(200, $this->response->headers->statuscode);

		// verify
		$this->response = $this->provider->meSavedAlbumsContains(['ids' => $album_id]);
		$this->assertTrue($this->response->json[0]);
	}

	/**
	 * meSavedTracks
	 * meSavedTracksContains
	 * saveTracks
	 * removeSavedTracks
	 */
	public function testSavedTracks(){
		$this->response = $this->provider->meSavedTracks(['limit' => 1]);
		$track_id = $this->response->json->items[0]->track->id;

		$this->response = $this->provider->removeSavedTracks(['ids' => [$track_id]]);
		$this->assertSame(200, $this->response->headers->statuscode);

		$this->response = $this->provider->meSavedTracksContains(['ids' => $track_id]);
		$this->assertFalse($this->response->json[0]);

		$this->response = $this->provider->saveTracks(['ids' => [$track_id]]);
		$this->assertSame(200, $this->response->headers->statuscode);

		$this->response = $this->provider->meSavedTracksContains(['ids' => $track_id]);
		$this->assertTrue($this->response->json[0]);
	}

	/**
	 * playlistCreate
	 * playlistUpdateDetails
	 * playlistAddTracks
	 * playlistReorderTracks
	 * playlistRemoveTracks
	 * playlistReplaceTracks
	 * userPlaylist
	 * userPlaylistTracks
	 */
	public function testPlaylistCreate(){
		// create
		$name           = 'test_'.md5(microtime(true));
		$body           = ['name' => $name, 'description' => 'test', 'public' => false, 'collaborative' => false];
		$this->response = $this->provider->playlistCreate(self::USER, $body);
		$playlist_id    = $this->response->json->id;
		$this->assertSame($name, $this->response->json->name);

		// update details
		$body = ['name' => 'testy'.$name, 'description' => 'testytest', 'public' => false, 'collaborative' => false];
		$this->response = $this->provider->playlistUpdateDetails(self::USER, $playlist_id, $body);

		// add tracks
		$body           = ['uris' => ['spotify:track:0vYPwZx9gTU21BE6mEyWWk', 'spotify:track:7ykpEr7bxSlD6N8pf8boSv']];
		$this->response = $this->provider->playlistAddTracks(self::USER, $playlist_id, $body);
		$snapshot_id    = $this->response->json->snapshot_id;
		$this->assertSame(201, $this->response->headers->statuscode);

		// verify added tracks
		$this->response = $this->provider->userPlaylist(self::USER, $playlist_id);
		$this->assertSame('0vYPwZx9gTU21BE6mEyWWk', $this->response->json->tracks->items[0]->track->id);
		$this->assertSame('7ykpEr7bxSlD6N8pf8boSv', $this->response->json->tracks->items[1]->track->id);

		// reorder tracks
		$body           = ['range_start' => 1, 'range_length' => 1, 'insert_before' => 0, 'snapshot_id' => $snapshot_id];
		$this->response = $this->provider->playlistReorderTracks(self::USER, $playlist_id, $body);
		$snapshot_id    = $this->response->json->snapshot_id;
		$this->assertSame(200, $this->response->headers->statuscode);

		// verify reorder
		$this->response = $this->provider->userPlaylistTracks(self::USER, $playlist_id);
		$this->assertSame('7ykpEr7bxSlD6N8pf8boSv', $this->response->json->items[0]->track->id);
		$this->assertSame('0vYPwZx9gTU21BE6mEyWWk', $this->response->json->items[1]->track->id);

		// remove tracks
#		$body           = ['tracks' => [['uri' => 'spotify:track:7ykpEr7bxSlD6N8pf8boSv'],]];
		$body           = ['positions' => [0], 'snapshot_id' => $snapshot_id];
		$this->response = $this->provider->playlistRemoveTracks(self::USER, $playlist_id, $body);
		$this->assertSame(200, $this->response->headers->statuscode);

		// verify remove
		$this->response = $this->provider->userPlaylistTracks(self::USER, $playlist_id);
		$this->assertSame('0vYPwZx9gTU21BE6mEyWWk', $this->response->json->items[0]->track->id);

		// replace/empty playlist
		$body = ['uris' => ['spotify:track:5cPNaz7OjAdz1AcjVI9uz5']];
		$this->response = $this->provider->playlistReplaceTracks(self::USER, $playlist_id, $body);
		$this->assertSame(201, $this->response->headers->statuscode);

		// verify replace
		$this->response = $this->provider->userPlaylistTracks(self::USER, $playlist_id);
		$this->assertSame('5cPNaz7OjAdz1AcjVI9uz5', $this->response->json->items[0]->track->id);
	}

	/**
	 * devices
	 * next
	 * nowPlaying
	 * pause
	 * play
	 * previous
	 * repeat*
	 * seek*
	 * shuffle*
	 * transfer
	 * volume*
	 */
	public function testDevices(){
		$active_device   = null;
		$inactive_device = null;
		$this->response  = $this->provider->devices();

		// look for devices
		foreach($this->response->json->devices as $device){

			if($device->is_active){
				$active_device = $device->id;
			}
			else{
				$inactive_device = $device->id;
			}
		}

		if($active_device){
			// start playback
#			$body           = ['uris' => ['spotify:track:1BYqosPcKynuuSLZe2Wp7G', 'spotify:track:5AJfahYQ4mbhVMhYFznHVR'], 'offset' => ['uri' => 'spotify:track:5AJfahYQ4mbhVMhYFznHVR']];
#			$body           = ['context_uri' => 'spotify:user:chillerlan:playlist:3DOua8fOWNgcfj3aNGxnLv', 'offset' => ['position' => 7]];
			$body           = ['context_uri' => 'spotify:album:5AaJfXlHtrlfQh8KfXiIZh', 'offset' => ['position' => 2]];
			$this->response = $this->provider->play(['device_id' => $active_device], $body);
			$this->assertSame(204, $this->response->headers->statuscode);
			usleep(3000000);

			// skip
			$this->response = $this->provider->next();
			$this->assertSame(204, $this->response->headers->statuscode);
			usleep(3000000);

			// previous
			$this->response = $this->provider->previous();
			$this->assertSame(204, $this->response->headers->statuscode);
			usleep(3000000);

			// seek
			// @todo: OAuthProvider::__call()
#			$this->response = $this->provider->seek(['position_ms' => 25000]);
#			$this->assertSame(204, $this->response->headers->statuscode);
#			usleep(3000000);

			// switch device
			if($inactive_device){
				$body           = ['device_ids' => [$inactive_device], 'play' => true];
				$this->response = $this->provider->transfer($body);
				$this->assertSame(204, $this->response->headers->statuscode);
				usleep(3000000);

				$body           = ['device_ids' => [$active_device], 'play' => true];
				$this->response = $this->provider->transfer($body);
				$this->assertSame(204, $this->response->headers->statuscode);
				usleep(3000000);
			}

			// volume
			// @todo: OAuthProvider::__call()
#			$this->response = $this->provider->volume(['volume_percent' => 25]);
#			$this->assertSame(204, $this->response->headers->statuscode);
			usleep(3000000);

			// pause
			$this->response = $this->provider->pause();
			$this->assertSame(204, $this->response->headers->statuscode);
		}

	}

}
