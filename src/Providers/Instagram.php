<?php
/**
 * Class Instagram
 *
 * @filesource   Instagram.php
 * @created      10.07.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://www.instagram.com/developer/endpoints/
 * @link https://www.instagram.com/developer/authentication/
 *
 * @method \chillerlan\OAuth\HTTP\OAuthResponse locationRecentMedia(string $location_id, array $params = ['max_id', 'min_id', 'count'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse locations(string $location_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse media(string $media_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mediaAddComment(string $media_id, array $params = ['text'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mediaComments(string $media_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mediaLike(string $media_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mediaLikes(string $media_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mediaRemoveComment(string $media_id, string $comment_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mediaShortcode(string $shortcode)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mediaUnlike(string $media_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse profile(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse recentMedia(string $user_id, array $params = ['max_id', 'min_id', 'count'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse relationship(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse relationshipUpdate(string $user_id, array $params = ['action'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse searchLocations(array $params = ['lat', 'lng', 'distance', 'facebook_places_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse searchMedia(array $params = ['lat', 'lng', 'distance'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse searchTags(array $params = ['q'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse searchUser(array $params = ['q', 'count'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse selfFollowedBy()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse selfFollows()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse selfMediaLiked(array $params = ['max_like_id', 'count'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse selfRequestedBy()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tags(string $tagname)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagsRecentMedia(string $tagname, array $params = ['max_tag_id', 'min_tag_id', 'count'])
 */
class Instagram extends OAuth2Provider{

	const SCOPE_BASIC          = 'basic';
	const SCOPE_COMMENTS       = 'comments';
	const SCOPE_RELATIONSHIPS  = 'relationships';
	const SCOPE_LIKES          = 'likes';
	const SCOPE_PUBLIC_CONTENT = 'public_content';
	const SCOPE_FOLLOWER_LIST  = 'follower_list';

	protected $apiURL         = 'https://api.instagram.com/v1';
	protected $authURL        = 'https://api.instagram.com/oauth/authorize';
	protected $accessTokenURL = 'https://api.instagram.com/oauth/access_token';
	protected $userRevokeURL  = 'https://www.instagram.com/accounts/manage_access/';
	protected $authMethod     = self::QUERY_ACCESS_TOKEN;

}
