<?php
/**
 * Class TwitterAPITest
 *
 * @filesource   TwitterAPITest.php
 * @created      11.07.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\Twitter;

/**
 * twitter API tests & examples
 *
 * @link https://developer.twitter.com/en/docs/api-reference-index
 */
class TwitterAPITest extends APITestAbstract{

	protected $providerClass = Twitter::class;
	protected $envvar        = 'TWITTER';

	protected $screen_name;
	protected $user_id;

	/**
	 * @var \chillerlan\OAuth\Providers\Twitter
	 */
	protected $provider;

	protected function setUp(){
		parent::setUp();

		$token             = $this->storage->retrieveAccessToken($this->provider->serviceName);
		$this->screen_name = $token->extraParams['screen_name'];
		$this->user_id     = $token->extraParams['user_id'];
	}

	/**
	 * @dataProvider endpointDataProvider
	 *
	 * @param string $endpoint
	 * @param array  $arguments
	 * @param string $field
	 * @param mixed  $expected
	 * @param bool   $headers
	 */
	public function testEndpoints(string $endpoint, array $arguments, string $field, $expected, bool $headers){
		$this->response = $this->provider->{$endpoint}(...$arguments);
		$j = $this->response->json;

		if($headers){
			$this->assertSame($expected, $this->response->headers->{$field});
		}
		elseif(is_array($j)){
			is_null($expected)
				? $this->assertTrue(isset($j[0]->{$field}))
				: $this->assertSame($expected, $j[0]->{$field});
		}
		else{
			is_null($expected)
				? $this->assertTrue(isset($j->{$field}))
				: $this->assertSame($expected, $j->{$field});
		}

	}

	public function endpointDataProvider(){
		return [
#			['accountRemoveProfileBanner', [], 'statuscode', 200, true],
			['accountSettings', [], 'time_zone', null, false],
			['accountUpdateProfile', [[]], 'screen_name', $this->screen_name, false],
			['accountUpdateSettings', [[]], 'screen_name', $this->screen_name, false],
			['blocksList', [['include_entities' => false, 'skip_status' => true]], 'users', null, false],
			['collectionsEntries', [['id' => 'custom-875208674678931456']], 'objects', null, false],
			['collectionsList', [['screen_name' => 'Twitter']], 'objects', null, false],
			['collectionsShow', [['id' => 'custom-875208674678931456']], 'objects', null, false],
			['favorites', [['screen_name' => 'twitter', 'skip_status' => true, 'include_entities' => false]], 'id', null, false],
			['followersIds', [], 'ids', null, false],
			['followersList', [], 'users', null, false],
			['friendsIds', [], 'ids', null, false],
			['friendsList', [], 'users', null, false],
			['friendshipsIncoming', [['stringify_ids' => true]], 'ids', null, false],
			['friendshipsLookup', [['screen_name' => implode(',', [$this->screen_name, 'Twitter'])]], 'screen_name', 'Twitter', false],
			['friendshipsOutgoing', [['stringify_ids' => true]], 'ids', null, false],
			['friendshipsShow', [['source_screen_name' => $this->screen_name, 'target_screen_name' => 'TwitterAPI']], 'relationship', null, false],
			['helpConfiguration', [], 'dm_text_character_limit', 10000, false],
			['helpPrivacy', [], 'privacy', null, false],
			['home', [['exclude_replies'  => true, 'trim_user' => true, 'count' => 5, 'skip_status' => true, 'include_entities' => false,]], 'id', null, false],
			['lists', [['screen_name' => 'Twitter', 'reverse' => false]], 'id', null, false],
			['listsMembersShow', [['slug' => 'official-twitter-accounts', 'screen_name' => 'TwitterSF', 'owner_screen_name' => 'Twitter', 'include_entities' => false, 'skip_status' => true]], 'screen_name', 'TwitterSF', false],
			['listsMemberships', [['screen_name' => 'Twitter', 'filter_to_owned_lists' => false]], 'lists', null, false],
			['listsOwnerships', [['screen_name' => 'Twitter']], 'lists', null, false],
			['listsShow', [['slug' => 'official-twitter-accounts', 'owner_screen_name' => 'Twitter']], 'name', 'Official Twitter Accounts', false],
			['listsStatuses', [['slug' => 'official-twitter-accounts', 'owner_screen_name' => 'Twitter', 'trim_user' => true, 'include_rts' => false, 'include_entities' => false]], 'id', null, false],
			['mentions', [['trim_user' => true, 'skip_status' => true, 'include_entities' => false]], 'id', null, false],
			['mutesUsersIds', [], 'ids', null, false],
			['place', ['df51dec6f4ee2b2c'], 'id', 'df51dec6f4ee2b2c', false],
			['rateLimitStatus', [], 'rate_limit_context', null, false],
			['searchTweets', [['q' => '#freebandnames', 'result_type' => 'mixed', 'count' => 5, 'skip_status' => true, 'include_entities' => false]], 'statuses', null, false],
			['statusesLookup', [['id' => '20', 'trim_user' => true, 'map' => 5, 'include_ext_alt_text' => true, 'skip_status' => true, 'include_entities' => false]], 'id', 20, false],
			['statusesRetweetersIds', [['id' => '20', 'stringify_ids' => true]], 'ids', null, false],
			['statusesRetweets', [['id' => '20', 'trim_user' => true, 'include_my_retweet' => false, 'include_entities' => true, 'skip_status' => false]], 'id', null, false],
			['statusesRetweetsOfMe', [['trim_user' => true, 'skip_status' => true, 'include_entities' => false, 'include_user_entities' => false]], 'id', null, false],
			['statusesShow', [['id' => '20', 'trim_user' => true, 'include_my_retweet' => false, 'include_entities' => false, 'include_ext_alt_text' => false]], 'id', 20, false],
			['tos', [], 'tos', null, false],
			['trendsAvailable', [], 'name', null, false],
			['trendsClosest', [['lat' => 37.781157, 'long' => -122.400612831116]], 'name', null, false],
			['trendsPlace', [['id' => 1, 'exclude' => 'hashtags']], 'trends', null, false],
			['user', [['trim_user' => true, 'exclude_replies' => true, 'include_rts' => false, 'include_entities' => false]], 'id', null, false],
			['usersLookup', [['screen_name' => 'twitter', 'include_entities' => false, 'skip_status'      => true]], 'screen_name', null, false],
			['usersProfileBanner', [['screen_name' => 'twitter']], 'sizes', null, false],
			['usersSearch', [['q' => 'twitter', 'include_entities' => false, 'skip_status' => true]], 'screen_name', null, false],
			['usersShow', [['screen_name' => 'twitter', 'include_entities' => false, 'skip_status' => true]], 'screen_name', 'Twitter', false],
			['usersSuggestions', [], 'slug', null, false],
			['usersSuggestionsSlug', ['music', ['lang' => 'en']], 'users', null, false],
			['usersSuggestionsSlugMembers', ['music', ['lang' => 'en']], 'id', null, false],
			['verifyCredentials', [['include_entities' => false, 'skip_status' => true]], 'screen_name', null, false],
		];
	}


