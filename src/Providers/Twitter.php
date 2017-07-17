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

/**
 * @link https://dev.twitter.com/rest/reference
 * @link https://dev.twitter.com/oauth/overview/authentication-by-api-family
 * @link https://dev.twitter.com/overview/api/entities-in-twitter-objects
 *
 * @method mixed account_remove_profile_banner()
 * @method mixed account_settings()
 * @method mixed account_update_profile(array $body = ['name', 'url', 'location', 'description', 'profile_link_color', 'include_entities', 'skip_status'])
 * @method mixed account_update_settings(array $body = ['sleep_time_enabled', 'start_sleep_time', 'end_sleep_time', 'time_zone', 'trend_location_woeid', 'lang'])
 * @method mixed block(array $body = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method mixed blocks_ids(array $params = ['cursor', 'stringify_ids'])
 * @method mixed blocks_list(array $params = ['cursor', 'include_entities', 'skip_status'])
 * @method mixed collections_create(array $body = ['name', 'description', 'url', 'timeline_order'])
 * @method mixed collections_destroy(array $body = ['id'])
 * @method mixed collections_entries(array $params = ['id', 'count', 'max_position', 'min_position'])
 * @method mixed collections_entries_add(array $body = ['id', 'tweet_id', 'relative_to', 'above'])
 * @method mixed collections_entries_curate($body = null)
 * @method mixed collections_entries_move(array $body = ['id', 'tweet_id', 'relative_to', 'above'])
 * @method mixed collections_entries_remove(array $body = ['id', 'tweet_id'])
 * @method mixed collections_list(array $params = ['user_id', 'screen_name', 'tweet_id', 'cursor', 'count'])
 * @method mixed collections_show(array $params = ['id'])
 * @method mixed collections_update(array $body = ['id', 'name', 'description', 'url'])
 * @method mixed direct_messages(array $params = ['since_id', 'max_id', 'count', 'trim_user', 'include_entities', 'skip_status'])
 * @method mixed direct_messages_destroy(array $body = ['id', 'include_entities'])
 * @method mixed direct_messages_events_list(array $params = ['cursor'])
 * @method mixed direct_messages_events_new($body = null)
 * @method mixed direct_messages_events_show(array $params = ['id'])
 * @method mixed direct_messages_sent(array $params = ['since_id', 'max_id', 'count', 'page', 'trim_user', 'include_entities'])
 * @method mixed direct_messages_show(array $params = ['id', 'trim_user', 'include_entities'])
 * @method mixed direct_messages_welcome_messages_list(array $params = ['cursor'])
 * @method mixed direct_messages_welcome_messages_new($body = null)
 * @method mixed direct_messages_welcome_messages_rules_list(array $params = ['cursor'])
 * @method mixed direct_messages_welcome_messages_rules_new($body = null)
 * @method mixed direct_messages_welcome_messages_rules_show(array $params = ['id'])
 * @method mixed direct_messages_welcome_messages_show(array $params = ['id'])
 * @method mixed dm(array $body = ['user_id', 'screen_name', 'text'])
 * @method mixed favorite(array $body = ['id', 'include_entities'])
 * @method mixed favorites(array $params = ['user_id', 'screen_name', 'count', 'since_id', 'max_id', 'skip_status', 'include_entities'])
 * @method mixed follow(array $body = ['user_id', 'screen_name', 'follow'])
 * @method mixed followers_ids(array $params = ['user_id', 'screen_name', 'stringify_ids', 'cursor', 'count'])
 * @method mixed followers_list(array $params = ['user_id', 'screen_name', 'cursor', 'count', 'include_entities', 'skip_status'])
 * @method mixed friends_ids(array $params = ['user_id', 'screen_name', 'stringify_ids', 'cursor', 'count'])
 * @method mixed friends_list(array $params = ['user_id', 'screen_name', 'cursor', 'count', 'include_entities', 'skip_status'])
 * @method mixed friendships_incoming(array $params = ['cursor', 'stringify_ids'])
 * @method mixed friendships_lookup(array $params = ['user_id', 'screen_name'])
 * @method mixed friendships_no_retweets_ids(array $params = ['stringify_ids'])
 * @method mixed friendships_outgoing(array $params = ['cursor', 'stringify_ids'])
 * @method mixed friendships_show(array $params = ['source_id', 'source_screen_name', 'target_id', 'target_screen_name'])
 * @method mixed friendships_update(array $body = ['user_id', 'screen_name', 'device', 'retweets'])
 * @method mixed geo_reverse_geocode(array $params = ['lat', 'long', 'accuracy', 'granularity', 'max_results'])
 * @method mixed geo_search(array $params = ['query', 'lat', 'long', 'ip', 'accuracy', 'granularity', 'max_results', 'contained_within'])
 * @method mixed help_configuration()
 * @method mixed help_privacy()
 * @method mixed home(array $params = ['exclude_replies', 'trim_user', 'count', 'until', 'since_id', 'max_id', 'skip_status', 'include_entities'])
 * @method mixed languages()
 * @method mixed lists(array $params = ['user_id', 'screen_name', 'reverse'])
 * @method mixed lists_create(array $body = ['name', 'mode', 'description'])
 * @method mixed lists_destroy(array $body = ['list_id', 'slug', 'owner_screen_name', 'owner_id'])
 * @method mixed lists_members(array $params = ['list_id', 'slug', 'owner_screen_name', 'owner_id', 'count', 'cursor', 'include_entities', 'skip_status'])
 * @method mixed lists_members_create(array $body = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id'])
 * @method mixed lists_members_create_all(array $body = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id'])
 * @method mixed lists_members_destroy(array $body = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id'])
 * @method mixed lists_members_destroy_all(array $body = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id'])
 * @method mixed lists_members_show(array $params = ['list_id', 'slug', 'user_id', 'screen_name', 'owner_screen_name', 'owner_id', 'include_entities', 'skip_status'])
 * @method mixed lists_memberships(array $params = ['user_id', 'screen_name', 'count', 'cursor', 'filter_to_owned_lists'])
 * @method mixed lists_ownerships(array $params = ['user_id', 'screen_name', 'count', 'cursor'])
 * @method mixed lists_show(array $params = ['list_id', 'slug', 'owner_screen_name', 'owner_id'])
 * @method mixed lists_statuses(array $params = ['list_id', 'slug', 'owner_screen_name', 'owner_id', 'count', 'since_id', 'max_id', 'trim_user', 'include_rts', 'include_entities'])
 * @method mixed lists_subscribers(array $params = ['list_id', 'slug', 'owner_screen_name', 'owner_id', 'count', 'cursor', 'trim_user', 'skip_status', 'include_entities'])
 * @method mixed lists_subscribers_create(array $body = ['list_id', 'slug', 'owner_screen_name', 'owner_id'])
 * @method mixed lists_subscribers_destroy(array $body = ['list_id', 'slug', 'owner_screen_name', 'owner_id'])
 * @method mixed lists_subscribers_show(array $params = ['owner_screen_name', 'owner_id', 'list_id', 'slug', 'user_id', 'screen_name', 'skip_status', 'include_entities'])
 * @method mixed lists_subscriptions(array $params = ['user_id', 'screen_name', 'count', 'cursor'])
 * @method mixed lists_update(array $body = ['list_id', 'slug', 'name', 'mode', 'description', 'owner_screen_name', 'owner_id'])
 * @method mixed mentions(array $params = ['count', 'since_id', 'max_id', 'trim_user', 'skip_status', 'include_entities'])
 * @method mixed mute(array $body = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method mixed mutes_users_ids(array $params = ['cursor', 'stringify_ids'])
 * @method mixed mutes_users_list(array $params = ['cursor', 'include_entities', 'skip_status'])
 * @method mixed place(string $place_id)
 * @method mixed rate_limit_status()
 * @method mixed report(array $body = ['user_id', 'screen_name', 'perform_block'])
 * @method mixed retweet(array $body = ['id', 'trim_user'])
 * @method mixed saved_searches_create(array $body = ['query'])
 * @method mixed saved_searches_destroy(string $id)
 * @method mixed saved_searches_list()
 * @method mixed saved_searches_show(string $id)
 * @method mixed search_tweets(array $params = ['q', 'geocode', 'lang', 'locale', 'result_type', 'count', 'until', 'since_id', 'max_id', 'skip_status', 'include_entities'])
 * @method mixed statuses_destroy(array $body = ['id', 'trim_user'])
 * @method mixed statuses_lookup(array $params = ['id', 'trim_user', 'map', 'include_ext_alt_text', 'skip_status', 'include_entities'])
 * @method mixed statuses_retweeters_ids(array $params = ['id', 'stringify_ids', 'cursor'])
 * @method mixed statuses_retweets(array $params = ['id', 'trim_user', 'include_my_retweet', 'include_entities', 'include_ext_alt_text'])
 * @method mixed statuses_retweets_of_me(array $params = ['count', 'since_id', 'max_id', 'trim_user', 'skip_status', 'include_entities', 'include_user_entities'])
 * @method mixed statuses_show(array $params = ['id', 'trim_user', 'include_my_retweet', 'include_entities', 'include_ext_alt_text'])
 * @method mixed tos()
 * @method mixed trends_available()
 * @method mixed trends_closest(array $params = ['lat', 'long'])
 * @method mixed trends_place(array $params = ['id', 'exclude'])
 * @method mixed tweet(array $body = ['status', 'in_reply_to_status_id', 'possibly_sensitive', 'lat', 'long', 'place_id', 'display_coordinates', 'trim_user', 'media_ids', 'enable_dm_commands', 'fail_dm_commands'])
 * @method mixed unblock(array $body = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method mixed unfavorite(array $body = ['id', 'include_entities'])
 * @method mixed unfollow(array $body = ['user_id', 'screen_name'])
 * @method mixed unmute(array $body = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method mixed unretweet(array $body = ['id', 'trim_user'])
 * @method mixed user(array $params = ['user_id', 'screen_name', 'since_id', 'count', 'max_id', 'trim_user', 'exclude_replies', 'include_rts', 'include_entities'])
 * @method mixed users_lookup(array $params = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method mixed users_profile_banner(array $params = ['user_id', 'screen_name'])
 * @method mixed users_search(array $params = ['q', 'page', 'count', 'include_entities', 'skip_status'])
 * @method mixed users_show(array $params = ['user_id', 'screen_name', 'include_entities', 'skip_status'])
 * @method mixed users_suggestions(array $params = ['lang'])
 * @method mixed users_suggestions_slug(string $slug, array $params = ['lang'])
 * @method mixed users_suggestions_slug_members(string $slug, array $params = ['lang'])
 * @method mixed verify(array $params = ['include_entities', 'skip_status'])
 */
class Twitter extends OAuth1Provider{

	protected $apiURL               = 'https://api.twitter.com/1.1';
	protected $requestTokenEndpoint = 'https://api.twitter.com/oauth/request_token';
	protected $authURL              = 'https://api.twitter.com/oauth/authorize';
	protected $userRevokeURL        = 'https://twitter.com/settings/applications';
	protected $accessTokenEndpoint  = 'https://api.twitter.com/oauth/access_token';

	// todo: filter allowed params
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

			uksort($params, 'strcmp');
		}

		return $params;
	}

}
