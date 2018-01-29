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
 * @method \chillerlan\HTTP\HTTPResponseInterface me()
 * @method \chillerlan\HTTP\HTTPResponseInterface meLikeVideo(string $video_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface meLikes(array $params = ['filter', 'filter_embeddable', 'query', 'page', 'per_page', 'sort', 'direction'])
 * @method \chillerlan\HTTP\HTTPResponseInterface meLikesContains(string $video_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface meUnlikeVideo(string $video_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface ondemandLikes(string $ondemand_id, array $params = ['filter', 'query', 'page', 'per_page', 'sort', 'direction'])
 * @method \chillerlan\HTTP\HTTPResponseInterface user(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userActivities(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userAlbums(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userAppearances(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userCategories(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userChannels(string $user_id, array $params = ['moderated'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userFeed(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userFollowers(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userFollowing(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userFollowingContains(string $user_id, string $follow_user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userGroups(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userLikeVideo(string $user_id, string $video_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userLikes(string $user_id, array $params = ['filter', 'filter_embeddable', 'query', 'page', 'per_page', 'sort', 'direction'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userLikesContains(string $user_id, string $video_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userPicture(string $user_id, string $portraitset_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userPictures(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userPortfolio(string $user_id, string $portfolio_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userPortfolioContains(string $user_id, string $portfolio_id, string $video_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userPortfolioVideos(string $user_id, string $portfolio_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userPortfolios(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userPreset(string $user_id, string $preset_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userPresetVideos(string $user_id, string $preset_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userPresets(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userSearch(array $params = ['query', 'page', 'per_page', 'sort', 'direction'])
 * @method \chillerlan\HTTP\HTTPResponseInterface userServiceConnection(string $user_id, string $service_type, string $service_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userServices(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userSharedVideos(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userTriggers(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userUnlikeVideo(string $user_id, string $video_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userVideos(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userWatchlater(string $user_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface userWatchlaterContains(string $user_id, string $video_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface verify()
 * @method \chillerlan\HTTP\HTTPResponseInterface videoLikes(string $video_id, array $params = ['query', 'page', 'per_page', 'sort', 'direction'])
 */
class Vimeo extends OAuth2Provider implements ClientCredentials, CSRFToken, TokenExpires{
	use OAuth2ClientCredentialsTrait;

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

	protected $apiURL                    = 'https://api.vimeo.com';
	protected $authURL                   = 'https://api.vimeo.com/oauth/authorize';
	protected $accessTokenURL            = 'https://api.vimeo.com/oauth/access_token';
	protected $userRevokeURL             = 'https://vimeo.com/settings/apps';
	protected $revokeURL                 = 'https://api.vimeo.com/tokens';
	protected $authHeaders               = ['Accept' => 'application/vnd.vimeo.*+json;version='.self::VERSION];
	protected $apiHeaders                = ['Accept' => 'application/vnd.vimeo.*+json;version='.self::VERSION];
	protected $clientCredentialsTokenURL = 'https://api.vimeo.com/oauth/authorize/client';

}
