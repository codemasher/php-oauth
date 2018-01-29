<?php
/**
 * Class Slack
 *
 * @filesource   Slack.php
 * @created      26.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://api.slack.com/docs/oauth
 * @link https://api.slack.com/docs/sign-in-with-slack
 * @link https://api.slack.com/docs/token-types
 */
class Slack extends OAuth2Provider implements CSRFToken{

	// bot token
	const SCOPE_BOT                 = 'bot';

	// user token
	const SCOPE_ADMIN               = 'admin';
	const SCOPE_CHAT_WRITE_BOT      = 'chat:write:bot';
	const SCOPE_CLIENT              = 'client';
	const SCOPE_DND_READ            = 'dnd:read';
	const SCOPE_DND_WRITE           = 'dnd:write';
	const SCOPE_FILES_READ          = 'files:read';
	const SCOPE_FILES_WRITE_USER    = 'files:write:user';
	const SCOPE_IDENTIFY            = 'identify';
	const SCOPE_IDENTITY_AVATAR     = 'identity.avatar';
	const SCOPE_IDENTITY_BASIC      = 'identity.basic';
	const SCOPE_IDENTITY_EMAIL      = 'identity.email';
	const SCOPE_IDENTITY_TEAM       = 'identity.team';
	const SCOPE_INCOMING_WEBHOOK    = 'incoming-webhook';
	const SCOPE_POST                = 'post';
	const SCOPE_READ                = 'read';
	const SCOPE_REMINDERS_READ      = 'reminders:read';
	const SCOPE_REMINDERS_WRITE     = 'reminders:write';
	const SCOPE_SEARCH_READ         = 'search:read';
	const SCOPE_STARS_READ          = 'stars:read';
	const SCOPE_STARS_WRITE         = 'stars:write';

	// user & workspace tokens
	const SCOPE_CHANNELS_HISTORY    = 'channels:history';
	const SCOPE_CHANNELS_READ       = 'channels:read';
	const SCOPE_CHANNELS_WRITE      = 'channels:write';
	const SCOPE_CHAT_WRITE_USER     = 'chat:write:user';
	const SCOPE_COMMANDS            = 'commands';
	const SCOPE_EMOJI_READ          = 'emoji:read';
	const SCOPE_GROUPS_HISTORY      = 'groups:history';
	const SCOPE_GROUPS_READ         = 'groups:read';
	const SCOPE_GROUPS_WRITE        = 'groups:write';
	const SCOPE_IM_HISTORY          = 'im:history';
	const SCOPE_IM_READ             = 'im:read';
	const SCOPE_IM_WRITE            = 'im:write';
	const SCOPE_LINKS_READ          = 'links:read';
	const SCOPE_LINKS_WRITE         = 'links:write';
	const SCOPE_MPIM_HISTORY        = 'mpim:history';
	const SCOPE_MPIM_READ           = 'mpim:read';
	const SCOPE_MPIM_WRITE          = 'mpim:write';
	const SCOPE_PINS_READ           = 'pins:read';
	const SCOPE_PINS_WRITE          = 'pins:write';
	const SCOPE_REACTIONS_READ      = 'reactions:read';
	const SCOPE_REACTIONS_WRITE     = 'reactions:write';
	const SCOPE_TEAM_READ           = 'team:read';
	const SCOPE_USERGROUPS_READ     = 'usergroups:read';
	const SCOPE_USERGROUPS_WRITE    = 'usergroups:write';
	const SCOPE_USERS_PROFILE_READ  = 'users.profile:read';
	const SCOPE_USERS_PROFILE_WRITE = 'users.profile:write';
	const SCOPE_USERS_READ          = 'users:read';
	const SCOPE_USERS_READ_EMAIL    = 'users:read.email';
	const SCOPE_USERS_WRITE         = 'users:write';

	protected $apiURL         = 'https://slack.com/api';
	protected $authURL        = 'https://slack.com/oauth/authorize';
	protected $accessTokenURL = 'https://slack.com/api/oauth.access';
	protected $userRevokeURL  = 'https://{WORKSPACE}.slack.com/apps/manage';

}
