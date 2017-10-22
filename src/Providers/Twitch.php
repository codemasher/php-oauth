<?php
/**
 * Class Twitch
 *
 * @filesource   Twitch.php
 * @created      22.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://dev.twitch.tv/docs
 * @link https://dev.twitch.tv/docs/v5/guides/authentication/
 *
 */
class Twitch extends OAuth2Provider{

	const SCOPE_CHANNEL_CHECK_SUBSCRIPTION = 'channel_check_subscription';
	const SCOPE_CHANNEL_COMMERCIAL         = 'channel_commercial';
	const SCOPE_CHANNEL_EDITOR             = 'channel_editor';
	const SCOPE_CHANNEL_FEED_EDIT          = 'channel_feed_edit';
	const SCOPE_CHANNEL_FEED_READ          = 'channel_feed_read';
	const SCOPE_CHANNEL_CHANNEL_READ       = 'channel_read';
	const SCOPE_CHANNEL_CHANNEL_STREAM     = 'channel_stream';
	const SCOPE_CHANNEL_SUBSCRIPTIONS      = 'channel_subscriptions';
	const SCOPE_CHAT_LOGIN                 = 'chat_login';
	const SCOPE_COLLECTIONS_EDIT           = 'collections_edit';
	const SCOPE_COMMUNITIES_EDIT           = 'communities_edit';
	const SCOPE_COMMUNITIES_MODERATE       = 'communities_moderate';
	const SCOPE_OPENID                     = 'openid';
	const SCOPE_USER_BLOCKS_EDIT           = 'user_blocks_edit';
	const SCOPE_USER_BLOCKS_READ           = 'user_blocks_read';
	const SCOPE_USER_FOLLOWS_EDIT          = 'user_follows_edit';
	const SCOPE_USER_READ                  = 'user_read';
	const SCOPE_USER_SUBSCRIPTIONS         = 'user_subscriptions';
	const SCOPE_VIEWING_ACTIVITY_READ      = 'viewing_activity_read';

	protected $apiURL              = 'https://api.twitch.tv/kraken';
	protected $authURL             = 'https://api.twitch.tv/kraken/oauth2/authorize';
	protected $userRevokeURL       = 'https://www.twitch.tv/settings/connections';
	protected $revokeURL           = 'https://api.twitch.tv/kraken/oauth2/revoke';
	protected $accessTokenEndpoint = 'https://api.twitch.tv/kraken/oauth2/token';
	protected $accessTokenExpires  = true;
	protected $authHeaders         = ['Accept' => 'application/vnd.twitchtv.v5+json'];
	protected $apiHeaders          = ['Accept' => 'application/vnd.twitchtv.v5+json'];
	protected $authMethod          = self::HEADER_OAUTH; // -> https://api.twitch.tv/kraken
#	protected $authMethod          = self::HEADER_BEARER; // -> https://api.twitch.tv/helix

	/**
	 * @link https://dev.twitch.tv/docs/authentication#oauth-client-credentials-flow-app-access-tokens
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
					'client_id'     => $this->options->key,
					'client_secret' => $this->options->secret,
					'grant_type'    => 'client_credentials',
					'scope'         => implode($this->scopesDelimiter, $scopes),
				])
		);

		$this->storage->storeAccessToken($this->serviceName, $token);

		return $token;
	}

}
