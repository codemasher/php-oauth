<?php
/**
 * Class GuildWars2
 *
 * @filesource   GuildWars2.php
 * @created      22.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

/**
 * @link https://api.guildwars2.com/v2
 *
 * GW2 does not support authentication (anymore) but the API still works like a regular OAUth API, so...
 */
class GuildWars2 extends OAuth2Provider{

	const SCOPE_ACCOUNT     = 'account';
	const SCOPE_INVENTORIES = 'inventories';
	const SCOPE_CHARACTERS  = 'characters';
	const SCOPE_TRADINGPOST = 'tradingpost';
	const SCOPE_WALLET      = 'wallet';
	const SCOPE_UNLOCKS     = 'unlocks';
	const SCOPE_PVP         = 'pvp';
	const SCOPE_BUILDS      = 'builds';
	const SCOPE_PROGRESSION = 'progression';
	const SCOPE_GUILDS      = 'guilds';

	protected $apiURL        = 'https://api.guildwars2.com/v2';
	protected $authURL       = 'https://account.arena.net/applications/create';
	protected $userRevokeURL = 'https://account.arena.net/applications';
	protected $authMethod    = self::HEADER_BEARER;

}
