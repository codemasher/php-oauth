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
 *
 * @method mixed account(array $params = ['access_token'])
 * @method mixed accountAchievements(array $params = ['access_token'])
 * @method mixed accountBank(array $params = ['access_token'])
 * @method mixed accountDungeons(array $params = ['access_token'])
 * @method mixed accountDyes(array $params = ['access_token'])
 * @method mixed accountFinishers(array $params = ['access_token'])
 * @method mixed accountGliders(array $params = ['access_token'])
 * @method mixed accountHomeCats(array $params = ['access_token'])
 * @method mixed accountHomeNodes(array $params = ['access_token'])
 * @method mixed accountInventory(array $params = ['access_token'])
 * @method mixed accountMailcarriers(array $params = ['access_token'])
 * @method mixed accountMasteries(array $params = ['access_token'])
 * @method mixed accountMasteryPoints(array $params = ['access_token'])
 * @method mixed accountMaterials(array $params = ['access_token'])
 * @method mixed accountMinis(array $params = ['access_token'])
 * @method mixed accountOutfits(array $params = ['access_token'])
 * @method mixed accountPvpHeroes(array $params = ['access_token'])
 * @method mixed accountRaids(array $params = ['access_token'])
 * @method mixed accountRecipes(array $params = ['access_token'])
 * @method mixed accountSkins(array $params = ['access_token'])
 * @method mixed accountTitles(array $params = ['access_token'])
 * @method mixed accountWallet(array $params = ['access_token'])
 * @method mixed achievements(array $params = ['lang'])
 * @method mixed achievementsCategories(array $params = ['lang'])
 * @method mixed achievementsDaily()
 * @method mixed achievementsDailyTomorrow()
 * @method mixed achievementsGroups(array $params = ['lang'])
 * @method mixed backstoryAnswers(array $params = ['lang'])
 * @method mixed backstoryQuestions(array $params = ['lang'])
 * @method mixed build()
 * @method mixed cats()
 * @method mixed characters(array $params = ['access_token'])
 * @method mixed charactersIdBackstory($id, array $params = ['access_token'])
 * @method mixed charactersIdCore($id, array $params = ['access_token'])
 * @method mixed charactersIdCrafting($id, array $params = ['access_token'])
 * @method mixed charactersIdEquipment($id, array $params = ['access_token'])
 * @method mixed charactersIdHeropoints($id, array $params = ['access_token'])
 * @method mixed charactersIdInventory($id, array $params = ['access_token'])
 * @method mixed charactersIdRecipes($id, array $params = ['access_token'])
 * @method mixed charactersIdSab($id, array $params = ['access_token'])
 * @method mixed charactersIdSkills($id, array $params = ['access_token'])
 * @method mixed charactersIdSpecializations($id, array $params = ['access_token'])
 * @method mixed charactersIdTraining($id, array $params = ['access_token'])
 * @method mixed commerceDelivery(array $params = ['access_token'])
 * @method mixed commerceExchange()
 * @method mixed commerceListings()
 * @method mixed commercePrices()
 * @method mixed commerceTransactions(array $params = ['access_token'])
 * @method mixed continents(array $params = ['lang'])
 * @method mixed continentsContinentId($continent_id, array $params = ['lang'])
 * @method mixed continentsContinentIdFloors($continent_id)
 * @method mixed continentsContinentIdFloorsFloorId($continent_id, $floor_id, array $params = ['lang'])
 * @method mixed continentsContinentIdFloorsFloorIdRegions($continent_id, $floor_id)
 * @method mixed continentsContinentIdFloorsFloorIdRegionsRegionId($continent_id, $floor_id, $region_id, array $params = ['lang'])
 * @method mixed continentsContinentIdFloorsFloorIdRegionsRegionIdMaps($continent_id, $floor_id, $region_id)
 * @method mixed continentsContinentIdFloorsFloorIdRegionsRegionIdMapsMapId($continent_id, $floor_id, $region_id, $map_id, array $params = ['lang'])
 * @method mixed currencies(array $params = ['lang'])
 * @method mixed dungeons(array $params = ['lang'])
 * @method mixed emblem()
 * @method mixed files()
 * @method mixed finishers(array $params = ['lang'])
 * @method mixed gliders(array $params = ['lang'])
 * @method mixed guildId($id, array $params = ['access_token'])
 * @method mixed guildIdLog($id, array $params = ['access_token'])
 * @method mixed guildIdMembers($id, array $params = ['access_token'])
 * @method mixed guildIdRanks($id, array $params = ['access_token'])
 * @method mixed guildIdStash($id, array $params = ['access_token'])
 * @method mixed guildIdStorage($id, array $params = ['access_token'])
 * @method mixed guildIdTeams($id, array $params = ['access_token'])
 * @method mixed guildIdTreasury($id, array $params = ['access_token'])
 * @method mixed guildIdUpgrades($id, array $params = ['access_token'])
 * @method mixed guildPermissions(array $params = ['lang'])
 * @method mixed guildSearch()
 * @method mixed guildUpgrades(array $params = ['lang'])
 * @method mixed items(array $params = ['lang'])
 * @method mixed itemstats(array $params = ['lang'])
 * @method mixed legends()
 * @method mixed mailcarriers(array $params = ['lang'])
 * @method mixed maps(array $params = ['lang'])
 * @method mixed masteries(array $params = ['lang'])
 * @method mixed materials(array $params = ['lang'])
 * @method mixed minis(array $params = ['lang'])
 * @method mixed nodes()
 * @method mixed outfits(array $params = ['lang'])
 * @method mixed pets(array $params = ['lang'])
 * @method mixed professions(array $params = ['lang'])
 * @method mixed pvp()
 * @method mixed pvpAmulets(array $params = ['lang'])
 * @method mixed pvpGames(array $params = ['access_token'])
 * @method mixed pvpHeroes(array $params = ['lang'])
 * @method mixed pvpRanks(array $params = ['lang'])
 * @method mixed pvpSeasons(array $params = ['lang'])
 * @method mixed pvpSeasonsIdLeaderboards($id)
 * @method mixed pvpSeasonsIdLeaderboardsBoardIdRegionId($id, $board, $region)
 * @method mixed pvpStandings(array $params = ['access_token'])
 * @method mixed pvpStats(array $params = ['access_token'])
 * @method mixed quaggans()
 * @method mixed races(array $params = ['lang'])
 * @method mixed raids(array $params = ['lang'])
 * @method mixed recipes()
 * @method mixed recipesSearch()
 * @method mixed skills(array $params = ['lang'])
 * @method mixed skins(array $params = ['lang'])
 * @method mixed specializations(array $params = ['lang'])
 * @method mixed stories(array $params = ['lang'])
 * @method mixed storiesSeasons(array $params = ['lang'])
 * @method mixed titles(array $params = ['lang'])
 * @method mixed tokeninfo(array $params = ['access_token'])
 * @method mixed traits(array $params = ['lang'])
 * @method mixed worlds(array $params = ['lang'])
 * @method mixed wvwAbilities(array $params = ['lang'])
 * @method mixed wvwMatches()
 * @method mixed wvwMatchesOverview()
 * @method mixed wvwMatchesScores()
 * @method mixed wvwMatchesStats()
 * @method mixed wvwMatchesStatsIdGuildsGuildId($id, $guild_id)
 * @method mixed wvwMatchesStatsIdTeamsTeamIdTopKdr($id, $team)
 * @method mixed wvwMatchesStatsIdTeamsTeamIdTopKills($id, $team)
 * @method mixed wvwObjectives(array $params = ['lang'])
 * @method mixed wvwRanks(array $params = ['lang'])
 * @method mixed wvwUpgrades(array $params = ['lang'])
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
