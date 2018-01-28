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

use chillerlan\HTTP\HTTPResponseInterface;

/**
 * @link https://www.flickr.com/services/api/auth.oauth.html
 * @link https://www.flickr.com/services/api/
 *
 * @method \chillerlan\HTTP\HTTPResponseInterface activityUserComments(array $params = ['per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface activityUserPhotos(array $params = ['timeframe', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface authCheckToken(array $params = ['auth_token'])
 * @method \chillerlan\HTTP\HTTPResponseInterface authGetFrob()
 * @method \chillerlan\HTTP\HTTPResponseInterface authGetFullToken(array $params = ['mini_token'])
 * @method \chillerlan\HTTP\HTTPResponseInterface authGetToken(array $params = ['frob'])
 * @method \chillerlan\HTTP\HTTPResponseInterface authOauthCheckToken(array $params = ['oauth_token'])
 * @method \chillerlan\HTTP\HTTPResponseInterface authOauthGetAccessToken()
 * @method \chillerlan\HTTP\HTTPResponseInterface blogsGetList(array $params = ['service'])
 * @method \chillerlan\HTTP\HTTPResponseInterface blogsGetServices()
 * @method \chillerlan\HTTP\HTTPResponseInterface blogsPostPhoto(array $params = ['blog_id', 'photo_id', 'title', 'description', 'blog_password', 'service'])
 * @method \chillerlan\HTTP\HTTPResponseInterface camerasGetBrandModels(array $params = ['brand'])
 * @method \chillerlan\HTTP\HTTPResponseInterface camerasGetBrands()
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionsGetInfo(array $params = ['collection_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface collectionsGetTree(array $params = ['collection_id', 'user_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface commonsGetInstitutions()
 * @method \chillerlan\HTTP\HTTPResponseInterface contactsGetList(array $params = ['filter', 'page', 'per_page', 'sort'])
 * @method \chillerlan\HTTP\HTTPResponseInterface contactsGetListRecentlyUploaded(array $params = ['date_lastupload', 'filter'])
 * @method \chillerlan\HTTP\HTTPResponseInterface contactsGetPublicList(array $params = ['user_id', 'page', 'per_page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface contactsGetTaggingSuggestions(array $params = ['per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface favoritesAdd(array $params = ['photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface favoritesGetContext(array $params = ['photo_id', 'user_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface favoritesGetList(array $params = ['user_id', 'min_fave_date', 'max_fave_date', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface favoritesGetPublicList(array $params = ['user_id', 'min_fave_date', 'max_fave_date', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface favoritesRemove(array $params = ['photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface galleriesAddPhoto(array $params = ['gallery_id', 'photo_id', 'comment', 'full_response'])
 * @method \chillerlan\HTTP\HTTPResponseInterface galleriesCreate(array $params = ['title', 'description', 'primary_photo_id', 'full_result'])
 * @method \chillerlan\HTTP\HTTPResponseInterface galleriesEditMeta(array $params = ['gallery_id', 'title', 'description'])
 * @method \chillerlan\HTTP\HTTPResponseInterface galleriesEditPhoto(array $params = ['gallery_id', 'photo_id', 'comment'])
 * @method \chillerlan\HTTP\HTTPResponseInterface galleriesEditPhotos(array $params = ['gallery_id', 'primary_photo_id', 'photo_ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface galleriesGetInfo(array $params = ['gallery_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface galleriesGetList(array $params = ['user_id', 'per_page', 'page', 'primary_photo_extras'])
 * @method \chillerlan\HTTP\HTTPResponseInterface galleriesGetListForPhoto(array $params = ['photo_id', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface galleriesGetPhotos(array $params = ['gallery_id', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface galleriesRemovePhoto(array $params = ['gallery_id', 'photo_id', 'full_response'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsBrowse(array $params = ['cat_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsDiscussRepliesAdd(array $params = ['group_id', 'topic_id', 'message'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsDiscussRepliesDelete(array $params = ['group_id', 'topic_id', 'reply_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsDiscussRepliesEdit(array $params = ['group_id', 'topic_id', 'reply_id', 'message'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsDiscussRepliesGetInfo(array $params = ['group_id', 'topic_id', 'reply_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsDiscussRepliesGetList(array $params = ['group_id', 'topic_id', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsDiscussTopicsAdd(array $params = ['group_id', 'subject', 'message'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsDiscussTopicsGetInfo(array $params = ['group_id', 'topic_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsDiscussTopicsGetList(array $params = ['group_id', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsGetInfo(array $params = ['group_id', 'group_path_alias', 'lang'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsJoin(array $params = ['group_id', 'accept_rules'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsJoinRequest(array $params = ['group_id', 'message', 'accept_rules'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsLeave(array $params = ['group_id', 'delete_photos'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsMembersGetList(array $params = ['group_id', 'membertypes', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsPoolsAdd(array $params = ['photo_id', 'group_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsPoolsGetContext(array $params = ['photo_id', 'group_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsPoolsGetGroups(array $params = ['page', 'per_page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsPoolsGetPhotos(array $params = ['group_id', 'tags', 'user_id', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsPoolsRemove(array $params = ['photo_id', 'group_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface groupsSearch(array $params = ['text', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface interestingnessGetList(array $params = ['date', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface machinetagsGetNamespaces(array $params = ['predicate', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface machinetagsGetPairs(array $params = ['namespace', 'predicate', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface machinetagsGetPredicates(array $params = ['namespace', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface machinetagsGetRecentValues(array $params = ['namespace', 'predicate', 'added_since'])
 * @method \chillerlan\HTTP\HTTPResponseInterface machinetagsGetValues(array $params = ['namespace', 'predicate', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface pandaGetList()
 * @method \chillerlan\HTTP\HTTPResponseInterface pandaGetPhotos(array $params = ['panda_name', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface peopleFindByEmail(array $params = ['find_email'])
 * @method \chillerlan\HTTP\HTTPResponseInterface peopleFindByUsername(array $params = ['username'])
 * @method \chillerlan\HTTP\HTTPResponseInterface peopleGetGroups(array $params = ['user_id', 'extras'])
 * @method \chillerlan\HTTP\HTTPResponseInterface peopleGetInfo(array $params = ['user_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface peopleGetLimits()
 * @method \chillerlan\HTTP\HTTPResponseInterface peopleGetPhotos(array $params = ['user_id', 'safe_search', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date', 'content_type', 'privacy_filter', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface peopleGetPhotosOf(array $params = ['user_id', 'owner_id', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface peopleGetPublicGroups(array $params = ['user_id', 'invitation_only'])
 * @method \chillerlan\HTTP\HTTPResponseInterface peopleGetPublicPhotos(array $params = ['user_id', 'safe_search', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface peopleGetUploadStatus()
 * @method \chillerlan\HTTP\HTTPResponseInterface photosAddTags(array $params = ['photo_id', 'tags'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosCommentsAddComment(array $params = ['photo_id', 'comment_text'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosCommentsDeleteComment(array $params = ['comment_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosCommentsEditComment(array $params = ['comment_id', 'comment_text'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosCommentsGetList(array $params = ['photo_id', 'min_comment_date', 'max_comment_date'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosCommentsGetRecentForContacts(array $params = ['date_lastcomment', 'contacts_filter', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosDelete(array $params = ['photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGeoBatchCorrectLocation(array $params = ['lat', 'lon', 'accuracy', 'place_id', 'woe_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGeoCorrectLocation(array $params = ['photo_id', 'place_id', 'woe_id', 'foursquare_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGeoGetLocation(array $params = ['photo_id', 'extras'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGeoGetPerms(array $params = ['photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGeoPhotosForLocation(array $params = ['lat', 'lon', 'accuracy', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGeoRemoveLocation(array $params = ['photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGeoSetContext(array $params = ['photo_id', 'context'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGeoSetLocation(array $params = ['photo_id', 'lat', 'lon', 'accuracy', 'context'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGeoSetPerms(array $params = ['is_public', 'is_contact', 'is_friend', 'is_family', 'photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetAllContexts(array $params = ['photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetContactsPhotos(array $params = ['count', 'just_friends', 'single_photo', 'include_self', 'extras'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetContactsPublicPhotos(array $params = ['user_id', 'count', 'just_friends', 'single_photo', 'include_self', 'extras'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetContext(array $params = ['photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetCounts(array $params = ['dates', 'taken_dates'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetExif(array $params = ['photo_id', 'secret'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetFavorites(array $params = ['photo_id', 'page', 'per_page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetInfo(array $params = ['photo_id', 'secret'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetNotInSet(array $params = ['max_upload_date', 'min_taken_date', 'max_taken_date', 'privacy_filter', 'media', 'min_upload_date', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetPerms(array $params = ['photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetPopular(array $params = ['user_id', 'sort', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetRecent(array $params = ['extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetSizes(array $params = ['photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetUntagged(array $params = ['min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date', 'privacy_filter', 'media', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetWithGeoData(array $params = ['min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date', 'privacy_filter', 'sort', 'media', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosGetWithoutGeoData(array $params = ['max_upload_date', 'min_taken_date', 'max_taken_date', 'privacy_filter', 'sort', 'media', 'min_upload_date', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosLicensesGetInfo()
 * @method \chillerlan\HTTP\HTTPResponseInterface photosLicensesSetLicense(array $params = ['photo_id', 'license_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosNotesAdd(array $params = ['photo_id', 'note_x', 'note_y', 'note_w', 'note_h', 'note_text'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosNotesDelete(array $params = ['note_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosNotesEdit(array $params = ['note_id', 'note_x', 'note_y', 'note_w', 'note_h', 'note_text'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosPeopleAdd(array $params = ['photo_id', 'user_id', 'person_x', 'person_y', 'person_w', 'person_h'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosPeopleDelete(array $params = ['photo_id', 'user_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosPeopleDeleteCoords(array $params = ['photo_id', 'user_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosPeopleEditCoords(array $params = ['photo_id', 'user_id', 'person_x', 'person_y', 'person_w', 'person_h'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosPeopleGetList(array $params = ['photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosRecentlyUpdated(array $params = ['min_date', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosRemoveTag(array $params = ['tag_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosSearch(array $params = ['user_id', 'tags', 'tag_mode', 'text', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date', 'license', 'sort', 'privacy_filter', 'bbox', 'accuracy', 'safe_search', 'content_type', 'machine_tags', 'machine_tag_mode', 'group_id', 'contacts', 'woe_id', 'place_id', 'media', 'has_geo', 'geo_context', 'lat', 'lon', 'radius', 'radius_units', 'is_commons', 'in_gallery', 'is_getty', 'extras', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosSetContentType(array $params = ['photo_id', 'content_type'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosSetDates(array $params = ['photo_id', 'date_posted', 'date_taken', 'date_taken_granularity'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosSetMeta(array $params = ['photo_id', 'title', 'description'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosSetPerms(array $params = ['photo_id', 'is_public', 'is_friend', 'is_family', 'perm_comment', 'perm_addmeta'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosSetSafetyLevel(array $params = ['photo_id', 'safety_level', 'hidden'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosSetTags(array $params = ['photo_id', 'tags'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosSuggestionsApproveSuggestion(array $params = ['suggestion_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosSuggestionsGetList(array $params = ['photo_id', 'status_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosSuggestionsRejectSuggestion(array $params = ['suggestion_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosSuggestionsRemoveSuggestion(array $params = ['suggestion_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosSuggestionsSuggestLocation(array $params = ['photo_id', 'lat', 'lon', 'accuracy', 'woe_id', 'place_id', 'note'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosTransformRotate(array $params = ['photo_id', 'degrees'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosUploadCheckTickets(array $params = ['tickets'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsAddPhoto(array $params = ['photoset_id', 'photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsCommentsAddComment(array $params = ['photoset_id', 'comment_text'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsCommentsDeleteComment(array $params = ['comment_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsCommentsEditComment(array $params = ['comment_id', 'comment_text'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsCommentsGetList(array $params = ['photoset_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsCreate(array $params = ['title', 'description', 'primary_photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsDelete(array $params = ['photoset_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsEditMeta(array $params = ['photoset_id', 'title', 'description'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsEditPhotos(array $params = ['photoset_id', 'primary_photo_id', 'photo_ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsGetContext(array $params = ['photo_id', 'photoset_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsGetInfo(array $params = ['photoset_id', 'user_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsGetList(array $params = ['user_id', 'page', 'per_page', 'primary_photo_extras'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsGetPhotos(array $params = ['photoset_id', 'user_id', 'extras', 'per_page', 'page', 'privacy_filter', 'media'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsOrderSets(array $params = ['photoset_ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsRemovePhoto(array $params = ['photoset_id', 'photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsRemovePhotos(array $params = ['photoset_id', 'photo_ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsReorderPhotos(array $params = ['photoset_id', 'photo_ids'])
 * @method \chillerlan\HTTP\HTTPResponseInterface photosetsSetPrimaryPhoto(array $params = ['photoset_id', 'photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface placesFind(array $params = ['query'])
 * @method \chillerlan\HTTP\HTTPResponseInterface placesFindByLatLon(array $params = ['lat', 'lon', 'accuracy'])
 * @method \chillerlan\HTTP\HTTPResponseInterface placesGetChildrenWithPhotosPublic(array $params = ['place_id', 'woe_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface placesGetInfo(array $params = ['place_id', 'woe_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface placesGetInfoByUrl(array $params = ['url'])
 * @method \chillerlan\HTTP\HTTPResponseInterface placesGetPlaceTypes()
 * @method \chillerlan\HTTP\HTTPResponseInterface placesGetShapeHistory(array $params = ['place_id', 'woe_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface placesGetTopPlacesList(array $params = ['place_type_id', 'date', 'woe_id', 'place_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface placesPlacesForBoundingBox(array $params = ['bbox', 'place_type', 'place_type_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface placesPlacesForContacts(array $params = ['place_type', 'place_type_id', 'woe_id', 'place_id', 'threshold', 'contacts', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date'])
 * @method \chillerlan\HTTP\HTTPResponseInterface placesPlacesForTags(array $params = ['place_type_id', 'woe_id', 'place_id', 'threshold', 'tags', 'tag_mode', 'machine_tags', 'machine_tag_mode', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date'])
 * @method \chillerlan\HTTP\HTTPResponseInterface placesPlacesForUser(array $params = ['place_type_id', 'place_type', 'woe_id', 'place_id', 'threshold', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date'])
 * @method \chillerlan\HTTP\HTTPResponseInterface placesResolvePlaceId(array $params = ['place_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface placesResolvePlaceURL(array $params = ['url'])
 * @method \chillerlan\HTTP\HTTPResponseInterface placesTagsForPlace(array $params = ['woe_id', 'place_id', 'min_upload_date', 'max_upload_date', 'min_taken_date', 'max_taken_date'])
 * @method \chillerlan\HTTP\HTTPResponseInterface prefsGetContentType()
 * @method \chillerlan\HTTP\HTTPResponseInterface prefsGetGeoPerms()
 * @method \chillerlan\HTTP\HTTPResponseInterface prefsGetHidden()
 * @method \chillerlan\HTTP\HTTPResponseInterface prefsGetPrivacy()
 * @method \chillerlan\HTTP\HTTPResponseInterface prefsGetSafetyLevel()
 * @method \chillerlan\HTTP\HTTPResponseInterface profileGetProfile(array $params = ['user_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface pushGetSubscriptions()
 * @method \chillerlan\HTTP\HTTPResponseInterface pushGetTopics()
 * @method \chillerlan\HTTP\HTTPResponseInterface pushSubscribe(array $params = ['topic', 'callback', 'verify', 'verify_token', 'lease_seconds', 'woe_ids', 'place_ids', 'lat', 'lon', 'radius', 'radius_units', 'accuracy', 'nsids', 'tags'])
 * @method \chillerlan\HTTP\HTTPResponseInterface pushUnsubscribe(array $params = ['topic', 'callback', 'verify', 'verify_token'])
 * @method \chillerlan\HTTP\HTTPResponseInterface reflectionGetMethodInfo(array $params = ['method_name'])
 * @method \chillerlan\HTTP\HTTPResponseInterface reflectionGetMethods()
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetCSVFiles()
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetCollectionDomains(array $params = ['date', 'collection_id', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetCollectionReferrers(array $params = ['date', 'domain', 'collection_id', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetCollectionStats(array $params = ['date', 'collection_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetPhotoDomains(array $params = ['date', 'photo_id', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetPhotoReferrers(array $params = ['date', 'domain', 'photo_id', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetPhotoStats(array $params = ['date', 'photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetPhotosetDomains(array $params = ['date', 'photoset_id', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetPhotosetReferrers(array $params = ['date', 'domain', 'photoset_id', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetPhotosetStats(array $params = ['date', 'photoset_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetPhotostreamDomains(array $params = ['date', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetPhotostreamReferrers(array $params = ['date', 'domain', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetPhotostreamStats(array $params = ['date'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetPopularPhotos(array $params = ['date', 'sort', 'per_page', 'page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface statsGetTotalViews(array $params = ['date'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tagsGetClusterPhotos(array $params = ['tag', 'cluster_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tagsGetClusters(array $params = ['tag'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tagsGetHotList(array $params = ['period', 'count'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tagsGetListPhoto(array $params = ['photo_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tagsGetListUser(array $params = ['user_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tagsGetListUserPopular(array $params = ['user_id', 'count'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tagsGetListUserRaw(array $params = ['tag'])
 * @method \chillerlan\HTTP\HTTPResponseInterface tagsGetMostFrequentlyUsed()
 * @method \chillerlan\HTTP\HTTPResponseInterface tagsGetRelated(array $params = ['tag'])
 * @method \chillerlan\HTTP\HTTPResponseInterface testEcho()
 * @method \chillerlan\HTTP\HTTPResponseInterface testLogin()
 * @method \chillerlan\HTTP\HTTPResponseInterface testNull()
 * @method \chillerlan\HTTP\HTTPResponseInterface testimonialsAddTestimonial(array $params = ['user_id', 'testimonial_text'])
 * @method \chillerlan\HTTP\HTTPResponseInterface testimonialsApproveTestimonial(array $params = ['testimonial_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface testimonialsDeleteTestimonial(array $params = ['testimonial_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface testimonialsEditTestimonial(array $params = ['user_id', 'testimonial_id', 'testimonial_text'])
 * @method \chillerlan\HTTP\HTTPResponseInterface testimonialsGetAllTestimonialsAbout(array $params = ['page', 'per_page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface testimonialsGetAllTestimonialsAboutBy(array $params = ['user_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface testimonialsGetAllTestimonialsBy(array $params = ['page', 'per_page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface testimonialsGetPendingTestimonialsAbout(array $params = ['page', 'per_page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface testimonialsGetPendingTestimonialsAboutBy(array $params = ['user_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface testimonialsGetPendingTestimonialsBy(array $params = ['page', 'per_page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface testimonialsGetTestimonialsAbout(array $params = ['user_id', 'page', 'per_page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface testimonialsGetTestimonialsAboutBy(array $params = ['user_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface testimonialsGetTestimonialsBy(array $params = ['user_id', 'page', 'per_page'])
 * @method \chillerlan\HTTP\HTTPResponseInterface urlsGetGroup(array $params = ['group_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface urlsGetUserPhotos(array $params = ['user_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface urlsGetUserProfile(array $params = ['user_id'])
 * @method \chillerlan\HTTP\HTTPResponseInterface urlsLookupGallery(array $params = ['url'])
 * @method \chillerlan\HTTP\HTTPResponseInterface urlsLookupGroup(array $params = ['url'])
 * @method \chillerlan\HTTP\HTTPResponseInterface urlsLookupUser(array $params = ['url'])
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
	 * @return \chillerlan\HTTP\HTTPResponseInterface
	 */
	public function request(string $path, array $params = null, string $method = null, $body = null, array $headers = null):HTTPResponseInterface{
		$method = $method ?? 'GET';

		$params = array_merge($params ?? [], [
			'method'         => $path,
			'format'         => 'json',
			'nojsoncallback' => true,
		]);

		$headers = $this->requestHeaders($this->apiURL, $params, $method, $headers, $this->storage->retrieveAccessToken($this->serviceName));

		return $this->httpRequest($this->apiURL, $params, $method, $body, $headers);
	}

}
