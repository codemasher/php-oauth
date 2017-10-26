<?php
/**
 * Class Vimeo
 *
 * @filesource   Vimeo.php
 * @created      10.07.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://developer.vimeo.com/
 * @link https://developer.vimeo.com/api/authentication
 *
 * @method mixed me()
 * @method mixed meLikeVideo(string $video_id)
 * @method mixed meLikes(array $params = ['filter', 'filter_embeddable', 'query', 'page', 'per_page', 'sort', 'direction'])
 * @method mixed meLikesContains(string $video_id)
 * @method mixed meUnlikeVideo(string $video_id)
 * @method mixed ondemandLikes(string $ondemand_id, array $params = ['filter', 'query', 'page', 'per_page', 'sort', 'direction'])
 * @method mixed user(string $user_id)
 * @method mixed userActivities(string $user_id)
 * @method mixed userAlbums(string $user_id)
 * @method mixed userAppearances(string $user_id)
 * @method mixed userCategories(string $user_id)
 * @method mixed userChannels(string $user_id, array $params = ['moderated'])
 * @method mixed userFeed(string $user_id)
 * @method mixed userFollowers(string $user_id)
 * @method mixed userFollowing(string $user_id)
 * @method mixed userFollowingContains(string $user_id, string $follow_user_id)
 * @method mixed userGroups(string $user_id)
 * @method mixed userLikeVideo(string $user_id, string $video_id)
 * @method mixed userLikes(string $user_id, array $params = ['filter', 'filter_embeddable', 'query', 'page', 'per_page', 'sort', 'direction'])
 * @method mixed userLikesContains(string $user_id, string $video_id)
 * @method mixed userPicture(string $user_id, string $portraitset_id)
 * @method mixed userPictures(string $user_id)
 * @method mixed userPortfolio(string $user_id, string $portfolio_id)
 * @method mixed userPortfolioContains(string $user_id, string $portfolio_id, string $video_id)
 * @method mixed userPortfolioVideos(string $user_id, string $portfolio_id)
 * @method mixed userPortfolios(string $user_id)
 * @method mixed userPreset(string $user_id, string $preset_id)
 * @method mixed userPresetVideos(string $user_id, string $preset_id)
 * @method mixed userPresets(string $user_id)
 * @method mixed userSearch(array $params = ['query', 'page', 'per_page', 'sort', 'direction'])
 * @method mixed userServiceConnection(string $user_id, string $service_type, string $service_id)
 * @method mixed userServices(string $user_id)
 * @method mixed userSharedVideos(string $user_id)
 * @method mixed userTriggers(string $user_id)
 * @method mixed userUnlikeVideo(string $user_id, string $video_id)
 * @method mixed userVideos(string $user_id)
 * @method mixed userWatchlater(string $user_id)
 * @method mixed userWatchlaterContains(string $user_id, string $video_id)
 * @method mixed verify()
 * @method mixed videoLikes(string $video_id, array $params = ['query', 'page', 'per_page', 'sort', 'direction'])
 */
class Vimeo extends OAuth2Provider{

	const SCOPE_PRIVATE     = 'private';
	const SCOPE_PUBLIC      = 'public';
	const SCOPE_PURCHASED   = 'purchased';
	const SCOPE_PURCHASE    = 'purchase';
	const SCOPE_CREATE      = 'create';
	const SCOPE_EDIT        = 'edit';
	const SCOPE_DELETE      = 'delete';
	const SCOPE_INTERACT    = 'interact';
	const SCOPE_UPLOAD      = 'upload';
	const SCOPE_PROMO_CODES = 'promo_codes';
	const SCOPE_VIDEO_FILES = 'video_files';

	const VERSION = '3.2';

	protected $apiURL              = 'https://api.vimeo.com';
	protected $authURL             = 'https://api.vimeo.com/oauth/authorize';
	protected $userRevokeURL       = 'https://vimeo.com/settings/apps';
	protected $revokeURL           = 'https://api.vimeo.com/tokens';
	protected $accessTokenEndpoint = 'https://api.vimeo.com/oauth/access_token';
	protected $accessTokenExpires  = true;
	protected $authHeaders         = ['Accept' => 'application/vnd.vimeo.*+json;version='.self::VERSION];
	protected $apiHeaders          = ['Accept' => 'application/vnd.vimeo.*+json;version='.self::VERSION];
	protected $authMethod          = self::HEADER_BEARER;

	// https://developer.vimeo.com/api/authentication#generate-unauthenticated-tokens
	protected $clientCredentials   = true;
	protected $ccTokenEndpoint     = 'https://api.vimeo.com/oauth/authorize/client';

}
