<?php
/**
 * Class Flickr
 *
 * @filesource   Flickr.php
 * @created      20.10.2017
 * @package      chillerlan\OAuth\Providers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Providers;

use chillerlan\OAuth\HTTP\OAuthResponse;

/**
 * @link https://www.flickr.com/services/api/auth.oauth.html
 * @link https://www.flickr.com/services/api/
 *
 * @method mixed activityUserComments(array $params = ['per_page', 'page'])
 * @method mixed activityUserPhotos(array $params = ['timeframe', 'per_page', 'page'])
 * @method mixed authCheckToken(array $params = ['auth_token'])
 * @method mixed authGetFrob()
 * @method mixed authGetFullToken(array $params = ['mini_token'])
 * @method mixed authGetToken(array $params = ['frob'])
 * @method mixed authOauthCheckToken(array $params = ['oauth_token'])
 * @method mixed authOauthGetAccessToken()
 * @method mixed blogsGetList(array $params = ['service'])
 * @method mixed blogsGetServices()
 * @method mixed blogsPostPhoto(array $params = ['blog_id', 'photo_id', 'title', 'description', 'blog_password', 'service'])
 * @method mixed camerasGetBrandModels(array $params = ['brand'])
 * @method mixed camerasGetBrands()
 * @method mixed collectionsGetInfo(array $params = ['collection_id'])
 * @method mixed collectionsGetTree(array $params = ['collection_id', 'user_id'])
 * @method mixed commonsGetInstitutions()
 * @method mixed contactsGetList(array $params = ['filter', 'page', 'per_page', 'sort'])
 * @method mixed contactsGetListRecentlyUploaded(array $params = ['date_lastupload', 'filter'])
 * @method mixed contactsGetPublicList(array $params = ['user_id', 'page', 'per_page'])
 * @method mixed contactsGetTaggingSuggestions(array $params = ['per_page', 'page'])
 * @method mixed favoritesAdd(array $params = ['photo_id'])
 * @method mixed favoritesGetContext(array $params = ['photo_id', 'user_id'])
 * @method mixed favoritesGetList(array $params = ['user_id', 'min_fave_date', 'max_fave_date', 'extras', 'per_page', 'page'])
 * @method mixed favoritesGetPublicList(array $params = ['user_id', 'min_fave_date', 'max_fave_date', 'extras', 'per_page', 'page'])
 * @method mixed favoritesRemove(array $params = ['photo_id'])
 * @method mixed galleriesAddPhoto(array $params = ['gallery_id', 'photo_id', 'comment', 'full_response'])
 * @method mixed galleriesCreate(array $params = ['title', 'description', 'primary_photo_id', 'full_result'])
 * @method mixed galleriesEditMeta(array $params = ['gallery_id', 'title', 'description'])
 * @method mixed galleriesEditPhoto(array $params = ['gallery_id', 'photo_id', 'comment'])
 * @method mixed galleriesEditPhotos(array $params = ['gallery_id', 'primary_photo_id', 'photo_ids'])
 * @method mixed galleriesGetInfo(array $params = ['gallery_id'])
 * @method mixed galleriesGetList(array $params = ['user_id', 'per_page', 'page', 'primary_photo_extras'])
 * @method mixed galleriesGetListForPhoto(array $params = ['photo_id', 'per_page', 'page'])
 * @method mixed galleriesGetPhotos(array $params = ['gallery_id', 'extras', 'per_page', 'page'])
 * @method mixed galleriesRemovePhoto(array $params = ['gallery_id', 'photo_id', 'full_response'])
 * @method mixed groupsBrowse(array $params = ['cat_id'])
 * @method mixed groupsDiscussRepliesAdd(array $params = ['group_id', 'topic_id', 'message'])
 * @method mixed groupsDiscussRepliesDelete(array $params = ['group_id', 'topic_id', 'reply_id'])
 * @method mixed groupsDiscussRepliesEdit(array $params = ['group_id', 'topic_id', 'reply_id', 'message'])
 * @method mixed groupsDiscussRepliesGetInfo(array $params = ['group_id', 'topic_id', 'reply_id'])
 * @method mixed groupsDiscussRepliesGetList(array $params = ['group_id', 'topic_id', 'per_page', 'page'])
 * @method mixed groupsDiscussTopicsAdd(array $params = ['group_id', 'subject', 'message'])
 * @method mixed groupsDiscussTopicsGetInfo(array $params = ['group_id', 'topic_id'])
 * @method mixed groupsDiscussTopicsGetList(array $params = ['group_id', 'per_page', 'page'])
 * @method mixed groupsGetInfo(array $params = ['group_id', 'group_path_alias', 'lang'])
 * @method mixed groupsJoin(array $params = ['group_id', 'accept_rules'])
 * @method mixed groupsJoinRequest(array $params = ['group_id', 'message', 'accept_rules'])
 * @method mixed groupsLeave(array $params = ['group_id', 'delete_photos'])
 * @method mixed groupsMembersGetList(array $params = ['group_id', 'membertypes', 'per_page', 'page'])
 * @method mixed groupsPoolsAdd(array $params = ['photo_id', 'group_id'])
 * @method mixed groupsPoolsGetContext(array $params = ['photo_id', 'group_id'])
 * @method mixed groupsPoolsGetGroups(array $params = ['page', 'per_page'])
 * @method mixed groupsPoolsGetPhotos(array $params = ['group_id', 'tags', 'user_id', 'extras', 'per_page', 'page'])
 * @method mixed groupsPoolsRemove(array $params = ['photo_id', 'group_id'])
 * @method mixed groupsSearch(array $params = ['text', 'per_page', 'page'])
 * @method mixed interestingnessGetList(array $params = ['date', 'extras', 'per_page', 'page'])
 * @method mixed machinetagsGetNamespaces(array $params = ['predicate', 'per_page', 'page'])
 * @method mixed machinetagsGetPairs(array $params = ['namespace', 'predicate', 'per_page', 'page'])
 * @method mixed machinetagsGetPredicates(array $params = ['namespace', 'per_page', 'page'])
 * @method mixed machinetagsGetRecentValues(array $params = ['namespace', 'predicate', 'added_since'])
 * @method mixed machinetagsGetValues(array $params = ['namespace', 'predicate', 'per_page', 'page'])
 * @method mixed pandaGetList()
 * @method mixed pandaGetPhotos(array $params = ['panda_name', 'extras', 'per_page', 'page'])
 * @method mixed peopleFindByEmail(array $params = ['find_email'])
 * @method mixed peopleFindByUsername(array $params = ['username'])
 * @method mixed peopleGetGroups(array $params = ['user_id', 'extras'])
 * @method mixed peopleGetInfo(array $params = ['user_id'])
 * @method mixed peopleGetLimits()
 * @method mixed peopleGetPhotos(array $params = ['user_id', 'safe_search', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date', 'content_type', 'privacy_filter', 'extras', 'per_page', 'page'])
 * @method mixed peopleGetPhotosOf(array $params = ['user_id', 'owner_id', 'extras', 'per_page', 'page'])
 * @method mixed peopleGetPublicGroups(array $params = ['user_id', 'invitation_only'])
 * @method mixed peopleGetPublicPhotos(array $params = ['user_id', 'safe_search', 'extras', 'per_page', 'page'])
 * @method mixed peopleGetUploadStatus()
 * @method mixed photosAddTags(array $params = ['photo_id', 'tags'])
 * @method mixed photosCommentsAddComment(array $params = ['photo_id', 'comment_text'])
 * @method mixed photosCommentsDeleteComment(array $params = ['comment_id'])
 * @method mixed photosCommentsEditComment(array $params = ['comment_id', 'comment_text'])
 * @method mixed photosCommentsGetList(array $params = ['photo_id', 'min_comment_date', 'max_comment_date'])
 * @method mixed photosCommentsGetRecentForContacts(array $params = ['date_lastcomment', 'contacts_filter', 'extras', 'per_page', 'page'])
 * @method mixed photosDelete(array $params = ['photo_id'])
 * @method mixed photosGeoBatchCorrectLocation(array $params = ['lat', 'lon', 'accuracy', 'place_id', 'woe_id'])
 * @method mixed photosGeoCorrectLocation(array $params = ['photo_id', 'place_id', 'woe_id', 'foursquare_id'])
 * @method mixed photosGeoGetLocation(array $params = ['photo_id', 'extras'])
 * @method mixed photosGeoGetPerms(array $params = ['photo_id'])
 * @method mixed photosGeoPhotosForLocation(array $params = ['lat', 'lon', 'accuracy', 'extras', 'per_page', 'page'])
 * @method mixed photosGeoRemoveLocation(array $params = ['photo_id'])
 * @method mixed photosGeoSetContext(array $params = ['photo_id', 'context'])
 * @method mixed photosGeoSetLocation(array $params = ['photo_id', 'lat', 'lon', 'accuracy', 'context'])
 * @method mixed photosGeoSetPerms(array $params = ['is_public', 'is_contact', 'is_friend', 'is_family', 'photo_id'])
 * @method mixed photosGetAllContexts(array $params = ['photo_id'])
 * @method mixed photosGetContactsPhotos(array $params = ['count', 'just_friends', 'single_photo', 'include_self', 'extras'])
 * @method mixed photosGetContactsPublicPhotos(array $params = ['user_id', 'count', 'just_friends', 'single_photo', 'include_self', 'extras'])
 * @method mixed photosGetContext(array $params = ['photo_id'])
 * @method mixed photosGetCounts(array $params = ['dates', 'taken_dates'])
 * @method mixed photosGetExif(array $params = ['photo_id', 'secret'])
 * @method mixed photosGetFavorites(array $params = ['photo_id', 'page', 'per_page'])
 * @method mixed photosGetInfo(array $params = ['photo_id', 'secret'])
 * @method mixed photosGetNotInSet(array $params = ['max_upload_date', 'min_taken_date', 'max_taken_date', 'privacy_filter', 'media', 'min_upload_date', 'extras', 'per_page', 'page'])
 * @method mixed photosGetPerms(array $params = ['photo_id'])
 * @method mixed photosGetPopular(array $params = ['user_id', 'sort', 'extras', 'per_page', 'page'])
 * @method mixed photosGetRecent(array $params = ['extras', 'per_page', 'page'])
 * @method mixed photosGetSizes(array $params = ['photo_id'])
 * @method mixed photosGetUntagged(array $params = ['min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date', 'privacy_filter', 'media', 'extras', 'per_page', 'page'])
 * @method mixed photosGetWithGeoData(array $params = ['min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date', 'privacy_filter', 'sort', 'media', 'extras', 'per_page', 'page'])
 * @method mixed photosGetWithoutGeoData(array $params = ['max_upload_date', 'min_taken_date', 'max_taken_date', 'privacy_filter', 'sort', 'media', 'min_upload_date', 'extras', 'per_page', 'page'])
 * @method mixed photosLicensesGetInfo()
 * @method mixed photosLicensesSetLicense(array $params = ['photo_id', 'license_id'])
 * @method mixed photosNotesAdd(array $params = ['photo_id', 'note_x', 'note_y', 'note_w', 'note_h', 'note_text'])
 * @method mixed photosNotesDelete(array $params = ['note_id'])
 * @method mixed photosNotesEdit(array $params = ['note_id', 'note_x', 'note_y', 'note_w', 'note_h', 'note_text'])
 * @method mixed photosPeopleAdd(array $params = ['photo_id', 'user_id', 'person_x', 'person_y', 'person_w', 'person_h'])
 * @method mixed photosPeopleDelete(array $params = ['photo_id', 'user_id'])
 * @method mixed photosPeopleDeleteCoords(array $params = ['photo_id', 'user_id'])
 * @method mixed photosPeopleEditCoords(array $params = ['photo_id', 'user_id', 'person_x', 'person_y', 'person_w', 'person_h'])
 * @method mixed photosPeopleGetList(array $params = ['photo_id'])
 * @method mixed photosRecentlyUpdated(array $params = ['min_date', 'extras', 'per_page', 'page'])
 * @method mixed photosRemoveTag(array $params = ['tag_id'])
 * @method mixed photosSearch(array $params = ['user_id', 'tags', 'tag_mode', 'text', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date', 'license', 'sort', 'privacy_filter', 'bbox', 'accuracy', 'safe_search', 'content_type', 'machine_tags', 'machine_tag_mode', 'group_id', 'contacts', 'woe_id', 'place_id', 'media', 'has_geo', 'geo_context', 'lat', 'lon', 'radius', 'radius_units', 'is_commons', 'in_gallery', 'is_getty', 'extras', 'per_page', 'page'])
 * @method mixed photosSetContentType(array $params = ['photo_id', 'content_type'])
 * @method mixed photosSetDates(array $params = ['photo_id', 'date_posted', 'date_taken', 'date_taken_granularity'])
 * @method mixed photosSetMeta(array $params = ['photo_id', 'title', 'description'])
 * @method mixed photosSetPerms(array $params = ['photo_id', 'is_public', 'is_friend', 'is_family', 'perm_comment', 'perm_addmeta'])
 * @method mixed photosSetSafetyLevel(array $params = ['photo_id', 'safety_level', 'hidden'])
 * @method mixed photosSetTags(array $params = ['photo_id', 'tags'])
 * @method mixed photosSuggestionsApproveSuggestion(array $params = ['suggestion_id'])
 * @method mixed photosSuggestionsGetList(array $params = ['photo_id', 'status_id'])
 * @method mixed photosSuggestionsRejectSuggestion(array $params = ['suggestion_id'])
 * @method mixed photosSuggestionsRemoveSuggestion(array $params = ['suggestion_id'])
 * @method mixed photosSuggestionsSuggestLocation(array $params = ['photo_id', 'lat', 'lon', 'accuracy', 'woe_id', 'place_id', 'note'])
 * @method mixed photosTransformRotate(array $params = ['photo_id', 'degrees'])
 * @method mixed photosUploadCheckTickets(array $params = ['tickets'])
 * @method mixed photosetsAddPhoto(array $params = ['photoset_id', 'photo_id'])
 * @method mixed photosetsCommentsAddComment(array $params = ['photoset_id', 'comment_text'])
 * @method mixed photosetsCommentsDeleteComment(array $params = ['comment_id'])
 * @method mixed photosetsCommentsEditComment(array $params = ['comment_id', 'comment_text'])
 * @method mixed photosetsCommentsGetList(array $params = ['photoset_id'])
 * @method mixed photosetsCreate(array $params = ['title', 'description', 'primary_photo_id'])
 * @method mixed photosetsDelete(array $params = ['photoset_id'])
 * @method mixed photosetsEditMeta(array $params = ['photoset_id', 'title', 'description'])
 * @method mixed photosetsEditPhotos(array $params = ['photoset_id', 'primary_photo_id', 'photo_ids'])
 * @method mixed photosetsGetContext(array $params = ['photo_id', 'photoset_id'])
 * @method mixed photosetsGetInfo(array $params = ['photoset_id', 'user_id'])
 * @method mixed photosetsGetList(array $params = ['user_id', 'page', 'per_page', 'primary_photo_extras'])
 * @method mixed photosetsGetPhotos(array $params = ['photoset_id', 'user_id', 'extras', 'per_page', 'page', 'privacy_filter', 'media'])
 * @method mixed photosetsOrderSets(array $params = ['photoset_ids'])
 * @method mixed photosetsRemovePhoto(array $params = ['photoset_id', 'photo_id'])
 * @method mixed photosetsRemovePhotos(array $params = ['photoset_id', 'photo_ids'])
 * @method mixed photosetsReorderPhotos(array $params = ['photoset_id', 'photo_ids'])
 * @method mixed photosetsSetPrimaryPhoto(array $params = ['photoset_id', 'photo_id'])
 * @method mixed placesFind(array $params = ['query'])
 * @method mixed placesFindByLatLon(array $params = ['lat', 'lon', 'accuracy'])
 * @method mixed placesGetChildrenWithPhotosPublic(array $params = ['place_id', 'woe_id'])
 * @method mixed placesGetInfo(array $params = ['place_id', 'woe_id'])
 * @method mixed placesGetInfoByUrl(array $params = ['url'])
 * @method mixed placesGetPlaceTypes()
 * @method mixed placesGetShapeHistory(array $params = ['place_id', 'woe_id'])
 * @method mixed placesGetTopPlacesList(array $params = ['place_type_id', 'date', 'woe_id', 'place_id'])
 * @method mixed placesPlacesForBoundingBox(array $params = ['bbox', 'place_type', 'place_type_id'])
 * @method mixed placesPlacesForContacts(array $params = ['place_type', 'place_type_id', 'woe_id', 'place_id', 'threshold', 'contacts', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date'])
 * @method mixed placesPlacesForTags(array $params = ['place_type_id', 'woe_id', 'place_id', 'threshold', 'tags', 'tag_mode', 'machine_tags', 'machine_tag_mode', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date'])
 * @method mixed placesPlacesForUser(array $params = ['place_type_id', 'place_type', 'woe_id', 'place_id', 'threshold', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date'])
 * @method mixed placesResolvePlaceId(array $params = ['place_id'])
 * @method mixed placesResolvePlaceURL(array $params = ['url'])
 * @method mixed placesTagsForPlace(array $params = ['woe_id', 'place_id', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date'])
 * @method mixed prefsGetContentType()
 * @method mixed prefsGetGeoPerms()
 * @method mixed prefsGetHidden()
 * @method mixed prefsGetPrivacy()
 * @method mixed prefsGetSafetyLevel()
 * @method mixed profileGetProfile(array $params = ['user_id'])
 * @method mixed pushGetSubscriptions()
 * @method mixed pushGetTopics()
 * @method mixed pushSubscribe(array $params = ['topic', 'callback', 'verify', 'verify_token', 'lease_seconds', 'woe_ids', 'place_ids', 'lat', 'lon', 'radius', 'radius_units', 'accuracy', 'nsids', 'tags'])
 * @method mixed pushUnsubscribe(array $params = ['topic', 'callback', 'verify', 'verify_token'])
 * @method mixed reflectionGetMethodInfo(array $params = ['method_name'])
 * @method mixed reflectionGetMethods()
 * @method mixed statsGetCSVFiles()
 * @method mixed statsGetCollectionDomains(array $params = ['date', 'collection_id', 'per_page', 'page'])
 * @method mixed statsGetCollectionReferrers(array $params = ['date', 'domain', 'collection_id', 'per_page', 'page'])
 * @method mixed statsGetCollectionStats(array $params = ['date', 'collection_id'])
 * @method mixed statsGetPhotoDomains(array $params = ['date', 'photo_id', 'per_page', 'page'])
 * @method mixed statsGetPhotoReferrers(array $params = ['date', 'domain', 'photo_id', 'per_page', 'page'])
 * @method mixed statsGetPhotoStats(array $params = ['date', 'photo_id'])
 * @method mixed statsGetPhotosetDomains(array $params = ['date', 'photoset_id', 'per_page', 'page'])
 * @method mixed statsGetPhotosetReferrers(array $params = ['date', 'domain', 'photoset_id', 'per_page', 'page'])
 * @method mixed statsGetPhotosetStats(array $params = ['date', 'photoset_id'])
 * @method mixed statsGetPhotostreamDomains(array $params = ['date', 'per_page', 'page'])
 * @method mixed statsGetPhotostreamReferrers(array $params = ['date', 'domain', 'per_page', 'page'])
 * @method mixed statsGetPhotostreamStats(array $params = ['date'])
 * @method mixed statsGetPopularPhotos(array $params = ['date', 'sort', 'per_page', 'page'])
 * @method mixed statsGetTotalViews(array $params = ['date'])
 * @method mixed tagsGetClusterPhotos(array $params = ['tag', 'cluster_id'])
 * @method mixed tagsGetClusters(array $params = ['tag'])
 * @method mixed tagsGetHotList(array $params = ['period', 'count'])
 * @method mixed tagsGetListPhoto(array $params = ['photo_id'])
 * @method mixed tagsGetListUser(array $params = ['user_id'])
 * @method mixed tagsGetListUserPopular(array $params = ['user_id', 'count'])
 * @method mixed tagsGetListUserRaw(array $params = ['tag'])
 * @method mixed tagsGetMostFrequentlyUsed()
 * @method mixed tagsGetRelated(array $params = ['tag'])
 * @method mixed testEcho()
 * @method mixed testLogin()
 * @method mixed testNull()
 * @method mixed testimonialsAddTestimonial(array $params = ['user_id', 'testimonial_text'])
 * @method mixed testimonialsApproveTestimonial(array $params = ['testimonial_id'])
 * @method mixed testimonialsDeleteTestimonial(array $params = ['testimonial_id'])
 * @method mixed testimonialsEditTestimonial(array $params = ['user_id', 'testimonial_id', 'testimonial_text'])
 * @method mixed testimonialsGetAllTestimonialsAbout(array $params = ['page', 'per_page'])
 * @method mixed testimonialsGetAllTestimonialsAboutBy(array $params = ['user_id'])
 * @method mixed testimonialsGetAllTestimonialsBy(array $params = ['page', 'per_page'])
 * @method mixed testimonialsGetPendingTestimonialsAbout(array $params = ['page', 'per_page'])
 * @method mixed testimonialsGetPendingTestimonialsAboutBy(array $params = ['user_id'])
 * @method mixed testimonialsGetPendingTestimonialsBy(array $params = ['page', 'per_page'])
 * @method mixed testimonialsGetTestimonialsAbout(array $params = ['user_id', 'page', 'per_page'])
 * @method mixed testimonialsGetTestimonialsAboutBy(array $params = ['user_id'])
 * @method mixed testimonialsGetTestimonialsBy(array $params = ['user_id', 'page', 'per_page'])
 * @method mixed urlsGetGroup(array $params = ['group_id'])
 * @method mixed urlsGetUserPhotos(array $params = ['user_id'])
 * @method mixed urlsGetUserProfile(array $params = ['user_id'])
 * @method mixed urlsLookupGallery(array $params = ['url'])
 * @method mixed urlsLookupGroup(array $params = ['url'])
 * @method mixed urlsLookupUser(array $params = ['url'])
 */
