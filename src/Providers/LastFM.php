<?php
/**
 * Class LastFM
 *
 * @filesource   LastFM.php
 * @created      10.07.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

use chillerlan\OAuth\OAuthException;
use chillerlan\OAuth\Token;
use chillerlan\OAuth\HTTP\OAuthResponse;

/**
 * @link http://www.last.fm/api
 *
 * @method mixed albumAddTags(array $body = ['mbid', 'album', 'artist', 'tags'])
 * @method mixed albumGetInfo(array $params = ['mbid', 'album', 'artist', 'username', 'lang', 'autocorrect'])
 * @method mixed albumGetTags(array $params = ['mbid', 'album', 'artist', 'user', 'autocorrect'])
 * @method mixed albumGetTopTags(array $params = ['mbid', 'album', 'artist', 'autocorrect'])
 * @method mixed albumRemoveTag(array $body = ['mbid', 'album', 'artist', 'tag'])
 * @method mixed albumSearch(array $params = ['album', 'limit', 'page'])
 * @method mixed artistAddTags(array $body = ['mbid', 'artist', 'tags'])
 * @method mixed artistGetCorrection(array $params = ['artist'])
 * @method mixed artistGetInfo(array $params = ['mbid', 'artist', 'username', 'lang', 'autocorrect'])
 * @method mixed artistGetSimilar(array $params = ['mbid', 'artist', 'limit', 'autocorrect'])
 * @method mixed artistGetTags(array $params = ['mbid', 'artist', 'user', 'autocorrect'])
 * @method mixed artistGetTopAlbums(array $params = ['mbid', 'artist', 'autocorrect', 'page', 'limit'])
 * @method mixed artistGetTopTags(array $params = ['mbid', 'artist', 'autocorrect'])
 * @method mixed artistGetTopTracks(array $params = ['mbid', 'artist', 'autocorrect', 'page', 'limit'])
 * @method mixed artistRemoveTag(array $body = ['mbid', 'artist', 'tag'])
 * @method mixed artistSearch(array $params = ['artist', 'limit', 'page'])
 * @method mixed chartGetTopArtists(array $params = ['limit', 'page'])
 * @method mixed chartGetTopTags(array $params = ['limit', 'page'])
 * @method mixed chartGetTopTracks(array $params = ['limit', 'page'])
 * @method mixed geoGetTopArtists(array $params = ['country', 'location', 'limit', 'page'])
 * @method mixed geoGetTopTracks(array $params = ['country', 'location', 'limit', 'page'])
 * @method mixed libraryGetArtists(array $params = ['user', 'limit', 'page'])
 * @method mixed tagGetInfo(array $params = ['tag', 'lang'])
 * @method mixed tagGetSimilar(array $params = ['tag'])
 * @method mixed tagGetTopAlbums(array $params = ['tag', 'limit', 'page'])
 * @method mixed tagGetTopArtists(array $params = ['tag', 'limit', 'page'])
 * @method mixed tagGetTopTags()
 * @method mixed tagGetTopTracks(array $params = ['tag', 'limit', 'page'])
 * @method mixed tagGetWeeklyChartList(array $params = ['tag'])
 * @method mixed trackAddTags(array $body = ['mbid', 'artist', 'track', 'tags'])
 * @method mixed trackGetCorrection(array $params = ['artist', 'track'])
 * @method mixed trackGetInfo(array $params = ['mbid', 'artist', 'track', 'username', 'autocorrect'])
 * @method mixed trackGetSimilar(array $params = ['mbid', 'artist', 'track', 'autocorrect', 'limit'])
 * @method mixed trackGetTags(array $params = ['mbid', 'artist', 'track', 'autocorrect', 'user'])
 * @method mixed trackGetTopTags(array $params = ['mbid', 'artist', 'track', 'autocorrect'])
 * @method mixed trackLove(array $body = ['mbid', 'artist', 'track'])
 * @method mixed trackRemoveTag(array $body = ['mbid', 'artist', 'track', 'tag'])
 * @method mixed trackSearch(array $params = ['artist', 'track', 'limit', 'page'])
 * @method mixed trackUnlove(array $body = ['mbid', 'artist', 'track'])
 * @method mixed trackUpdateNowPlaying(array $body = ['mbid', 'artist', 'track', 'album', 'trackNumber', 'context', 'duration', 'albumArtist'])
 * @method mixed userGetArtistTracks(array $params = ['user', 'artist', 'limit', 'page', 'startTimestamp', 'endTimestamp'])
 * @method mixed userGetFriends(array $params = ['user', 'limit', 'page', 'recenttracks'])
 * @method mixed userGetInfo(array $params = ['user'])
 * @method mixed userGetLovedTracks(array $params = ['user', 'limit', 'page'])
 * @method mixed userGetPersonalTags(array $params = ['user', 'limit', 'page', 'tag', 'taggingtype'])
 * @method mixed userGetRecentTracks(array $params = ['user', 'limit', 'page', 'from', 'to', 'extended'])
 * @method mixed userGetTopAlbums(array $params = ['user', 'limit', 'page', 'period'])
 * @method mixed userGetTopArtists(array $params = ['user', 'limit', 'page', 'period'])
 * @method mixed userGetTopTags(array $params = ['user', 'limit', 'page'])
 * @method mixed userGetWeeklyAlbumChart(array $params = ['user', 'from', 'to'])
 * @method mixed userGetWeeklyArtistChart(array $params = ['user', 'from', 'to'])
 * @method mixed userGetWeeklyTrackChart(array $params = ['user', 'from', 'to'])
 */
