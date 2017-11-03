<?php
/**
 * Class Twitter
 *
 * @filesource   Twitter.php
 * @created      09.07.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

use chillerlan\OAuth\HTTP\OAuthResponse;

/**
 * @link https://dev.twitter.com/rest/reference
 * @link https://developer.twitter.com/en/docs/basics/authentication/overview/oauth
 *
 * @todo
 * POST account/update_profile_background_image
 * POST account/update_profile_banner
 * POST account/update_profile_image
 *
 * POST media/metadata/create
 * GET  media/upload (STATUS)
 * POST media/upload (APPEND)
 * POST media/upload (FINALIZE)
 * POST media/upload (INIT)
 *
 * DELETE direct_messages/welcome_messages/destroy
 * DELETE direct_messages/welcome_messages/rules/destroy
 *
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountRemoveProfileBanner()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountSettings()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountUpdateProfile(array $body = ['name', 'url', 'location', 'description', 'profile_link_color', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse accountUpdateSettings(array $body = ['sleep_time_enabled', 'start_sleep_time', 'end_sleep_time', 'time_zone', 'trend_location_woeid', 'lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse block(array $body = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse blocksIds(array $params = ['cursor', 'stringify_ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse blocksList(array $params = ['cursor', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionsCreate(array $body = ['name', 'description', 'url', 'timeline_order'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionsDestroy(array $body = ['id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionsEntries(array $params = ['id', 'count', 'max_position', 'min_position'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionsEntriesAdd(array $body = ['id', 'tweet_id', 'relative_to', 'above'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionsEntriesCurate(array $body = ['id', 'changes'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionsEntriesMove(array $body = ['id', 'tweet_id', 'relative_to', 'above'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionsEntriesRemove(array $body = ['id', 'tweet_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionsList(array $params = ['user_id', 'screen_name', 'tweet_id', 'cursor', 'count'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionsShow(array $params = ['id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionsUpdate(array $body = ['id', 'name', 'description', 'url'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse directMessages(array $params = ['since_id', 'max_id', 'count', 'trim_user', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse directMessagesDestroy(array $body = ['id', 'include_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse directMessagesEventsList(array $params = ['cursor'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse directMessagesEventsShow(array $params = ['id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse directMessagesSent(array $params = ['since_id', 'max_id', 'count', 'page', 'trim_user', 'include_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse directMessagesShow(array $params = ['id', 'trim_user', 'include_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse directMessagesWelcomeMessagesList(array $params = ['cursor'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse directMessagesWelcomeMessagesNew(array $body = ['welcome_message'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse directMessagesWelcomeMessagesRulesList(array $params = ['cursor'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse directMessagesWelcomeMessagesRulesNew(array $body = ['welcome_message_rule'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse directMessagesWelcomeMessagesRulesShow(array $params = ['id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse directMessagesWelcomeMessagesShow(array $params = ['id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse favorite(array $body = ['id', 'include_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse favorites(array $params = ['user_id', 'screen_name', 'count', 'since_id', 'max_id', 'skip_status', 'include_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse follow(array $body = ['user_id', 'screen_name', 'follow'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse followersIds(array $params = ['user_id', 'screen_name', 'stringify_ids', 'cursor', 'count'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse followersList(array $params = ['user_id', 'screen_name', 'cursor', 'count', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse friendsIds(array $params = ['user_id', 'screen_name', 'stringify_ids', 'cursor', 'count'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse friendsList(array $params = ['user_id', 'screen_name', 'cursor', 'count', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse friendshipsIncoming(array $params = ['cursor', 'stringify_ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse friendshipsLookup(array $params = ['user_id', 'screen_name'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse friendshipsNoRetweetsIds(array $params = ['stringify_ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse friendshipsOutgoing(array $params = ['cursor', 'stringify_ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse friendshipsShow(array $params = ['source_id', 'source_screen_name', 'target_id', 'target_screen_name'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse friendshipsUpdate(array $body = ['user_id', 'screen_name', 'device', 'retweets'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse geoReverseGeocode(array $params = ['lat', 'long', 'accuracy', 'granularity', 'max_results'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse geoSearch(array $params = ['query', 'lat', 'long', 'ip', 'accuracy', 'granularity', 'max_results', 'contained_within'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse helpConfiguration()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse helpPrivacy()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse home(array $params = ['exclude_replies', 'trim_user', 'count', 'until', 'since_id', 'max_id', 'skip_status', 'include_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse languages()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse lists(array $params = ['user_id', 'screen_name', 'reverse'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsCreate(array $body = ['name', 'mode', 'description'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsDestroy(array $body = ['list_id', 'slug', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsMembers(array $params = ['list_id', 'slug', 'owner_screen_name', 'owner_id', 'count', 'cursor', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsMembersCreate(array $body = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsMembersCreateAll(array $body = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsMembersDestroy(array $body = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsMembersDestroyAll(array $body = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsMembersShow(array $params = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsMemberships(array $params = ['user_id', 'screen_name', 'count', 'cursor', 'filter_to_owned_lists'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsOwnerships(array $params = ['user_id', 'screen_name', 'count', 'cursor'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsShow(array $params = ['list_id', 'slug', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsStatuses(array $params = ['list_id', 'slug', 'owner_screen_name', 'owner_id', 'count', 'since_id', 'max_id', 'trim_user', 'include_rts', 'include_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsSubscribers(array $params = ['list_id', 'slug', 'owner_screen_name', 'owner_id', 'count', 'cursor', 'trim_user', 'skip_status', 'include_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsSubscribersCreate(array $body = ['list_id', 'slug', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsSubscribersDestroy(array $body = ['list_id', 'slug', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsSubscribersShow(array $params = ['owner_screen_name', 'owner_id', 'list_id', 'slug', 'user_id', 'screen_name', 'skip_status', 'include_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsSubscriptions(array $params = ['user_id', 'screen_name', 'count', 'cursor'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse listsUpdate(array $body = ['list_id', 'slug', 'name', 'mode', 'description', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mentions(array $params = ['count', 'since_id', 'max_id', 'trim_user', 'skip_status', 'include_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mute(array $body = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mutesUsersIds(array $params = ['cursor', 'stringify_ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse mutesUsersList(array $params = ['cursor', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse place($place_id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse rateLimitStatus(array $params = ['resources'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse reportSpam(array $body = ['user_id', 'screen_name', 'perform_block'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse retweet(array $body = ['id', 'trim_user'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse savedSearchesCreate(array $body = ['query'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse savedSearchesDestroy($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse savedSearchesList()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse savedSearchesShow($id)
 * @method \chillerlan\OAuth\HTTP\OAuthResponse searchTweets(array $params = ['q', 'geocode', 'lang', 'locale', 'result_type', 'count', 'until', 'since_id', 'max_id', 'skip_status', 'include_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statusesDestroy(array $body = ['id', 'trim_user'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statusesLookup(array $params = ['id', 'trim_user', 'map', 'include_ext_alt_text', 'skip_status', 'include_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statusesRetweetersIds(array $params = ['id', 'stringify_ids', 'cursor'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statusesRetweets(array $params = ['id', 'trim_user', 'include_my_retweet', 'include_entities', 'include_ext_alt_text'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statusesRetweetsOfMe(array $params = ['count', 'since_id', 'max_id', 'trim_user', 'skip_status', 'include_entities', 'include_user_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statusesShow(array $params = ['id', 'trim_user', 'include_my_retweet', 'include_entities', 'include_ext_alt_text'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tos()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse trendsAvailable()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse trendsClosest(array $params = ['lat', 'long'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse trendsPlace(array $params = ['id', 'exclude'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse unblock(array $body = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse unfavorite(array $body = ['id', 'include_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse unfollow(array $body = ['user_id', 'screen_name'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse unmute(array $body = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse unretweet(array $body = ['id', 'trim_user'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse user(array $params = ['user_id', 'screen_name', 'since_id', 'count', 'max_id', 'trim_user', 'exclude_replies', 'include_rts', 'include_entities'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse usersLookup(array $params = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse usersProfileBanner(array $params = ['user_id', 'screen_name'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse usersSearch(array $params = ['q', 'page', 'count', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse usersShow(array $params = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse usersSuggestions(array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse usersSuggestionsSlug($slug, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse usersSuggestionsSlugMembers($slug, array $params = ['lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse verifyCredentials(array $params = ['include_entities', 'skip_status'])
 */