	public function testFriendshipsNoRetweetsIds(){
		$response = $this->provider->friendshipsNoRetweetsIds();
		$this->assertTrue(is_array($response->json)); // ...
	}

	public function testGeoReverseGeocode(){
		$this->response = $this->provider->geoReverseGeocode(['lat' => 37.781157, 'long' => -122.400612831116, 'accuracy' => '3m', 'granularity' => 'city', 'max_results' => 3]);
		$this->assertSame('5a110d312052166f', $this->response->json->result->places[0]->id);
	}

	public function testGeoSearch(){
		$this->response = $this->provider->geoSearch(['query' => 'Toronto', 'max_results' => 3]);
		$this->assertSame('3797791ff9c0e4c6', $this->response->json->result->places[0]->id);
	}

	public function testLanguages(){
		$this->response = $this->provider->languages();
		$this->assertContains('de', array_column($this->response->json_array, 'code'));
	}

	public function testFavorite(){
		// fetch the latest dril tweet
		$this->response = $this->provider->usersShow(['screen_name' => 'dril', 'skip_status' => false, 'include_entities' => false]);
		$params         = ['id' => $this->response->json->status->id_str, 'include_entities' => false];
		$favorited1     = $this->response->json->status->favorited;

		// fave it if it isn't already, otherwise unfave
		$this->response = $favorited1
			? $this->provider->unfavorite($params)
			: $this->provider->favorite($params);

		$favorited2 = $this->response->json->favorited;

		$this->assertSame(!$favorited1, $favorited2);

		$this->response = $favorited2
			? $this->provider->unfavorite($params)
			: $this->provider->favorite($params);

		$this->assertSame(!$favorited2, $this->response->json->favorited);
	}

	public function testRetweet(){
		$id = '923489890444161024';
		$this->response = $this->provider->statusesShow(['id' => $id, 'trim_user' => true, 'include_my_retweet' => false, 'include_entities' => false, 'include_ext_alt_text' => false]);
		$params         = ['id' => $id, 'trim_user' => true];
		$rt1            = $this->response->json->retweeted;

		$this->response = $rt1
			? $this->provider->unretweet($params)
			: $this->provider->retweet($params);

		$rt2 = $this->response->json->retweeted;

		$this->response = $rt2
			? $this->provider->unretweet($params)
			: $this->provider->retweet($params);

		$this->assertTrue($this->response->json->retweeted);
	}