class LastFM extends OAuthProvider{

	const PERIOD_OVERALL = 'overall';
	const PERIOD_7DAY    = '7day';
	const PERIOD_1MONTH  = '1month';
	const PERIOD_3MONTH  = '3month';
	const PERIOD_6MONTH  = '6month';
	const PERIOD_12MONTH = '12month';

	const PERIODS = [
		self::PERIOD_OVERALL,
		self::PERIOD_7DAY,
		self::PERIOD_1MONTH,
		self::PERIOD_3MONTH,
		self::PERIOD_6MONTH,
		self::PERIOD_12MONTH,
	];

	protected $apiURL    = 'https://ws.audioscrobbler.com/2.0';
	protected $authURL   = 'https://www.last.fm/api/auth';

	/**
	 * @param array $additionalParameters
	 *
	 * @return string
	 */
	public function getAuthURL(array $additionalParameters = []):string {
		$additionalParameters = array_merge($additionalParameters, [
			'api_key' => $this->options->key,
		]);

		return $this->authURL.'?'.http_build_query($additionalParameters);
	}

	/**
	 * @param string $token
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function getAccessToken(string $token):Token {

		$params = [
			'method'  => 'auth.getSession',
			'format'  => 'json',
			'api_key' => $this->options->key,
			'token'   => $token,
		];

		$params['api_sig'] = $this->getSignature($params);

		$response = $this->http->request($this->apiURL, $params)->json_array;

		switch(true){
			case !is_array($response):
				throw new OAuthException('unable to parse access token response');
			case isset($response['error']):
				throw new OAuthException('access token error: '.$response['message']);
			case !isset($response['session']['key']):
				throw new OAuthException('access token missing');
		}

		$token = new Token([
			'accessToken' => $response['session']['key'],
			'expires'     => Token::EOL_NEVER_EXPIRES,
		]);

		unset($response['session']['key']);

		$token->extraParams = $response;

		$this->storage->storeAccessToken($this->serviceName, $token);

		return $token;
	}

	/**
	 * @param string $path
	 * @param array  $params
	 * @param string $method
	 * @param null   $body
	 * @param array  $headers
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function request(string $path, array $params = [], string $method = 'GET', $body = null, array $headers = []):OAuthResponse{

		$params = array_merge($params, $body ?? [], [
			'method'  => $path,
			'format'  => 'json',
			'api_key' => $this->options->key,
			'sk'      => $this->storage->retrieveAccessToken($this->serviceName)->accessToken,
		]);

		$params['api_sig'] = $this->getSignature($params);

		if($method === 'POST'){
			$body = $params;
			$params = [];
		}

		return $this->http->request($this->apiURL, $params, $method, $body, $headers);
	}

	/**
	 * @param array $params
	 *
	 * @return string
	 */
	protected function getSignature(array $params):string {
		ksort($params);

		$signature = '';

		foreach($params as $k => $v){
			if(!in_array($k, ['format', 'callback'])){
				$signature .= $k.$v;
			}
		}

		return md5($signature.$this->options->secret);
	}

}
