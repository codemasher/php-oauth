<?php
/**
 * Class Spotify
 *
 * @filesource   Spotify.php
 * @created      10.07.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://developer.spotify.com/web-api/authorization-guide/
 *
 * @method \chillerlan\OAuth\HTTP\OAuthResponse album(string $id, array $params = ['market'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse albumTracks(string $id, array $params = ['limit', 'offset', 'market'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse albums(array $params = ['ids', 'market'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artist(string $id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artistAlbums(string $id, array $params = ['album_type', 'limit', 'offset', 'market'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artistRelatedArtists(string $id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artistTopTracks(string $id, array $params = ['country'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse artists(array $params = ['ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse audioAnalysis(string $id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse audioFeatures(string $id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse audioFeaturesAll(array $params = ['ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse categories(array $params = ['locale', 'country', 'limit', 'offset'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse category(string $category_id, array $params = ['locale', 'country'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse categoryPlaylists(string $category_id, array $params = ['locale', 'country'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse devices()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse featuredPlaylists(array $params = ['locale', 'country', 'timestamp', 'limit', 'offset'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse follow(array $params = ['ids', 'type'], array $body = ['ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse followPlaylist(string $owner_id, string $playlist_id, array $body = ['public'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse me()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse meFollowing(array $params = ['type', 'after', 'limit'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse meFollowingContains(array $params = ['type', 'ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mePlaylists(array $params = ['limit', 'offset'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse meSavedAlbums(array $params = ['market', 'limit', 'offset'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse meSavedAlbumsContains(array $params = ['ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse meSavedTracks(array $params = ['market', 'limit', 'offset'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse meSavedTracksContains(array $params = ['ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse meTop(string $type, array $params = ['time_range', 'limit', 'offset'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse newReleases(array $params = ['locale', 'country', 'limit', 'offset'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse next(array $params = ['device_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse nowPlaying(array $params = ['market'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pause(array $params = ['device_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse play(array $params = ['device_id'], array $body = ['context_uri', 'uris', 'offset'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse playlistAddTracks(string $user_id, string $playlist_id, array $body = ['uris', 'position'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse playlistCreate(string $user_id, array $body = ['name', 'description', 'public', 'collaborative'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse playlistRemoveTracks(string $user_id, string $playlist_id, array $body = ['tracks', 'positions', 'snapshot_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse playlistReorderTracks(string $user_id, string $playlist_id, array $body = ['range_start', 'range_length', 'insert_before', 'snapshot_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse playlistReplaceTracks(string $user_id, string $playlist_id, array $body = ['uris'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse playlistUpdateDetails(string $user_id, string $playlist_id, array $body = ['name', 'description', 'public', 'collaborative'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse previous(array $params = ['device_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse recentlyPlayed(array $params = ['limit', 'offset', 'after', 'before'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse recommendations(array $params = ['limit', 'market', 'seed_artists', 'seed_genres', 'seed_tracks', 'max_*', 'min_*', 'target_*'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse removeSavedAlbums(array $body = ['ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse removeSavedTracks(array $body = ['ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse repeat(array $params = ['state', 'device_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse saveAlbums(array $body = ['ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse saveTracks(array $body = ['ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse search(array $params = ['q', 'type', 'market', 'limit', 'offset'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse seek(array $params = ['position_ms', 'device_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse shuffle(array $params = ['state', 'device_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse track(string $id, array $params = ['market'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tracks(array $params = ['ids', 'market'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse transfer(array $body = ['device_ids', 'play'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse unfollow(array $params = ['ids', 'type'], array $body = ['ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse unfollowPlaylist(string $owner_id, string $playlist_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse user(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userPlaylist(string $user_id, string $playlist_id, array $params = ['fields', 'market'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userPlaylistFollowersContains(string $owner_id, string $playlist_id, array $params = ['ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userPlaylistTracks(string $user_id, string $playlist_id, array $params = ['fields', 'market', 'limit', 'offset'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userPlaylists(string $user_id, array $params = ['limit', 'offset'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse volume(array $params = ['volume_percent', 'device_id'])
 */
class Spotify extends OAuth2Provider{

	const SCOPE_PLAYLIST_READ_PRIVATE       = 'playlist-read-private';
	const SCOPE_PLAYLIST_READ_COLLABORATIVE = 'playlist-read-collaborative';
	const SCOPE_PLAYLIST_MODIFY_PUBLIC      = 'playlist-modify-public';
	const SCOPE_PLAYLIST_MODIFY_PRIVATE     = 'playlist-modify-private';
	const SCOPE_USER_FOLLOW_MODIFY          = 'user-follow-modify';
	const SCOPE_USER_FOLLOW_READ            = 'user-follow-read';
	const SCOPE_USER_LIBRARY_READ           = 'user-library-read';
	const SCOPE_USER_LIBRARY_MODIFY         = 'user-library-modify';
	const SCOPE_USER_TOP_READ               = 'user-top-read';
	const SCOPE_USER_READ_PRIVATE           = 'user-read-private';
	const SCOPE_USER_READ_BIRTHDATE         = 'user-read-birthdate';
	const SCOPE_USER_READ_EMAIL             = 'user-read-email';
	const SCOPE_USER_READ_CURRENTLY_PLAYING = 'user-read-currently-playing';
	const SCOPE_USER_READ_RECENTLY_PLAYED   = 'user-read-recently-played';
	const SCOPE_USER_READ_PLAYBACK_STATE    = 'user-read-playback-state';
	const SCOPE_USER_MODIFY_PLAYBACK_STATE  = 'user-modify-playback-state';
	const SCOPE_STREAMING                   = 'streaming';

	// @todo -> recommendations
	const TRACK_ATTRIBUTES = [
		'acousticness',
		'danceability',
		'duration_ms',
		'energy',
		'instrumentalness',
		'key',
		'liveness',
		'loudness',
		'mode',
		'popularity',
		'speechiness',
		'tempo',
		'time_signature',
		'valence',
	];

	protected $apiURL             = 'https://api.spotify.com/v1';
	protected $authURL            = 'https://accounts.spotify.com/authorize';
	protected $accessTokenURL     = 'https://accounts.spotify.com/api/token';
	protected $userRevokeURL      = 'https://www.spotify.com/account/apps/';
	protected $accessTokenExpires = true;
	protected $clientCredentials  = true;
	protected $accessTokenRefreshable = true;

}
