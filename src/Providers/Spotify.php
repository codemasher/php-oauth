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
 * @method \chillerlan\HTTP\HTTPResponseInterface album(string $id, array $params = ['market'])
 * @method \chillerlan\HTTP\HTTPResponseInterface albumTracks(string $id, array $params = ['limit', 'offset', 'market'])
 * @method \chillerlan\HTTP\HTTPResponseInterface albums(array $params = ['ids', 'market'])
 * @method \chillerlan\HTTP\HTTPResponseInterface artist(string $id)
 * @method \chillerlan\HTTP\HTTPResponseInterface artistAlbums(string $id, array $params = ['album_type', 'limit', 'offset', 'market'])
 * @method \chillerlan\HTTP\HTTPResponseInterface artistRelatedArtists(string $id)
 * @method \chillerlan\HTTP\HTTPResponseInterface artistTopTracks(string $id, array $params = ['country'])
 * @method \chillerlan\HTTP\HTTPResponseInterface artists(array $params = ['ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface audioAnalysis(string $id)
 * @method \chillerlan\HTTP\HTTPResponseInterface audioFeatures(string $id)
 * @method \chillerlan\HTTP\HTTPResponseInterface audioFeaturesAll(array $params = ['ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface categories(array $params = ['locale', 'country', 'limit', 'offset'])
 * @method \chillerlan\HTTP\HTTPResponseInterface category(string $category_id, array $params = ['locale', 'country'])
 * @method \chillerlan\HTTP\HTTPResponseInterface categoryPlaylists(string $category_id, array $params = ['locale', 'country'])
 * @method \chillerlan\HTTP\HTTPResponseInterface devices()
 * @method \chillerlan\HTTP\HTTPResponseInterface featuredPlaylists(array $params = ['locale', 'country', 'timestamp', 'limit', 'offset'])
 * @method \chillerlan\HTTP\HTTPResponseInterface follow(array $params = ['ids', 'type'], array $body = ['ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface followPlaylist(string $owner_id, string $playlist_id, array $body = ['public'])
 * @method \chillerlan\HTTP\HTTPResponseInterface me()
 * @method \chillerlan\HTTP\HTTPResponseInterface meFollowing(array $params = ['type', 'after', 'limit'])
 * @method \chillerlan\HTTP\HTTPResponseInterface meFollowingContains(array $params = ['type', 'ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface mePlaylists(array $params = ['limit', 'offset'])
 * @method \chillerlan\HTTP\HTTPResponseInterface meSavedAlbums(array $params = ['market', 'limit', 'offset'])
 * @method \chillerlan\HTTP\HTTPResponseInterface meSavedAlbumsContains(array $params = ['ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface meSavedTracks(array $params = ['market', 'limit', 'offset'])
 * @method \chillerlan\HTTP\HTTPResponseInterface meSavedTracksContains(array $params = ['ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface meTop(string $type, array $params = ['time_range', 'limit', 'offset'])
 * @method \chillerlan\HTTP\HTTPResponseInterface newReleases(array $params = ['locale', 'country', 'limit', 'offset'])
 * @method \chillerlan\HTTP\HTTPResponseInterface next(array $params = ['device_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface nowPlaying(array $params = ['market'])
 * @method \chillerlan\HTTP\HTTPResponseInterface pause(array $params = ['device_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface play(array $params = ['device_id'], array $body = ['context_uri', 'uris', 'offset'])
 * @method \chillerlan\HTTP\HTTPResponseInterface playlistAddTracks(string $user_id, string $playlist_id, array $body = ['uris', 'position'])
 * @method \chillerlan\HTTP\HTTPResponseInterface playlistCreate(string $user_id, array $body = ['name', 'description', 'public', 'collaborative'])
 * @method \chillerlan\HTTP\HTTPResponseInterface playlistRemoveTracks(string $user_id, string $playlist_id, array $body = ['tracks', 'positions', 'snapshot_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface playlistReorderTracks(string $user_id, string $playlist_id, array $body = ['range_start', 'range_length', 'insert_before', 'snapshot_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface playlistReplaceTracks(string $user_id, string $playlist_id, array $body = ['uris'])
 * @method \chillerlan\HTTP\HTTPResponseInterface playlistUpdateDetails(string $user_id, string $playlist_id, array $body = ['name', 'description', 'public', 'collaborative'])
 * @method \chillerlan\HTTP\HTTPResponseInterface previous(array $params = ['device_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface recentlyPlayed(array $params = ['limit', 'offset', 'after', 'before'])
 * @method \chillerlan\HTTP\HTTPResponseInterface recommendations(array $params = ['limit', 'market', 'seed_artists', 'seed_genres', 'seed_tracks', 'max_*', 'min_*', 'target_*'])
 * @method \chillerlan\HTTP\HTTPResponseInterface removeSavedAlbums(array $body = ['ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface removeSavedTracks(array $body = ['ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface repeat(array $params = ['state', 'device_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface saveAlbums(array $body = ['ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface saveTracks(array $body = ['ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface search(array $params = ['q', 'type', 'market', 'limit', 'offset'])
 * @method \chillerlan\HTTP\HTTPResponseInterface seek(array $params = ['position_ms', 'device_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface shuffle(array $params = ['state', 'device_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface track(string $id, array $params = ['market'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tracks(array $params = ['ids', 'market'])
 * @method \chillerlan\HTTP\HTTPResponseInterface transfer(array $body = ['device_ids', 'play'])
 * @method \chillerlan\HTTP\HTTPResponseInterface unfollow(array $params = ['ids', 'type'], array $body = ['ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface unfollowPlaylist(string $owner_id, string $playlist_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface user(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userPlaylist(string $user_id, string $playlist_id, array $params = ['fields', 'market'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userPlaylistFollowersContains(string $owner_id, string $playlist_id, array $params = ['ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userPlaylistTracks(string $user_id, string $playlist_id, array $params = ['fields', 'market', 'limit', 'offset'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userPlaylists(string $user_id, array $params = ['limit', 'offset'])
 * @method \chillerlan\HTTP\HTTPResponseInterface volume(array $params = ['volume_percent', 'device_id'])
 */
class Spotify extends OAuth2Provider implements ClientCredentials, CSRFToken, TokenExpires, TokenRefresh{
	use OAuth2ClientCredentialsTrait, OAuth2TokenRefreshTrait;

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

}
