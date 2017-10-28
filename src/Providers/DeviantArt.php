<?php
/**
 * Class DeviantArt
 *
 * @filesource   DeviantArt.php
 * @created      26.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://www.deviantart.com/developers/authentication
 */
class DeviantArt extends OAuth2Provider{

	const SCOPE_BASIC        = 'basic';
	const SCOPE_BROWSE       = 'browse';
	const SCOPE_COLLECTION   = 'collection';
	const SCOPE_COMMENT_POST = 'comment.post';
	const SCOPE_FEED         = 'feed';
	const SCOPE_GALLERY      = 'gallery';
	const SCOPE_MESSAGE      = 'message';
	const SCOPE_NOTE         = 'note';
	const SCOPE_STASH        = 'stash';
	const SCOPE_USER         = 'user';
	const SCOPE_USER_MANAGE  = 'user.manage';

	protected $apiURL              = 'https://www.deviantart.com/api/v1/oauth2';
	protected $authURL             = 'https://www.deviantart.com/oauth2/authorize';
	protected $accessTokenEndpoint = 'https://www.deviantart.com/oauth2/token';
	protected $accessTokenExpires  = true;
	protected $clientCredentials   = true;

}