class Twitter extends OAuth1Provider{

	protected $apiURL          = 'https://api.twitter.com/1.1';
	protected $requestTokenURL = 'https://api.twitter.com/oauth/request_token';
	protected $authURL         = 'https://api.twitter.com/oauth/authorize';
	protected $accessTokenURL  = 'https://api.twitter.com/oauth/access_token';
	protected $userRevokeURL   = 'https://twitter.com/settings/applications';

	/**
	 * twitter is v picky
	 *
	 * @inheritdoc
	 */
	protected function checkParams($params){

		if(is_array($params)){

			foreach($params as $key => $value){

				if(is_bool($value)){
					$params[$key] = $value ? 'true' : 'false';
				}
				elseif(is_null($value) || empty($value)){
					unset($params[$key]);
				}

			}

		}

		return $params;
	}

	/**
	 * dm(array $body = ['user_id', 'screen_name', 'text'])
	 *
	 * @link https://developer.twitter.com/en/docs/direct-messages/sending-and-receiving/api-reference/new-message
	 *
	 * @param array $params
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 */
	public function dm(array $params):OAuthResponse{
		return $this->request('/direct_messages/new.json', [], 'POST', $params);
	}

	/**
	 * @link https://developer.twitter.com/en/docs/direct-messages/sending-and-receiving/api-reference/new-event
	 * @link https://developer.twitter.com/en/docs/direct-messages/message-attachments/guides/attaching-media
	 *
	 * @todo: media/uploads
	 *
	 * @param string $recipient_id
	 * @param string $text
	 * @param array  $attachments
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 */
	public function dmEvent(string $recipient_id, string $text, array $attachments = null):OAuthResponse{

		$message_data = ['text' => $text];

/*
		if(!empty($attachments)){

			$attachment = [
				'type'  => 'media',
				'media' => [
					'id' => $params['media_id'] ?? null,
				],
			];

			$message_data['attachment'] = $attachment;
		}
*/

		$body = [
			'event' => [
				'type' => 'message_create',
				'message_create' => [
					'target' => ['recipient_id' => $recipient_id],
					'message_data' => $message_data,
				],
			],
		];

		return $this->request('/direct_messages/events/new.json', [], 'POST', json_encode($body), ['Content-type' => 'application/json']);
	}

	/**
	 * tweet(array $body = ['status', 'in_reply_to_status_id', 'possibly_sensitive', 'lat', 'long', 'place_id', 'display_coordinates', 'trim_user', 'media_ids', 'enable_dm_commands', 'fail_dm_commands'])
	 *
	 * @param array $params
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 */
	public function tweet(array $params):OAuthResponse{
		return $this->request('/statuses/update.json', [], 'POST', $params);
	}

}
