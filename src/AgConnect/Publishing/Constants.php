<?php /** @noinspection PhpUnused */
namespace HMS\AgConnect\Publishing;

/**
 * Class HMS AppGallery Connect Constants
 *
 * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-notify-release-0000001158245063
 * @author Martin Zeitler
 */
class Constants {

    /**
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-obtain_token-0000001158365043
     */
    public const PUBLISH_API_BASE_URL = "https://connect-api.cloud.huawei.com/api/publish/v2/";

    /**
     * @param int appId App ID.
     * @param string suffix File name extension, such as apk, rpk, pdf, jpg, jpeg, png, bmp, mp4, mov, and aab.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-upload-url-0000001158365047
     */
    public const PUBLISH_API_FILE_UPLOAD_URL = "upload-url?appId={appId}&suffix={suffix}";

    /**
     * Querying the App ID Corresponding to an App Package Name.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-appid-list-0000001111845086
     */
    public const PUBLISH_API_APP_ID_LIST = "appid-list";

    /**
     * GET: Querying App Information.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-info-query-0000001158365045
     *
     * PUT: Updating App Basic Information.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-info-update-0000001111685198
     */
    public const PUBLISH_API_APP_INFO = "app-info";

    /**
     * PUT: Updating App Localization Information.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-language-info-update-0000001158245057
     *
     * DELETE: Deleting App Localization Information.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-language-info-delete-0000001111845088
     */
    public const PUBLISH_API_APP_LANGUAGE_INFO = "app-language-info";

    /**
     * POST: Uploading a File.
     * Request: Content-Type: multipart/form-data
     * Response: Content-Type: application/json
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-upload-file-0000001158245059
     */

    /**
     * POST: Uploading Files by Chunk.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-upload-fragment-file-0000001158365049
     */

    /**
     * PUT: Updating App File Information
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-file-info-0000001111685202
     */
    public const PUBLISH_API_APP_FILE_INFO = "app-file-info";

    /**
     * POST: Submitting an App for Release.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-submit-0000001158245061
     */
    public const PUBLISH_API_APP_SUBMIT = "app-submit";

    /**
     * POST: Submitting an App for Release in Download Mode.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-submit-with-file-0000001111845092
     */
    public const PUBLISH_API_APP_SUBMIT_WITH_FILE = "app-submit-with-file";

    /**
     * PUT: Changing Phased Release Status.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-phased-release-state-0000001158365051
     */
    public const PUBLISH_API_PHASED_RELEASE_STATE = "phased-release/state";

    /**
     * PUT: Updating Phased Release.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-phased-release-0000001111685204
     */
    public const PUBLISH_API_PHASED_RELEASE = "phased-release";

    /**
     * PUT: Setting the GMS Dependency Flag for an App.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-gms-0000001111845094
     */
    public const PUBLISH_API_GMS_DEPENDENCY_FLAG = "properties/gms";

    /**
     * PUT: Updating the Release Time of a Version.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-update-releasetime-0000001158365053
     */
    public const PUBLISH_API_UPDATE_RELEASE_TIME = "on-shelf-time";

    /**
     * GET: Querying the Compilation Status of an App Package
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-query-aabfile-0000001111685206
     */
    public const PUBLISH_API_QUERY_COMPILATION_STATUS = "aab/compile/status";
}
