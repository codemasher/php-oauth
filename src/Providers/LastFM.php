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

use chillerlan\OAuth\{
	Token, HTTP\OAuthResponse
};

/**
 * @link https://www.last.fm/api/authentication
 *
 * @method \chillerlan\OAuth\HTTP\OAuthResponse albumAddTags(array $body = ['mbid', 'album', 'artist', 'tags'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse albumGetInfo(array $params = ['mbid', 'album', 'artist', 'username', 'lang', 'autocorrect'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse albumGetTags(array $params = ['mbid', 'album', 'artist', 'user', 'autocorrect'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse albumGetTopTags(array $params = ['mbid', 'album', 'artist', 'autocorrect'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse albumRemoveTag(array $body = ['mbid', 'album', 'artist', 'tag'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse albumSearch(array $params = ['album', 'limit', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artistAddTags(array $body = ['mbid', 'artist', 'tags'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artistGetCorrection(array $params = ['artist'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artistGetInfo(array $params = ['mbid', 'artist', 'username', 'lang', 'autocorrect'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artistGetSimilar(array $params = ['mbid', 'artist', 'limit', 'autocorrect'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artistGetTags(array $params = ['mbid', 'artist', 'user', 'autocorrect'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artistGetTopAlbums(array $params = ['mbid', 'artist', 'autocorrect', 'page', 'limit'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artistGetTopTags(array $params = ['mbid', 'artist', 'autocorrect'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artistGetTopTracks(array $params = ['mbid', 'artist', 'autocorrect', 'page', 'limit'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artistRemoveTag(array $body = ['mbid', 'artist', 'tag'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artistSearch(array $params = ['artist', 'limit', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse chartGetTopArtists(array $params = ['limit', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse chartGetTopTags(array $params = ['limit', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse chartGetTopTracks(array $params = ['limit', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse geoGetTopArtists(array $params = ['country', 'location', 'limit', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse geoGetTopTracks(array $params = ['country', 'location', 'limit', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse libraryGetArtists(array $params = ['user', 'limit', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagGetInfo(array $params = ['tag', 'lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagGetSimilar(array $params = ['tag'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagGetTopAlbums(array $params = ['tag', 'limit', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagGetTopArtists(array $params = ['tag', 'limit', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagGetTopTags()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagGetTopTracks(array $params = ['tag', 'limit', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagGetWeeklyChartList(array $params = ['tag'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse trackAddTags(array $body = ['mbid', 'artist', 'track', 'tags'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse trackGetCorrection(array $params = ['artist', 'track'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse trackGetInfo(array $params = ['mbid', 'artist', 'track', 'username', 'autocorrect'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse trackGetSimilar(array $params = ['mbid', 'artist', 'track', 'autocorrect', 'limit'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse trackGetTags(array $params = ['mbid', 'artist', 'track', 'autocorrect', 'user'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse trackGetTopTags(array $params = ['mbid', 'artist', 'track', 'autocorrect'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse trackLove(array $body = ['mbid', 'artist', 'track'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse trackRemoveTag(array $body = ['mbid', 'artist', 'track', 'tag'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse trackSearch(array $params = ['artist', 'track', 'limit', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse trackUnlove(array $body = ['mbid', 'artist', 'track'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse trackUpdateNowPlaying(array $body = ['mbid', 'artist', 'track', 'album', 'trackNumber', 'context', 'duration', 'albumArtist'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userGetArtistTracks(array $params = ['user', 'artist', 'limit', 'page', 'startTimestamp', 'endTimestamp'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userGetFriends(array $params = ['user', 'limit', 'page', 'recenttracks'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userGetInfo(array $params = ['user'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userGetLovedTracks(array $params = ['user', 'limit', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userGetPersonalTags(array $params = ['user', 'limit', 'page', 'tag', 'taggingtype'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userGetRecentTracks(array $params = ['user', 'limit', 'page', 'from', 'to', 'extended'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userGetTopAlbums(array $params = ['user', 'limit', 'page', 'period'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userGetTopArtists(array $params = ['user', 'limit', 'page', 'period'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userGetTopTags(array $params = ['user', 'limit', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userGetWeeklyAlbumChart(array $params = ['user', 'from', 'to'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userGetWeeklyArtistChart(array $params = ['user', 'from', 'to'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userGetWeeklyTrackChart(array $params = ['user', 'from', 'to'])
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

	protected $apiURL        = 'https://ws.audioscrobbler.com/2.0';
	protected $authURL       = 'https://www.last.fm/api/auth';
	protected $userRevokeURL = 'https://www.last.fm/settings'; // ???

	/**
	 * @inheritdoc
	 */
	public function getAuthURL(array $params = []):string {

		$params = array_merge($params, [
			'api_key' => $this->options->key,
		]);

		return $this->authURL.'?'.$this->buildHttpQuery($params);
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

	/**
	 * @param string $session_token
	 *
	 * @return \chillerlan\OAuth\Token
	 */
	public function getAccessToken(string $session_token):Token {
		return $this->parseTokenResponse(
			$this->http->request($this->apiURL, $this->getAccessTokenParams($session_token))
		);
	}

	/**
	 * @param string $session_token
	 *
	 * @return array
	 */
	protected function getAccessTokenParams(string $session_token):array {

		$params = [
			'method'  => 'auth.getSession',
			'format'  => 'json',
			'api_key' => $this->options->key,
			'token'   => $session_token,
		];

		$params['api_sig'] = $this->getSignature($params);

		return $params;
	}

	/**
	 * @param \chillerlan\OAuth\HTTP\OAuthResponse $response
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\Providers\ProviderException
	 */
	protected function parseTokenResponse(OAuthResponse $response):Token {
		$data = $response->json_array;

		if(!$data || !is_array($data)){
			throw new ProviderException('unable to parse token response'.PHP_EOL.print_r($response, true));
		}
		elseif(isset($data['error'])){
			throw new ProviderException('error retrieving access token: '.$data['message']);
		}
		elseif(!isset($data['session']['key'])){
			throw new ProviderException('token missing');
		}

		$token = new Token([
			'accessToken' => $data['session']['key'],
			'expires'     => Token::EOL_NEVER_EXPIRES,
		]);

		unset($data['session']['key']);

		$token->extraParams = $data;

		$this->storage->storeAccessToken($this->serviceName, $token);

		return $token;
	}

	/**
	 * @param string $apiMethod
	 * @param array  $params
	 * @param array  $body
	 *
	 * @return array
	 */
	protected function requestParams(string $apiMethod, array $params, array $body):array {

		$params = array_merge($params, $body, [
			'method'  => $apiMethod,
			'format'  => 'json',
			'api_key' => $this->options->key,
			'sk'      => $this->storage->retrieveAccessToken($this->serviceName)->accessToken,
		]);

		$params['api_sig'] = $this->getSignature($params);

		return $params;
	}

	/**
	 * @param string $path
	 * @param array  $params
	 * @param string $method
	 * @param null   $body
	 * @param array  $headers
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 */
	public function request(string $path, array $params = null, string $method = null, $body = null, array $headers = null):OAuthResponse{
		$method = $method ?? 'GET';

		$params = $this->requestParams($path, $params ?? [], $body ?? []);

		if($method === 'POST'){
			$body = $params;
			$params = [];
		}

		return $this->http->request($this->apiURL, $params, $method, $body, $headers);
	}

	/**
	 * @todo
	 *
	 * @param array $tracks
	 */
#	public function scrobble(array $tracks){}

}
