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

use chillerlan\OAuth\Token;

/**
 * @link https://api.guildwars2.com/v2
 * @link https://wiki.guildwars2.com/wiki/API:Main
 *
 * GW2 does not support authentication (anymore) but the API still works like a regular OAUth API, so...
 *
 * @method \chillerlan\OAuth\HTTP\OAuthResponse account(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountAchievements(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountBank(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountDungeons(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountDyes(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountFinishers(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountGliders(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountHomeCats(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountHomeNodes(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountInventory(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountMailcarriers(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountMasteries(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountMasteryPoints(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountMaterials(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountMinis(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountOutfits(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountPvpHeroes(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountRaids(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountRecipes(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountSkins(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountTitles(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountWallet(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse achievements(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse achievementsCategories(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse achievementsCategoriesId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse achievementsDaily()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse achievementsDailyTomorrow()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse achievementsGroups(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse achievementsGroupsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse achievementsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse backstoryAnswers(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse backstoryAnswersId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse backstoryQuestions(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse backstoryQuestionsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse build()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse cats()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse catsId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse characters(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse charactersId($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse charactersIdBackstory($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse charactersIdCore($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse charactersIdCrafting($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse charactersIdEquipment($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse charactersIdHeropoints($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse charactersIdInventory($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse charactersIdRecipes($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse charactersIdSab($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse charactersIdSkills($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse charactersIdSpecializations($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse charactersIdTraining($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse colors(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse colorsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commerceDelivery(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commerceExchange()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commerceExchangeCoins(array $params = ['quantity'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commerceExchangeGems(array $params = ['quantity'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commerceListings()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commerceListingsId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commercePrices()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commercePricesId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commerceTransactions(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commerceTransactionsCurrent()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commerceTransactionsCurrentBuys()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commerceTransactionsCurrentSells()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commerceTransactionsHistory()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commerceTransactionsHistoryBuys()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commerceTransactionsHistorySells()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse continents(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse continentsContinentId($continent_id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse continentsContinentIdFloors($continent_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse continentsContinentIdFloorsFloorId($continent_id, $floor_id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse continentsContinentIdFloorsFloorIdRegions($continent_id, $floor_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse continentsContinentIdFloorsFloorIdRegionsRegionId($continent_id, $floor_id, $region_id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse continentsContinentIdFloorsFloorIdRegionsRegionIdMaps($continent_id, $floor_id, $region_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse continentsContinentIdFloorsFloorIdRegionsRegionIdMapsMapId($continent_id, $floor_id, $region_id, $map_id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse currencies(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse currenciesId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse dungeons(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse dungeonsId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse emblem()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse emblemBackgrounds()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse emblemBackgroundsId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse emblemForegrounds()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse emblemForegroundsId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse files()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse filesId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse finishers(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse finishersId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse gliders(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse glidersId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse guildId($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse guildIdLog($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse guildIdMembers($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse guildIdRanks($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse guildIdStash($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse guildIdStorage($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse guildIdTeams($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse guildIdTreasury($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse guildIdUpgrades($id, array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse guildPermissions(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse guildPermissionsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse guildSearch()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse guildUpgrades(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse guildUpgradesId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse items(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse itemsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse itemstats(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse itemstatsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse legends()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse legendsId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mailcarriers(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mailcarriersId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse maps(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mapsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse masteries(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse masteriesId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse materials(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse materialsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse minis(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse minisId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse nodes()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse nodesId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse outfits(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse outfitsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pets(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse petsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse professions(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse professionsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvp()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvpAmulets(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvpAmuletsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvpGames(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvpHeroes(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvpHeroesId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvpRacesId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvpRanks(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvpRanksId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvpSeasons(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvpSeasonsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvpSeasonsIdLeaderboards($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvpSeasonsIdLeaderboardsBoardIdRegionId($id, $board, $region)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvpStandings(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pvpStats(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse quaggans()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse quaggansId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse races(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse raids(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse raidsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse recipes()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse recipesId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse recipesSearch()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse skills(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse skillsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse skins(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse skinsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse specializations(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse specializationsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse stories(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse storiesId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse storiesSeasons(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse storiesSeasonsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse titles(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse titlesId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tokeninfo(array $params = ['access_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse traits(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse traitsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse worlds(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse worldsId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwAbilities(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwAbilitiesId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwMatches()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwMatchesId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwMatchesOverview()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwMatchesOverviewId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwMatchesScores()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwMatchesScoresId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwMatchesStats()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwMatchesStatsId($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwMatchesStatsIdGuildsGuildId($id, $guild_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwMatchesStatsIdTeamsTeamIdTopKdr($id, $team)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwMatchesStatsIdTeamsTeamIdTopKills($id, $team)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwObjectives(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwObjectivesId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwRanks(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwRanksId($id, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwUpgrades(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse wvwUpgradesId($id, array $params = ['lang'])
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

	/**
	 * @param string $access_token
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\Providers\ProviderException
	 */
	public function storeGW2Token(string $access_token):Token{
		$tokeninfo = $this->tokeninfo(['access_token' => $access_token])->json;

		if(isset($tokeninfo->id) && strpos($access_token, $tokeninfo->id) === 0){

			$token = new Token([
				'accessToken'       => $access_token,
				'accessTokenSecret' => substr($access_token, 36, 36), // the actual token
				'expires'           => Token::EOL_NEVER_EXPIRES,
				'extraParams'       => [
					'token_type' => 'Bearer',
					'id'         => $tokeninfo->id,
					'name'       => $tokeninfo->name,
					'scope'      => implode($this->scopesDelimiter, $tokeninfo->permissions),
				],
			]);

			$this->storage->storeAccessToken($this->serviceName, $token);

			return $token;
		}

		throw new ProviderException('invalid/unverified token');
	}

}