class Flickr extends OAuth1Provider{

	const PERM_READ   = 'read';
	const PERM_WRITE  = 'write';
	const PERM_DELETE = 'delete';

	protected $apiURL          = 'https://api.flickr.com/services/rest';
	protected $requestTokenURL = 'https://www.flickr.com/services/oauth/request_token';
	protected $authURL         = 'https://www.flickr.com/services/oauth/authorize';
	protected $accessTokenURL  = 'https://www.flickr.com/services/oauth/access_token';
	protected $userRevokeURL   = 'https://www.flickr.com/services/auth/list.gne';

	/**
	 * @param string $path
	 * @param array  $params
	 * @param string $method
	 * @param null   $body
	 * @param array  $headers
	 *
	 * @return \chillerlan\OAuth\HTTP\OAuthResponse
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function request(string $path, array $params = [], string $method = 'GET', $body = null, array $headers = []):OAuthResponse{

		$params = array_merge($params, [
			'method'         => $path,
			'format'         => 'json',
			'nojsoncallback' => true,
		]);

		$headers = $this->requestHeaders(
			$this->apiURL,
			$params,
			$method,
			$headers,
			$this->storage->retrieveAccessToken($this->serviceName)
		);

		return $this->http->request($this->apiURL, $params, $method, $body, $headers);
	}

}
