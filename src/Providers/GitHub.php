<?php
/**
 * Class GitHub
 *
 * @filesource   GitHub.php
 * @created      22.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://developer.github.com/apps/building-integrations/setting-up-and-registering-oauth-apps/
 * @link https://developer.github.com/v3/
 *
 */
class GitHub extends OAuth2Provider implements CSRFToken{

	const SCOPE_USER             = 'user';
	const SCOPE_USER_EMAIL       = 'user:email';
	const SCOPE_USER_FOLLOW      = 'user:follow';
	const SCOPE_PUBLIC_REPO      = 'public_repo';
	const SCOPE_REPO             = 'repo';
	const SCOPE_REPO_DEPLOYMENT  = 'repo_deployment';
	const SCOPE_REPO_STATUS      = 'repo:status';
	const SCOPE_REPO_INVITE      = 'repo:invite';
	const SCOPE_REPO_DELETE      = 'delete_repo';
	const SCOPE_NOTIFICATIONS    = 'notifications';
	const SCOPE_GIST             = 'gist';
	const SCOPE_REPO_HOOK_READ   = 'read:repo_hook';
	const SCOPE_REPO_HOOK_WRITE  = 'write:repo_hook';
	const SCOPE_REPO_HOOK_ADMIN  = 'admin:repo_hook';
	const SCOPE_ORG_HOOK_ADMIN   = 'admin:org_hook';
	const SCOPE_ORG_READ         = 'read:org';
	const SCOPE_ORG_WRITE        = 'write:org';
	const SCOPE_ORG_ADMIN        = 'admin:org';
	const SCOPE_PUBLIC_KEY_READ  = 'read:public_key';
	const SCOPE_PUBLIC_KEY_WRITE = 'write:public_key';
	const SCOPE_PUBLIC_KEY_ADMIN = 'admin:public_key';
	const SCOPE_GPG_KEY_READ     = 'read:gpg_key';
	const SCOPE_GPG_KEY_WRITE    = 'write:gpg_key';
	const SCOPE_GPG_KEY_ADMIN    = 'admin:gpg_key';

	protected $apiURL         = 'https://api.github.com';
	protected $authURL        = 'https://github.com/login/oauth/authorize';
	protected $accessTokenURL = 'https://github.com/login/oauth/access_token';
	protected $userRevokeURL  = 'https://github.com/settings/applications';
	protected $authHeaders    = ['Accept' => 'application/json'];
	protected $apiHeaders     = ['Accept' => 'application/vnd.github.beta+json'];

}
