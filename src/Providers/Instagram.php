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
 * @method mixed locationRecentMedia(string $location_id, array $params = ['max_id', 'min_id', 'count'])
 * @method mixed locations(string $location_id)
 * @method mixed media(string $media_id)
 * @method mixed mediaAddComment(string $media_id, array $params = ['text'])
 * @method mixed mediaComments(string $media_id)
 * @method mixed mediaLike(string $media_id)
 * @method mixed mediaLikes(string $media_id)
 * @method mixed mediaRemoveComment(string $media_id, string $comment_id)
 * @method mixed mediaShortcode(string $shortcode)
 * @method mixed mediaUnlike(string $media_id)
 * @method mixed profile(string $user_id)
 * @method mixed recentMedia(string $user_id, array $params = ['max_id', 'min_id', 'count'])
 * @method mixed relationship(string $user_id)
 * @method mixed relationshipUpdate(string $user_id, array $params = ['action'])
 * @method mixed searchLocations(array $params = ['lat', 'lng', 'distance', 'facebook_places_id'])
 * @method mixed searchMedia(array $params = ['lat', 'lng', 'distance'])
 * @method mixed searchTags(array $params = ['q'])
 * @method mixed searchUser(array $params = ['q', 'count'])
 * @method mixed selfFollowedBy()
 * @method mixed selfFollows()
 * @method mixed selfMediaLiked(array $params = ['max_like_id', 'count'])
 * @method mixed selfRequestedBy()
 * @method mixed tags(string $tagname)
 * @method mixed tagsRecentMedia(string $tagname, array $params = ['max_tag_id', 'min_tag_id', 'count'])
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