	public function testFollow(){
		$this->response = $this->provider->usersShow(['screen_name' => 'Twitter']);
		$params         = ['screen_name' => 'Twitter'];
		$following      = $this->response->json->following;

		if($following){
			$this->provider->unfollow($params);
#			$this->assertFalse($this->response->json->following); // ??? twitter
		}

		$this->response = $this->provider->follow($params);
#		$this->assertTrue($this->response->json->following);  // ??? twitter
	}

	public function testBlocks(){
		// nothing can go wrong here
		$this->response = $this->provider->block(['user_id' => '402181258']);

		// make sure it's gone
		$this->assertSame(402181258, $this->response->json->id);

		// plonk!
		$this->response = $this->provider->blocksIds();
		$this->assertTrue(in_array(402181258, $this->response->json->ids));

		$this->response = $this->provider->unblock(['screen_name' => 'Twitter']);
		$this->assertSame('Twitter', $this->response->json->screen_name);
	}

	public function testUsersMute(){
		$params = ['screen_name' => 'Twitter', 'include_entities' => false, 'skip_status' => true];
		$this->response = $this->provider->mute($params);
		$this->assertSame('Twitter', $this->response->json->screen_name);

		$this->response = $this->provider->mutesUsersList(['include_entities' => false, 'skip_status' => true]);
		$this->assertTrue(in_array('Twitter', array_column($this->response->json->users, 'screen_name')));

		$this->response = $this->provider->unmute($params);
		$this->assertSame('Twitter', $this->response->json->screen_name);
	}

	public function testSavedSearches(){
		$this->response = $this->provider->savedSearchesCreate(['query' => '@'.$this->screen_name]);
		print_r($this->response->json);
		$id = $this->response->json->id_str;
		$this->assertRegExp('/[\d]+/', $id);

		$this->response = $this->provider->savedSearchesList();
		$this->assertTrue(in_array($id, array_column((array)$this->response->json, 'id_str')));

		$this->response = $this->provider->savedSearchesShow($id);
		$this->assertSame('@'.$this->screen_name, $this->response->json->query);

		$this->response = $this->provider->savedSearchesDestroy($id);
		$this->assertSame($id, $this->response->json->id_str);

		$this->response = $this->provider->savedSearchesList();
		$this->assertFalse(in_array($id, array_column((array)$this->response->json, 'id_str')));
	}

	public function testLists(){
		$name = 'test_'.crc32(microtime(true));

		$this->response = $this->provider->listsCreate(['name' => $name, 'mode' => 'private', 'description' => 'test']);
		$list_id = $this->response->json->id_str;

		$this->response = $this->provider->listsMembersCreate(['list_id' => $list_id, 'screen_name' => 'dril']);
		$this->assertSame($list_id, $this->response->json->id_str);

		$this->response = $this->provider->listsMembersCreateAll(['list_id' => $list_id, 'screen_name' => 'EveryoneIsDril,parliawint']);
		$this->assertSame($list_id, $this->response->json->id_str);

		$this->response = $this->provider->listsMembers(['list_id' => $list_id, 'include_entities' => false, 'skip_status' => true]);
		$this->assertSame(['parliawint', 'EveryoneIsDril', 'dril'], array_column($this->response->json->users, 'screen_name'));

		$this->response = $this->provider->listsMembersDestroy(['list_id' => $list_id, 'screen_name' => 'parliawint']);
		$this->assertSame($list_id, $this->response->json->id_str);

		$this->response = $this->provider->listsMembers(['list_id' => $list_id, 'include_entities' => false, 'skip_status' => true]);
		$this->assertSame(['EveryoneIsDril', 'dril'], array_column($this->response->json->users, 'screen_name'));

		$this->response = $this->provider->listsMembersDestroyAll(['list_id' =>$list_id, 'screen_name' => 'EveryoneIsDril,dril']);
		$this->assertSame($list_id, $this->response->json->id_str);

		$this->response = $this->provider->listsMembers(['list_id' => $list_id]);
		$this->assertSame([], $this->response->json->users);

		$this->response = $this->provider->listsUpdate(['list_id' => $list_id, 'description' => 'testytest']);
		$this->assertSame('testytest', $this->response->json->description);

		$this->response = $this->provider->listsDestroy(['list_id' => $list_id]);
		$this->assertSame($list_id, $this->response->json->id_str);
	}

