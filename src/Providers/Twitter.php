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

use chillerlan\HTTP\HTTPResponseInterface;

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
 * @method \chillerlan\HTTP\HTTPResponseInterface accountRemoveProfileBanner()
 * @method \chillerlan\HTTP\HTTPResponseInterface accountSettings()
 * @method \chillerlan\HTTP\HTTPResponseInterface accountUpdateProfile(array $body = ['name', 'url', 'location', 'description', 'profile_link_color', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface accountUpdateSettings(array $body = ['sleep_time_enabled', 'start_sleep_time', 'end_sleep_time', 'time_zone', 'trend_location_woeid', 'lang'])
 * @method \chillerlan\HTTP\HTTPResponseInterface block(array $body = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface blocksIds(array $params = ['cursor', 'stringify_ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface blocksList(array $params = ['cursor', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionsCreate(array $body = ['name', 'description', 'url', 'timeline_order'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionsDestroy(array $body = ['id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionsEntries(array $params = ['id', 'count', 'max_position', 'min_position'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionsEntriesAdd(array $body = ['id', 'tweet_id', 'relative_to', 'above'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionsEntriesCurate(array $body = ['id', 'changes'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionsEntriesMove(array $body = ['id', 'tweet_id', 'relative_to', 'above'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionsEntriesRemove(array $body = ['id', 'tweet_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionsList(array $params = ['user_id', 'screen_name', 'tweet_id', 'cursor', 'count'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionsShow(array $params = ['id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionsUpdate(array $body = ['id', 'name', 'description', 'url'])
 * @method \chillerlan\HTTP\HTTPResponseInterface directMessages(array $params = ['since_id', 'max_id', 'count', 'trim_user', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface directMessagesDestroy(array $body = ['id', 'include_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface directMessagesEventsList(array $params = ['cursor'])
 * @method \chillerlan\HTTP\HTTPResponseInterface directMessagesEventsShow(array $params = ['id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface directMessagesSent(array $params = ['since_id', 'max_id', 'count', 'page', 'trim_user', 'include_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface directMessagesShow(array $params = ['id', 'trim_user', 'include_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface directMessagesWelcomeMessagesList(array $params = ['cursor'])
 * @method \chillerlan\HTTP\HTTPResponseInterface directMessagesWelcomeMessagesNew(array $body = ['welcome_message'])
 * @method \chillerlan\HTTP\HTTPResponseInterface directMessagesWelcomeMessagesRulesList(array $params = ['cursor'])
 * @method \chillerlan\HTTP\HTTPResponseInterface directMessagesWelcomeMessagesRulesNew(array $body = ['welcome_message_rule'])
 * @method \chillerlan\HTTP\HTTPResponseInterface directMessagesWelcomeMessagesRulesShow(array $params = ['id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface directMessagesWelcomeMessagesShow(array $params = ['id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface favorite(array $body = ['id', 'include_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface favorites(array $params = ['user_id', 'screen_name', 'count', 'since_id', 'max_id', 'skip_status', 'include_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface follow(array $body = ['user_id', 'screen_name', 'follow'])
 * @method \chillerlan\HTTP\HTTPResponseInterface followersIds(array $params = ['user_id', 'screen_name', 'stringify_ids', 'cursor', 'count'])
 * @method \chillerlan\HTTP\HTTPResponseInterface followersList(array $params = ['user_id', 'screen_name', 'cursor', 'count', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface friendsIds(array $params = ['user_id', 'screen_name', 'stringify_ids', 'cursor', 'count'])
 * @method \chillerlan\HTTP\HTTPResponseInterface friendsList(array $params = ['user_id', 'screen_name', 'cursor', 'count', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface friendshipsIncoming(array $params = ['cursor', 'stringify_ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface friendshipsLookup(array $params = ['user_id', 'screen_name'])
 * @method \chillerlan\HTTP\HTTPResponseInterface friendshipsNoRetweetsIds(array $params = ['stringify_ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface friendshipsOutgoing(array $params = ['cursor', 'stringify_ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface friendshipsShow(array $params = ['source_id', 'source_screen_name', 'target_id', 'target_screen_name'])
 * @method \chillerlan\HTTP\HTTPResponseInterface friendshipsUpdate(array $body = ['user_id', 'screen_name', 'device', 'retweets'])
 * @method \chillerlan\HTTP\HTTPResponseInterface geoReverseGeocode(array $params = ['lat', 'long', 'accuracy', 'granularity', 'max_results'])
 * @method \chillerlan\HTTP\HTTPResponseInterface geoSearch(array $params = ['query', 'lat', 'long', 'ip', 'accuracy', 'granularity', 'max_results', 'contained_within'])
 * @method \chillerlan\HTTP\HTTPResponseInterface helpConfiguration()
 * @method \chillerlan\HTTP\HTTPResponseInterface helpPrivacy()
 * @method \chillerlan\HTTP\HTTPResponseInterface home(array $params = ['exclude_replies', 'trim_user', 'count', 'until', 'since_id', 'max_id', 'skip_status', 'include_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface languages()
 * @method \chillerlan\HTTP\HTTPResponseInterface lists(array $params = ['user_id', 'screen_name', 'reverse'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsCreate(array $body = ['name', 'mode', 'description'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsDestroy(array $body = ['list_id', 'slug', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsMembers(array $params = ['list_id', 'slug', 'owner_screen_name', 'owner_id', 'count', 'cursor', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsMembersCreate(array $body = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsMembersCreateAll(array $body = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsMembersDestroy(array $body = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsMembersDestroyAll(array $body = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsMembersShow(array $params = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsMemberships(array $params = ['user_id', 'screen_name', 'count', 'cursor', 'filter_to_owned_lists'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsOwnerships(array $params = ['user_id', 'screen_name', 'count', 'cursor'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsShow(array $params = ['list_id', 'slug', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsStatuses(array $params = ['list_id', 'slug', 'owner_screen_name', 'owner_id', 'count', 'since_id', 'max_id', 'trim_user', 'include_rts', 'include_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsSubscribers(array $params = ['list_id', 'slug', 'owner_screen_name', 'owner_id', 'count', 'cursor', 'trim_user', 'skip_status', 'include_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsSubscribersCreate(array $body = ['list_id', 'slug', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsSubscribersDestroy(array $body = ['list_id', 'slug', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsSubscribersShow(array $params = ['owner_screen_name', 'owner_id', 'list_id', 'slug', 'user_id', 'screen_name', 'skip_status', 'include_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsSubscriptions(array $params = ['user_id', 'screen_name', 'count', 'cursor'])
 * @method \chillerlan\HTTP\HTTPResponseInterface listsUpdate(array $body = ['list_id', 'slug', 'name', 'mode', 'description', 'owner_screen_name', 'owner_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface mentions(array $params = ['count', 'since_id', 'max_id', 'trim_user', 'skip_status', 'include_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface mute(array $body = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface mutesUsersIds(array $params = ['cursor', 'stringify_ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface mutesUsersList(array $params = ['cursor', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface place($place_id)
 * @method \chillerlan\HTTP\HTTPResponseInterface rateLimitStatus(array $params = ['resources'])
 * @method \chillerlan\HTTP\HTTPResponseInterface reportSpam(array $body = ['user_id', 'screen_name', 'perform_block'])
 * @method \chillerlan\HTTP\HTTPResponseInterface retweet(array $body = ['id', 'trim_user'])
 * @method \chillerlan\HTTP\HTTPResponseInterface savedSearchesCreate(array $body = ['query'])
 * @method \chillerlan\HTTP\HTTPResponseInterface savedSearchesDestroy($id)
 * @method \chillerlan\HTTP\HTTPResponseInterface savedSearchesList()
 * @method \chillerlan\HTTP\HTTPResponseInterface savedSearchesShow($id)
 * @method \chillerlan\HTTP\HTTPResponseInterface searchTweets(array $params = ['q', 'geocode', 'lang', 'locale', 'result_type', 'count', 'until', 'since_id', 'max_id', 'skip_status', 'include_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statusesDestroy(array $body = ['id', 'trim_user'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statusesLookup(array $params = ['id', 'trim_user', 'map', 'include_ext_alt_text', 'skip_status', 'include_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statusesRetweetersIds(array $params = ['id', 'stringify_ids', 'cursor'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statusesRetweets(array $params = ['id', 'trim_user', 'include_my_retweet', 'include_entities', 'include_ext_alt_text'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statusesRetweetsOfMe(array $params = ['count', 'since_id', 'max_id', 'trim_user', 'skip_status', 'include_entities', 'include_user_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statusesShow(array $params = ['id', 'trim_user', 'include_my_retweet', 'include_entities', 'include_ext_alt_text'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tos()
 * @method \chillerlan\HTTP\HTTPResponseInterface trendsAvailable()
 * @method \chillerlan\HTTP\HTTPResponseInterface trendsClosest(array $params = ['lat', 'long'])
 * @method \chillerlan\HTTP\HTTPResponseInterface trendsPlace(array $params = ['id', 'exclude'])
 * @method \chillerlan\HTTP\HTTPResponseInterface unblock(array $body = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface unfavorite(array $body = ['id', 'include_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface unfollow(array $body = ['user_id', 'screen_name'])
 * @method \chillerlan\HTTP\HTTPResponseInterface unmute(array $body = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface unretweet(array $body = ['id', 'trim_user'])
 * @method \chillerlan\HTTP\HTTPResponseInterface user(array $params = ['user_id', 'screen_name', 'since_id', 'count', 'max_id', 'trim_user', 'exclude_replies', 'include_rts', 'include_entities'])
 * @method \chillerlan\HTTP\HTTPResponseInterface usersLookup(array $params = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface usersProfileBanner(array $params = ['user_id', 'screen_name'])
 * @method \chillerlan\HTTP\HTTPResponseInterface usersSearch(array $params = ['q', 'page', 'count', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface usersShow(array $params = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method \chillerlan\HTTP\HTTPResponseInterface usersSuggestions(array $params = ['lang'])
 * @method \chillerlan\HTTP\HTTPResponseInterface usersSuggestionsSlug($slug, array $params = ['lang'])
 * @method \chillerlan\HTTP\HTTPResponseInterface usersSuggestionsSlugMembers($slug, array $params = ['lang'])
 * @method \chillerlan\HTTP\HTTPResponseInterface verifyCredentials(array $params = ['include_entities', 'skip_status'])
 */
class Twitter extends OAuth1Provider{

	protected $apiURL          = 'https://api.twitter.com/1.1';
	protected $requestTokenURL = 'https://api.twitter.com/oauth/request_token';
	protected $authURL         = 'https://api.twitter.com/oauth/authorize';
	protected $accessTokenURL  = 'https://api.twitter.com/oauth/access_token';
	protected $userRevokeURL   = 'https://twitter.com/settings/applications';

	/**
	 * @codeCoverageIgnore
	 *
	 * dm(array $body = ['user_id', 'screen_name', 'text'])
	 *
	 * @link https://developer.twitter.com/en/docs/direct-messages/sending-and-receiving/api-reference/new-message
	 *
	 * @param array $params
	 *
	 * @return \chillerlan\HTTP\HTTPResponseInterface
	 */
	public function dm(array $params):HTTPResponseInterface{
		return $this->request('/direct_messages/new.json', [], 'POST', $params);
	}

	/**
	 * @codeCoverageIgnore
	 *
	 * @link https://developer.twitter.com/en/docs/direct-messages/sending-and-receiving/api-reference/new-event
	 * @link https://developer.twitter.com/en/docs/direct-messages/message-attachments/guides/attaching-media
	 *
	 * @todo: media/uploads
	 *
	 * @param string $recipient_id
	 * @param string $text
	 * @param array  $attachments
	 *
	 * @return \chillerlan\HTTP\HTTPResponseInterface
	 */
	public function dmEvent(string $recipient_id, string $text, array $attachments = null):HTTPResponseInterface{

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
	 * @codeCoverageIgnore
	 *
	 * tweet(array $body = ['status', 'in_reply_to_status_id', 'possibly_sensitive', 'lat', 'long', 'place_id', 'display_coordinates', 'trim_user', 'media_ids', 'enable_dm_commands', 'fail_dm_commands'])
	 *
	 * @param array $params
	 *
	 * @return \chillerlan\HTTP\HTTPResponseInterface
	 */
	public function tweet(array $params):HTTPResponseInterface{
		return $this->request('/statuses/update.json', [], 'POST', $params);
	}

}
