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
class Discord extends OAuth2Provider{

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

	protected $apiURL              = 'https://discordapp.com/api/v6';
	protected $authURL             = 'https://discordapp.com/api/oauth2/authorize';
	protected $userRevokeURL       = 'https://discordapp.com/api/oauth2/token/revoke';
	protected $accessTokenEndpoint = 'https://discordapp.com/api/oauth2/token';
	protected $accessTokenExpires  = true;
	protected $authMethod          = self::HEADER_BEARER;

	/**
	 * @link https://discordapp.com/developers/docs/topics/oauth2#client-credentials-grant
	 *
	 * @param array $scopes
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function requestCredentialsToken(array $scopes = []){

		$token = $this->parseResponse(
			$this->http->request(
				$this->accessTokenEndpoint,
				[],
				'POST',
				[
					'grant_type'    => 'client_credentials',
					'scope'         => implode($this->scopesDelimiter, $scopes),
				],
				[
					'Authorization' => 'Basic '.base64_encode($this->options->key.':'.$this->options->secret),
				]
			)
		);

		$this->storage->storeAccessToken($this->serviceName, $token);

		return $token;
	}

}
