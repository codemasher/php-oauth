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
 * @method \chillerlan\OAuth\HTTP\OAuthResponse activityUserComments(array $params = ['per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse activityUserPhotos(array $params = ['timeframe', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse authCheckToken(array $params = ['auth_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse authGetFrob()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse authGetFullToken(array $params = ['mini_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse authGetToken(array $params = ['frob'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse authOauthCheckToken(array $params = ['oauth_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse authOauthGetAccessToken()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse blogsGetList(array $params = ['service'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse blogsGetServices()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse blogsPostPhoto(array $params = ['blog_id', 'photo_id', 'title', 'description', 'blog_password', 'service'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse camerasGetBrandModels(array $params = ['brand'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse camerasGetBrands()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionsGetInfo(array $params = ['collection_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse collectionsGetTree(array $params = ['collection_id', 'user_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse commonsGetInstitutions()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse contactsGetList(array $params = ['filter', 'page', 'per_page', 'sort'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse contactsGetListRecentlyUploaded(array $params = ['date_lastupload', 'filter'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse contactsGetPublicList(array $params = ['user_id', 'page', 'per_page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse contactsGetTaggingSuggestions(array $params = ['per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse favoritesAdd(array $params = ['photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse favoritesGetContext(array $params = ['photo_id', 'user_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse favoritesGetList(array $params = ['user_id', 'min_fave_date', 'max_fave_date', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse favoritesGetPublicList(array $params = ['user_id', 'min_fave_date', 'max_fave_date', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse favoritesRemove(array $params = ['photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse galleriesAddPhoto(array $params = ['gallery_id', 'photo_id', 'comment', 'full_response'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse galleriesCreate(array $params = ['title', 'description', 'primary_photo_id', 'full_result'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse galleriesEditMeta(array $params = ['gallery_id', 'title', 'description'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse galleriesEditPhoto(array $params = ['gallery_id', 'photo_id', 'comment'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse galleriesEditPhotos(array $params = ['gallery_id', 'primary_photo_id', 'photo_ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse galleriesGetInfo(array $params = ['gallery_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse galleriesGetList(array $params = ['user_id', 'per_page', 'page', 'primary_photo_extras'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse galleriesGetListForPhoto(array $params = ['photo_id', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse galleriesGetPhotos(array $params = ['gallery_id', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse galleriesRemovePhoto(array $params = ['gallery_id', 'photo_id', 'full_response'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsBrowse(array $params = ['cat_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsDiscussRepliesAdd(array $params = ['group_id', 'topic_id', 'message'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsDiscussRepliesDelete(array $params = ['group_id', 'topic_id', 'reply_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsDiscussRepliesEdit(array $params = ['group_id', 'topic_id', 'reply_id', 'message'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsDiscussRepliesGetInfo(array $params = ['group_id', 'topic_id', 'reply_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsDiscussRepliesGetList(array $params = ['group_id', 'topic_id', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsDiscussTopicsAdd(array $params = ['group_id', 'subject', 'message'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsDiscussTopicsGetInfo(array $params = ['group_id', 'topic_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsDiscussTopicsGetList(array $params = ['group_id', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsGetInfo(array $params = ['group_id', 'group_path_alias', 'lang'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsJoin(array $params = ['group_id', 'accept_rules'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsJoinRequest(array $params = ['group_id', 'message', 'accept_rules'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsLeave(array $params = ['group_id', 'delete_photos'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsMembersGetList(array $params = ['group_id', 'membertypes', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsPoolsAdd(array $params = ['photo_id', 'group_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsPoolsGetContext(array $params = ['photo_id', 'group_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsPoolsGetGroups(array $params = ['page', 'per_page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsPoolsGetPhotos(array $params = ['group_id', 'tags', 'user_id', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsPoolsRemove(array $params = ['photo_id', 'group_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse groupsSearch(array $params = ['text', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse interestingnessGetList(array $params = ['date', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse machinetagsGetNamespaces(array $params = ['predicate', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse machinetagsGetPairs(array $params = ['namespace', 'predicate', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse machinetagsGetPredicates(array $params = ['namespace', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse machinetagsGetRecentValues(array $params = ['namespace', 'predicate', 'added_since'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse machinetagsGetValues(array $params = ['namespace', 'predicate', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pandaGetList()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pandaGetPhotos(array $params = ['panda_name', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse peopleFindByEmail(array $params = ['find_email'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse peopleFindByUsername(array $params = ['username'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse peopleGetGroups(array $params = ['user_id', 'extras'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse peopleGetInfo(array $params = ['user_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse peopleGetLimits()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse peopleGetPhotos(array $params = ['user_id', 'safe_search', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date', 'content_type', 'privacy_filter', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse peopleGetPhotosOf(array $params = ['user_id', 'owner_id', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse peopleGetPublicGroups(array $params = ['user_id', 'invitation_only'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse peopleGetPublicPhotos(array $params = ['user_id', 'safe_search', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse peopleGetUploadStatus()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosAddTags(array $params = ['photo_id', 'tags'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosCommentsAddComment(array $params = ['photo_id', 'comment_text'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosCommentsDeleteComment(array $params = ['comment_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosCommentsEditComment(array $params = ['comment_id', 'comment_text'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosCommentsGetList(array $params = ['photo_id', 'min_comment_date', 'max_comment_date'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosCommentsGetRecentForContacts(array $params = ['date_lastcomment', 'contacts_filter', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosDelete(array $params = ['photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGeoBatchCorrectLocation(array $params = ['lat', 'lon', 'accuracy', 'place_id', 'woe_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGeoCorrectLocation(array $params = ['photo_id', 'place_id', 'woe_id', 'foursquare_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGeoGetLocation(array $params = ['photo_id', 'extras'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGeoGetPerms(array $params = ['photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGeoPhotosForLocation(array $params = ['lat', 'lon', 'accuracy', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGeoRemoveLocation(array $params = ['photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGeoSetContext(array $params = ['photo_id', 'context'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGeoSetLocation(array $params = ['photo_id', 'lat', 'lon', 'accuracy', 'context'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGeoSetPerms(array $params = ['is_public', 'is_contact', 'is_friend', 'is_family', 'photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetAllContexts(array $params = ['photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetContactsPhotos(array $params = ['count', 'just_friends', 'single_photo', 'include_self', 'extras'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetContactsPublicPhotos(array $params = ['user_id', 'count', 'just_friends', 'single_photo', 'include_self', 'extras'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetContext(array $params = ['photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetCounts(array $params = ['dates', 'taken_dates'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetExif(array $params = ['photo_id', 'secret'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetFavorites(array $params = ['photo_id', 'page', 'per_page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetInfo(array $params = ['photo_id', 'secret'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetNotInSet(array $params = ['max_upload_date', 'min_taken_date', 'max_taken_date', 'privacy_filter', 'media', 'min_upload_date', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetPerms(array $params = ['photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetPopular(array $params = ['user_id', 'sort', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetRecent(array $params = ['extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetSizes(array $params = ['photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetUntagged(array $params = ['min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date', 'privacy_filter', 'media', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetWithGeoData(array $params = ['min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date', 'privacy_filter', 'sort', 'media', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosGetWithoutGeoData(array $params = ['max_upload_date', 'min_taken_date', 'max_taken_date', 'privacy_filter', 'sort', 'media', 'min_upload_date', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosLicensesGetInfo()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosLicensesSetLicense(array $params = ['photo_id', 'license_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosNotesAdd(array $params = ['photo_id', 'note_x', 'note_y', 'note_w', 'note_h', 'note_text'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosNotesDelete(array $params = ['note_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosNotesEdit(array $params = ['note_id', 'note_x', 'note_y', 'note_w', 'note_h', 'note_text'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosPeopleAdd(array $params = ['photo_id', 'user_id', 'person_x', 'person_y', 'person_w', 'person_h'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosPeopleDelete(array $params = ['photo_id', 'user_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosPeopleDeleteCoords(array $params = ['photo_id', 'user_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosPeopleEditCoords(array $params = ['photo_id', 'user_id', 'person_x', 'person_y', 'person_w', 'person_h'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosPeopleGetList(array $params = ['photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosRecentlyUpdated(array $params = ['min_date', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosRemoveTag(array $params = ['tag_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosSearch(array $params = ['user_id', 'tags', 'tag_mode', 'text', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date', 'license', 'sort', 'privacy_filter', 'bbox', 'accuracy', 'safe_search', 'content_type', 'machine_tags', 'machine_tag_mode', 'group_id', 'contacts', 'woe_id', 'place_id', 'media', 'has_geo', 'geo_context', 'lat', 'lon', 'radius', 'radius_units', 'is_commons', 'in_gallery', 'is_getty', 'extras', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosSetContentType(array $params = ['photo_id', 'content_type'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosSetDates(array $params = ['photo_id', 'date_posted', 'date_taken', 'date_taken_granularity'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosSetMeta(array $params = ['photo_id', 'title', 'description'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosSetPerms(array $params = ['photo_id', 'is_public', 'is_friend', 'is_family', 'perm_comment', 'perm_addmeta'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosSetSafetyLevel(array $params = ['photo_id', 'safety_level', 'hidden'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosSetTags(array $params = ['photo_id', 'tags'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosSuggestionsApproveSuggestion(array $params = ['suggestion_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosSuggestionsGetList(array $params = ['photo_id', 'status_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosSuggestionsRejectSuggestion(array $params = ['suggestion_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosSuggestionsRemoveSuggestion(array $params = ['suggestion_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosSuggestionsSuggestLocation(array $params = ['photo_id', 'lat', 'lon', 'accuracy', 'woe_id', 'place_id', 'note'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosTransformRotate(array $params = ['photo_id', 'degrees'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosUploadCheckTickets(array $params = ['tickets'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsAddPhoto(array $params = ['photoset_id', 'photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsCommentsAddComment(array $params = ['photoset_id', 'comment_text'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsCommentsDeleteComment(array $params = ['comment_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsCommentsEditComment(array $params = ['comment_id', 'comment_text'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsCommentsGetList(array $params = ['photoset_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsCreate(array $params = ['title', 'description', 'primary_photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsDelete(array $params = ['photoset_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsEditMeta(array $params = ['photoset_id', 'title', 'description'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsEditPhotos(array $params = ['photoset_id', 'primary_photo_id', 'photo_ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsGetContext(array $params = ['photo_id', 'photoset_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsGetInfo(array $params = ['photoset_id', 'user_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsGetList(array $params = ['user_id', 'page', 'per_page', 'primary_photo_extras'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsGetPhotos(array $params = ['photoset_id', 'user_id', 'extras', 'per_page', 'page', 'privacy_filter', 'media'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsOrderSets(array $params = ['photoset_ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsRemovePhoto(array $params = ['photoset_id', 'photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsRemovePhotos(array $params = ['photoset_id', 'photo_ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsReorderPhotos(array $params = ['photoset_id', 'photo_ids'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse photosetsSetPrimaryPhoto(array $params = ['photoset_id', 'photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesFind(array $params = ['query'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesFindByLatLon(array $params = ['lat', 'lon', 'accuracy'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesGetChildrenWithPhotosPublic(array $params = ['place_id', 'woe_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesGetInfo(array $params = ['place_id', 'woe_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesGetInfoByUrl(array $params = ['url'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesGetPlaceTypes()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesGetShapeHistory(array $params = ['place_id', 'woe_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesGetTopPlacesList(array $params = ['place_type_id', 'date', 'woe_id', 'place_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesPlacesForBoundingBox(array $params = ['bbox', 'place_type', 'place_type_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesPlacesForContacts(array $params = ['place_type', 'place_type_id', 'woe_id', 'place_id', 'threshold', 'contacts', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesPlacesForTags(array $params = ['place_type_id', 'woe_id', 'place_id', 'threshold', 'tags', 'tag_mode', 'machine_tags', 'machine_tag_mode', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesPlacesForUser(array $params = ['place_type_id', 'place_type', 'woe_id', 'place_id', 'threshold', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesResolvePlaceId(array $params = ['place_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesResolvePlaceURL(array $params = ['url'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse placesTagsForPlace(array $params = ['woe_id', 'place_id', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse prefsGetContentType()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse prefsGetGeoPerms()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse prefsGetHidden()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse prefsGetPrivacy()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse prefsGetSafetyLevel()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse profileGetProfile(array $params = ['user_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pushGetSubscriptions()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pushGetTopics()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pushSubscribe(array $params = ['topic', 'callback', 'verify', 'verify_token', 'lease_seconds', 'woe_ids', 'place_ids', 'lat', 'lon', 'radius', 'radius_units', 'accuracy', 'nsids', 'tags'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse pushUnsubscribe(array $params = ['topic', 'callback', 'verify', 'verify_token'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse reflectionGetMethodInfo(array $params = ['method_name'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse reflectionGetMethods()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetCSVFiles()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetCollectionDomains(array $params = ['date', 'collection_id', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetCollectionReferrers(array $params = ['date', 'domain', 'collection_id', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetCollectionStats(array $params = ['date', 'collection_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetPhotoDomains(array $params = ['date', 'photo_id', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetPhotoReferrers(array $params = ['date', 'domain', 'photo_id', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetPhotoStats(array $params = ['date', 'photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetPhotosetDomains(array $params = ['date', 'photoset_id', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetPhotosetReferrers(array $params = ['date', 'domain', 'photoset_id', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetPhotosetStats(array $params = ['date', 'photoset_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetPhotostreamDomains(array $params = ['date', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetPhotostreamReferrers(array $params = ['date', 'domain', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetPhotostreamStats(array $params = ['date'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetPopularPhotos(array $params = ['date', 'sort', 'per_page', 'page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse statsGetTotalViews(array $params = ['date'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagsGetClusterPhotos(array $params = ['tag', 'cluster_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagsGetClusters(array $params = ['tag'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagsGetHotList(array $params = ['period', 'count'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagsGetListPhoto(array $params = ['photo_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagsGetListUser(array $params = ['user_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagsGetListUserPopular(array $params = ['user_id', 'count'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagsGetListUserRaw(array $params = ['tag'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagsGetMostFrequentlyUsed()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse tagsGetRelated(array $params = ['tag'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testEcho()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testLogin()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testNull()
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testimonialsAddTestimonial(array $params = ['user_id', 'testimonial_text'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testimonialsApproveTestimonial(array $params = ['testimonial_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testimonialsDeleteTestimonial(array $params = ['testimonial_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testimonialsEditTestimonial(array $params = ['user_id', 'testimonial_id', 'testimonial_text'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testimonialsGetAllTestimonialsAbout(array $params = ['page', 'per_page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testimonialsGetAllTestimonialsAboutBy(array $params = ['user_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testimonialsGetAllTestimonialsBy(array $params = ['page', 'per_page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testimonialsGetPendingTestimonialsAbout(array $params = ['page', 'per_page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testimonialsGetPendingTestimonialsAboutBy(array $params = ['user_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testimonialsGetPendingTestimonialsBy(array $params = ['page', 'per_page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testimonialsGetTestimonialsAbout(array $params = ['user_id', 'page', 'per_page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testimonialsGetTestimonialsAboutBy(array $params = ['user_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse testimonialsGetTestimonialsBy(array $params = ['user_id', 'page', 'per_page'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse urlsGetGroup(array $params = ['group_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse urlsGetUserPhotos(array $params = ['user_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse urlsGetUserProfile(array $params = ['user_id'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse urlsLookupGallery(array $params = ['url'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse urlsLookupGroup(array $params = ['url'])
 * @method \chillerlan\OAuth\HTTP\OAuthResponse urlsLookupUser(array $params = ['url'])
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
	 */
	public function request(string $path, array $params = null, string $method = null, $body = null, array $headers = null):OAuthResponse{
		$method = $method ?? 'GET';

		$params = array_merge($params ?? [], [
			'method'         => $path,
			'format'         => 'json',
			'nojsoncallback' => true,
		]);

		$headers = $this->requestHeaders($this->apiURL, $params, $method, $headers, $this->storage->retrieveAccessToken($this->serviceName));

		return $this->http->request($this->apiURL, $params, $method, $body, $headers);
	}

}
