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
 * @link https://developer.spotify.com/web-api/
 *
 * @method mixed album(string $id, array $params = ['market'])
 * @method mixed albumTracks(string $id, array $params = ['limit', 'offset', 'market'])
 * @method mixed albums(array $params = ['ids', 'market'])
 * @method mixed artist(string $id)
 * @method mixed artistAlbums(string $id, array $params = ['album_type', 'limit', 'offset', 'market'])
 * @method mixed artistRelatedArtists(string $id)
 * @method mixed artistTopTracks(string $id, array $params = ['country'])
 * @method mixed artists(array $params = ['ids'])
 * @method mixed audioAnalysis(string $id)
 * @method mixed audioFeatures(string $id)
 * @method mixed audioFeaturesAll(array $params = ['ids'])
 * @method mixed categories(array $params = ['locale', 'country', 'limit', 'offset'])
 * @method mixed category(string $category_id, array $params = ['locale', 'country'])
 * @method mixed categoryPlaylists(string $category_id, array $params = ['locale', 'country'])
 * @method mixed createPlaylist(string $user_id, $body = null)
 * @method mixed devices()
 * @method mixed featuredPlaylists(array $params = ['locale', 'country', 'timestamp', 'limit', 'offset'])
 * @method mixed follow(array $params = ['type', 'ids'], $body = null)
 * @method mixed followPlaylist(string $owner_id, string $playlist_id, $body = null)
 * @method mixed me()
 * @method mixed meFollowersContains(array $params = ['type', 'ids'])
 * @method mixed meFollowing(array $params = ['type', 'after', 'limit'])
 * @method mixed mePlaylists(array $params = ['limit', 'offset'])
 * @method mixed meSavedAlbums(array $params = ['market', 'limit', 'offset'])
 * @method mixed meSavedAlbumsContains(array $params = ['ids'])
 * @method mixed meSavedTracks(array $params = ['market', 'limit', 'offset'])
 * @method mixed meSavedTracksContains(array $params = ['ids'])
 * @method mixed meTop(string $type, array $params = ['time_range', 'limit', 'offset'])
 * @method mixed newReleases(array $params = ['locale', 'country', 'limit', 'offset'])
 * @method mixed next(array $params = ['device_id'])
 * @method mixed nowPlaying(array $params = ['market'])
 * @method mixed pause(array $params = ['device_id'])
 * @method mixed play(array $params = ['device_id'], $body = null)
 * @method mixed playlistAddTracks(string $user_id, string $playlist_id, array $params = ['uris', 'position'], $body = null)
 * @method mixed playlistRemoveTracks(string $user_id, string $playlist_id, array $params = ['tracks'], $body = null)
 * @method mixed playlistReorderTracks(string $user_id, string $playlist_id, $body = null)
 * @method mixed playlistReplaceTracks(string $user_id, string $playlist_id, $body = null)
 * @method mixed playlistUpdateDetails(string $user_id, string $playlist_id, $body = null)
 * @method mixed previous(array $params = ['device_id'])
 * @method mixed recentlyPlayed(array $params = ['limit', 'offset', 'after', 'before'])
 * @method mixed recommendations(array $params = ['limit', 'market', 'seed_artists', 'seed_genres', 'seed_tracks', 'max_*', 'min_*', 'target_*'])
 * @method mixed removeSavedAlbums(array $params = ['ids'], $body = null)
 * @method mixed removeSavedTracks(array $params = ['ids'], $body = null)
 * @method mixed repeat(array $params = ['state', 'device_id'])
 * @method mixed saveAlbums(array $params = ['ids'], $body = null)
 * @method mixed saveTracks(array $params = ['ids'], $body = null)
 * @method mixed search(array $params = ['q', 'type', 'market', 'limit', 'offset'])
 * @method mixed seek(array $params = ['position_ms', 'device_id'])
 * @method mixed shuffle(array $params = ['state', 'device_id'])
 * @method mixed track(string $id, array $params = ['market'])
 * @method mixed tracks(array $params = ['ids', 'market'])
 * @method mixed transfer($body = null)
 * @method mixed unfollow(array $params = ['type', 'ids'], $body = null)
 * @method mixed unfollowPlaylist(string $owner_id, string $playlist_id, $body = null)
 * @method mixed user(string $user_id)
 * @method mixed userPlaylist(string $user_id, string $playlist_id, array $params = ['fields', 'market'])
 * @method mixed userPlaylistFollowersContains(string $owner_id, string $playlist_id, array $params = ['ids'])
 * @method mixed userPlaylistTracks(string $user_id, string $playlist_id, array $params = ['fields', 'market', 'limit', 'offset'])
 * @method mixed userPlaylists(string $user_id, array $params = ['limit', 'offset'])
 * @method mixed volume(array $params = ['volume_percent', 'device_id'])
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
	protected $clientCredentials   = true;

}
