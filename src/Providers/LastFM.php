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

use chillerlan\OAuth\Token;
use chillerlan\HTTP\HTTPResponseInterface;

/**
 * @link https://www.last.fm/api/authentication
 *
 * @method \chillerlan\HTTP\HTTPResponseInterface albumAddTags(array $body = ['mbid', 'album', 'artist', 'tags'])
 * @method \chillerlan\HTTP\HTTPResponseInterface albumGetInfo(array $params = ['mbid', 'album', 'artist', 'username', 'lang', 'autocorrect'])
 * @method \chillerlan\HTTP\HTTPResponseInterface albumGetTags(array $params = ['mbid', 'album', 'artist', 'user', 'autocorrect'])
 * @method \chillerlan\HTTP\HTTPResponseInterface albumGetTopTags(array $params = ['mbid', 'album', 'artist', 'autocorrect'])
 * @method \chillerlan\HTTP\HTTPResponseInterface albumRemoveTag(array $body = ['mbid', 'album', 'artist', 'tag'])
 * @method \chillerlan\HTTP\HTTPResponseInterface albumSearch(array $params = ['album', 'limit', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface artistAddTags(array $body = ['mbid', 'artist', 'tags'])
 * @method \chillerlan\HTTP\HTTPResponseInterface artistGetCorrection(array $params = ['artist'])
 * @method \chillerlan\HTTP\HTTPResponseInterface artistGetInfo(array $params = ['mbid', 'artist', 'username', 'lang', 'autocorrect'])
 * @method \chillerlan\HTTP\HTTPResponseInterface artistGetSimilar(array $params = ['mbid', 'artist', 'limit', 'autocorrect'])
 * @method \chillerlan\HTTP\HTTPResponseInterface artistGetTags(array $params = ['mbid', 'artist', 'user', 'autocorrect'])
 * @method \chillerlan\HTTP\HTTPResponseInterface artistGetTopAlbums(array $params = ['mbid', 'artist', 'autocorrect', 'page', 'limit'])
 * @method \chillerlan\HTTP\HTTPResponseInterface artistGetTopTags(array $params = ['mbid', 'artist', 'autocorrect'])
 * @method \chillerlan\HTTP\HTTPResponseInterface artistGetTopTracks(array $params = ['mbid', 'artist', 'autocorrect', 'page', 'limit'])
 * @method \chillerlan\HTTP\HTTPResponseInterface artistRemoveTag(array $body = ['mbid', 'artist', 'tag'])
 * @method \chillerlan\HTTP\HTTPResponseInterface artistSearch(array $params = ['artist', 'limit', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface chartGetTopArtists(array $params = ['limit', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface chartGetTopTags(array $params = ['limit', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface chartGetTopTracks(array $params = ['limit', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface geoGetTopArtists(array $params = ['country', 'location', 'limit', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface geoGetTopTracks(array $params = ['country', 'location', 'limit', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface libraryGetArtists(array $params = ['user', 'limit', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tagGetInfo(array $params = ['tag', 'lang'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tagGetSimilar(array $params = ['tag'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tagGetTopAlbums(array $params = ['tag', 'limit', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tagGetTopArtists(array $params = ['tag', 'limit', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tagGetTopTags()
 * @method \chillerlan\HTTP\HTTPResponseInterface tagGetTopTracks(array $params = ['tag', 'limit', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tagGetWeeklyChartList(array $params = ['tag'])
 * @method \chillerlan\HTTP\HTTPResponseInterface trackAddTags(array $body = ['mbid', 'artist', 'track', 'tags'])
 * @method \chillerlan\HTTP\HTTPResponseInterface trackGetCorrection(array $params = ['artist', 'track'])
 * @method \chillerlan\HTTP\HTTPResponseInterface trackGetInfo(array $params = ['mbid', 'artist', 'track', 'username', 'autocorrect'])
 * @method \chillerlan\HTTP\HTTPResponseInterface trackGetSimilar(array $params = ['mbid', 'artist', 'track', 'autocorrect', 'limit'])
 * @method \chillerlan\HTTP\HTTPResponseInterface trackGetTags(array $params = ['mbid', 'artist', 'track', 'autocorrect', 'user'])
 * @method \chillerlan\HTTP\HTTPResponseInterface trackGetTopTags(array $params = ['mbid', 'artist', 'track', 'autocorrect'])
 * @method \chillerlan\HTTP\HTTPResponseInterface trackLove(array $body = ['mbid', 'artist', 'track'])
 * @method \chillerlan\HTTP\HTTPResponseInterface trackRemoveTag(array $body = ['mbid', 'artist', 'track', 'tag'])
 * @method \chillerlan\HTTP\HTTPResponseInterface trackSearch(array $params = ['artist', 'track', 'limit', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface trackUnlove(array $body = ['mbid', 'artist', 'track'])
 * @method \chillerlan\HTTP\HTTPResponseInterface trackUpdateNowPlaying(array $body = ['mbid', 'artist', 'track', 'album', 'trackNumber', 'context', 'duration', 'albumArtist'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userGetArtistTracks(array $params = ['user', 'artist', 'limit', 'page', 'startTimestamp', 'endTimestamp'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userGetFriends(array $params = ['user', 'limit', 'page', 'recenttracks'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userGetInfo(array $params = ['user'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userGetLovedTracks(array $params = ['user', 'limit', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userGetPersonalTags(array $params = ['user', 'limit', 'page', 'tag', 'taggingtype'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userGetRecentTracks(array $params = ['user', 'limit', 'page', 'from', 'to', 'extended'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userGetTopAlbums(array $params = ['user', 'limit', 'page', 'period'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userGetTopArtists(array $params = ['user', 'limit', 'page', 'period'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userGetTopTags(array $params = ['user', 'limit', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userGetWeeklyAlbumChart(array $params = ['user', 'from', 'to'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userGetWeeklyArtistChart(array $params = ['user', 'from', 'to'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userGetWeeklyTrackChart(array $params = ['user', 'from', 'to'])
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
	public function getAuthURL(array $params = null):string {

		$params = array_merge($params ?? [], [
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
		return $this->parseTokenResponse($this->httpGET($this->apiURL, $this->getAccessTokenParams($session_token)));
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
	 * @param \chillerlan\HTTP\HTTPResponseInterface $response
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\Providers\ProviderException
	 */
	protected function parseTokenResponse(HTTPResponseInterface $response):Token {
		$data = $response->json_array;

		if(!$data || !is_array($data)){
			throw new ProviderException('unable to parse token response');
		}
		elseif(isset($data['error'])){
			throw new ProviderException('error retrieving access token: '.$data['message']);
		}
		elseif(!isset($data['session']['key'])){
			throw new ProviderException('token missing');
		}

		$token = new Token([
			'provider'    => $this->serviceName,
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
	 * @return \chillerlan\HTTP\HTTPResponseInterface
	 */
	public function request(string $path, array $params = null, string $method = null, $body = null, array $headers = null):HTTPResponseInterface{
		$method = $method ?? 'GET';

		$params = $this->requestParams($path, $params ?? [], $body ?? []);

		if($method === 'POST'){
			$body = $params;
			$params = [];
		}

		return $this->httpRequest($this->apiURL, $params, $method, $body, $headers);
	}

	/**
	 * @todo
	 *
	 * @param array $tracks
	 */
#	public function scrobble(array $tracks){}

}
