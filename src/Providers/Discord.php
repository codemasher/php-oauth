<?php
/**
 * Class Discord
 *
 * @filesource   Discord.php
 * @created      22.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://discordapp.com/developers/docs/topics/oauth2
 */
class Discord extends OAuth2Provider implements ClientCredentials, CSRFToken, TokenExpires, TokenRefresh{
	use OAuth2ClientCredentialsTrait, OAuth2TokenRefreshTrait;

	const SCOPE_BOT                    = 'bot';
	const SCOPE_CONNECTIONS            = 'connections';
	const SCOPE_EMAIL                  = 'email';
	const SCOPE_IDENTIFY               = 'identify';
	const SCOPE_GUILDS                 = 'guilds';
	const SCOPE_GUILDS_JOIN            = 'guilds.join';
	const SCOPE_GDM_JOIN               = 'gdm.join';
	const SCOPE_MESSAGES_READ          = 'messages.read';
	const SCOPE_RPC                    = 'rpc';
	const SCOPE_RPC_API                = 'rpc.api';
	const SCOPE_RPC_NOTIFICATIONS_READ = 'rpc.notifications.read';
	const SCOPE_WEBHOOK_INCOMING       = 'webhook.incoming';

	protected $apiURL             = 'https://discordapp.com/api/v6';
	protected $authURL            = 'https://discordapp.com/api/oauth2/authorize';
	protected $accessTokenURL     = 'https://discordapp.com/api/oauth2/token';
	protected $revokeURL          = 'https://discordapp.com/api/oauth2/token/revoke';

}