	public function testListSubscriptions(){
		$this->response = $this->provider->listsSubscribersCreate(['owner_screen_name' => 'Twitter', 'slug' => 'moments']);
		$this->assertSame('moments', $this->response->json->slug);

		$this->response = $this->provider->listsSubscriptions();
		$this->assertSame('moments', $this->response->json->lists[0]->slug);

		$this->response = $this->provider->listsSubscribers(['owner_screen_name' => 'Twitter', 'slug' => 'moments']);
		$this->assertSame($this->screen_name, $this->response->json->users[0]->screen_name);

		$this->response = $this->provider->listsSubscribersShow(['owner_screen_name' => 'Twitter', 'slug' => 'moments', 'screen_name' => $this->screen_name, 'include_entities' => false, 'skip_status' => true]);
		$this->assertSame($this->screen_name, $this->response->json->screen_name);

		$this->response = $this->provider->listsSubscribersDestroy(['owner_screen_name' => 'Twitter', 'slug' => 'moments']);
		$this->assertSame('moments', $this->response->json->slug);
	}

	public function testCollections(){
		$name           = 'test_'.crc32(microtime(true));
		$this->response = $this->provider->collectionsCreate(['name' => $name, 'description' => 'test', 'timeline_order' => 'added']);
		$timeline_id    = $this->response->json->response->timeline_id;

		$this->response = $this->provider->collectionsEntries(['id' => $timeline_id]);
		$this->assertSame($name, $this->response->json->objects->timelines->{$timeline_id}->name);

		$this->response = $this->provider->collectionsShow(['id' => $timeline_id]);
		$this->assertSame($name, $this->response->json->objects->timelines->{$timeline_id}->name);

		$this->response = $this->provider->collectionsEntriesCurate(json_encode(['id' => $timeline_id, 'changes' => [['op' => 'add', 'tweet_id' => '507816092'], ['op' => 'add', 'tweet_id' => '922321981']]]));
		$this->assertEmpty($this->response->json->response->errors);

		$this->response = $this->provider->collectionsEntriesAdd(['id' => $timeline_id, 'tweet_id' => '913288599629688832', 'above' => true]);
		$this->assertEmpty($this->response->json->response->errors);

		$this->response = $this->provider->collectionsEntriesMove(['id' => $timeline_id, 'tweet_id' => '507816092', 'relative_to' => '922321981', 'above' => true]);
		$this->assertEmpty($this->response->json->response->errors);

		$this->response = $this->provider->collectionsEntriesRemove(['id' => $timeline_id, 'tweet_id' => '507816092']);
		$this->assertEmpty($this->response->json->response->errors);

		$this->response = $this->provider->collectionsUpdate(['id' => $timeline_id, 'name' => $name, 'description' => 'testytest']);
		$this->assertSame('testytest', $this->response->json->objects->timelines->{$timeline_id}->description);

		$this->response = $this->provider->collectionsDestroy(['id' => $timeline_id]);
		$this->assertTrue($this->response->json->destroyed);

		// any leftovers?
		$this->response = $this->provider->collectionsList(['screen_name' => $this->screen_name]);

		if(isset($this->response->json->response->results) && is_array($this->response->json->response->results)){
			$timelines = array_column($this->response->json->response->results, 'timeline_id');

			if(is_array($timelines) && !empty($timelines)){

				foreach($timelines as $tl){
					$this->assertTrue($this->provider->collectionsDestroy(['id' => $tl])->json->destroyed);
				}

			}
		}

	}

	public function testDM(){
		$this->response = $this->provider->dm(['text' => 'DM test 🔥 https://twitter.com #'.$this->screen_name.' @'.$this->screen_name, 'screen_name' => $this->screen_name, 'user_id' => $this->user_id]);
		$this->assertSame($this->screen_name, $this->response->json->sender->screen_name);
		$id = $this->response->json->id_str;

		$this->response = $this->provider->directMessages(['trim_user' => true, 'include_entities' => false, 'skip_status' => true]);
		$this->assertTrue(isset($this->response->json[0]->id));

		$this->response = $this->provider->directMessagesSent(['trim_user' => true, 'include_entities' => false, 'skip_status' => true]);
		$this->assertTrue(isset($this->response->json[0]->id));

		$this->response = $this->provider->directMessagesEventsList();
		$this->assertTrue(is_array($this->response->json->events));

		$this->response = $this->provider->directMessagesDestroy(['id' => $id, 'trim_user' => true, 'include_entities' => false]);
		$this->assertSame($id, $this->response->json->id_str);
	}

	public function testDMEvents(){
		$this->response = $this->provider->dmEvent($this->user_id, 'DM Event test 🔥 https://twitter.com #'.$this->screen_name.' @'.$this->screen_name);
		$this->assertSame($this->user_id, $this->response->json->event->message_create->sender_id);
		$id = $this->response->json->event->id;

		$this->response = $this->provider->directMessagesEventsShow(['id' => $id, 'trim_user' => false, 'include_entities' => true]);
		$this->assertSame($id, $this->response->json->event->id);

		$this->response = $this->provider->directMessagesDestroy(['id' => $id, 'trim_user' => true, 'include_entities' => false]);
		$this->assertSame($id, $this->response->json->id_str);
	}

}
