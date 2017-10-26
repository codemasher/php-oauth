<?php
/**
 * Class SpotifyTest
 *
 * @filesource   SpotifyTest.php
 * @created      10.07.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\Spotify;
use chillerlan\OAuth\Token;

class SpotifyTest extends APITestAbstract{

	const USER = 'chillerlan'; // you're welcome

	protected $providerClass = Spotify::class;
	protected $envvar        = 'SPOTIFY';

	/**
	 * @var \chillerlan\OAuth\Providers\Spotify
	 */
	protected $provider;

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
		$response = $this->provider->search($params);
		$this->assertSame($expected, $response->{$field}->items[0]->id);
		print_r($response);
	}


	public function artistDataProvider():array {
		return [
			[['7mefbdlQXxJVKgEbfAeKjL', '1FFaHFtnhdnHuY0xGZcnD1', '4wLIbcoqmqI4WZHDiBxeCB'], ['Helium', 'Mary Timony', 'Sleater-Kinney']],
			[['4G3PykZuN4ts87LgYKI9Zu'], ['WILD FLAG']],
		];
	}

	/**
	 * @dataProvider artistDataProvider
	 *
	 * @param array $ids
	 * @param array $expected
	 */
	public function testArtists(array $ids, array $expected){
		$response = $this->provider->artists(['ids' => implode(',', $ids)]);

		if(isset($response->artists)){
			foreach($response->artists as $k => $artist){
				$this->assertSame($expected[$k], $artist->name);
			}
		}

		print_r($response);
	}

	public function testArtistAlbums(){
		$response = $this->provider->artistAlbums('7mefbdlQXxJVKgEbfAeKjL', ['album_type' => 'album', 'market' => 'de']);
		$this->assertSame(['3It5ZloS0KnWomY5Jv4Isu','5ZcpjhmeKnRTsVyGKtHGP0','4KJaUvkYQ93TH4MxnJfpPh','3TVrfbEBIQTimq6UtUe3vv'], array_column($response->items, 'id'));
		print_r($response);
	}

	public function testArtistToptracks(){
		$response = $this->provider->artistTopTracks('7mefbdlQXxJVKgEbfAeKjL', ['country' => 'de']);

		$this->assertSame('Helium', $response->tracks[0]->artists[0]->name);
		print_r($response);
	}

	public function testArtistRelated(){
		$response = $this->provider->artistRelatedArtists('7mefbdlQXxJVKgEbfAeKjL');
		$this->assertContains('Mary Timony', array_column($response->artists, 'name'));
		print_r($response);
	}

	public function testAlbums(){
		$response = $this->provider->albums(['ids' => '4KJaUvkYQ93TH4MxnJfpPh,3TVrfbEBIQTimq6UtUe3vv,5ZcpjhmeKnRTsVyGKtHGP0', 'market' => 'de']);
		$this->assertSame(['The Dirt of Luck', 'Pirate Prude', 'The Magic City'], array_column($response->albums, 'name'));
		print_r($response);
	}


	public function testTracks(){
		$response = $this->provider->tracks(['ids' => '4wKwANW5UUn5K9WJJWIllV,10ghIZM3y03CSwjTu1mVin', 'market' => 'de']);
		$this->assertSame(['Medusa', 'Oh The Wind And Rain'], array_column($response->tracks, 'name'));
		print_r($response);
	}

	public function testUserprofile(){
		$response = $this->provider->user('spotify');
		$this->assertSame('spotify', $response->id);
		print_r($response);
	}

	public function testRecentlyPlayed(){
		$response = $this->provider->recentlyPlayed();
		$this->assertSame('https://api.spotify.com/v1/me/player/recently-played', $response->href);
		print_r($response);
	}

	public function testDevices(){
		$response = $this->provider->devices();
		$this->assertTrue(isset($response->devices));
		print_r($response);
	}

}
