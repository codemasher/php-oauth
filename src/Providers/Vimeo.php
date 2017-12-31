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
 * @method \chillerlan\OAuth\HTTP\OAuthResponse me()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse meLikeVideo(string $video_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse meLikes(array $params = ['filter', 'filter_embeddable', 'query', 'page', 'per_page', 'sort', 'direction'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse meLikesContains(string $video_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse meUnlikeVideo(string $video_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse ondemandLikes(string $ondemand_id, array $params = ['filter', 'query', 'page', 'per_page', 'sort', 'direction'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse user(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userActivities(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userAlbums(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userAppearances(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userCategories(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userChannels(string $user_id, array $params = ['moderated'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userFeed(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userFollowers(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userFollowing(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userFollowingContains(string $user_id, string $follow_user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userGroups(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userLikeVideo(string $user_id, string $video_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userLikes(string $user_id, array $params = ['filter', 'filter_embeddable', 'query', 'page', 'per_page', 'sort', 'direction'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userLikesContains(string $user_id, string $video_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userPicture(string $user_id, string $portraitset_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userPictures(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userPortfolio(string $user_id, string $portfolio_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userPortfolioContains(string $user_id, string $portfolio_id, string $video_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userPortfolioVideos(string $user_id, string $portfolio_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userPortfolios(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userPreset(string $user_id, string $preset_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userPresetVideos(string $user_id, string $preset_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userPresets(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userSearch(array $params = ['query', 'page', 'per_page', 'sort', 'direction'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userServiceConnection(string $user_id, string $service_type, string $service_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userServices(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userSharedVideos(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userTriggers(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userUnlikeVideo(string $user_id, string $video_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userVideos(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userWatchlater(string $user_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse userWatchlaterContains(string $user_id, string $video_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse verify()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse videoLikes(string $video_id, array $params = ['query', 'page', 'per_page', 'sort', 'direction'])
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

	protected $apiURL                    = 'https://api.vimeo.com';
	protected $authURL                   = 'https://api.vimeo.com/oauth/authorize';
	protected $accessTokenURL            = 'https://api.vimeo.com/oauth/access_token';
	protected $userRevokeURL             = 'https://vimeo.com/settings/apps';
	protected $revokeURL                 = 'https://api.vimeo.com/tokens';
	protected $accessTokenExpires        = true;
	protected $authHeaders               = ['Accept' => 'application/vnd.vimeo.*+json;version='.self::VERSION];
	protected $apiHeaders                = ['Accept' => 'application/vnd.vimeo.*+json;version='.self::VERSION];
	protected $clientCredentials         = true;
	protected $clientCredentialsTokenURL = 'https://api.vimeo.com/oauth/authorize/client';

}
