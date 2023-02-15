<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery;

/**
 * Class HMS AppGallery Connect Constants
 *
 * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-notify-release-0000001158245063
 * @author Martin Zeitler
 */
class Constants {

    /** The Gateway URL may be overridden by the configuration in file `agconnect-services.json`. */
    public const CONNECT_API_BASE_URL = "https://connect-api.cloud.huawei.com"; // China
    public const CONNECT_API_BASE_URL_EU = "https://connect-api-dre.cloud.huawei.com"; // Germany
    public const CONNECT_API_BASE_URL_AS = "https://connect-api-dra.cloud.huawei.com"; // Singapore
    public const CONNECT_API_BASE_URL_RU = "https://connect-api-drru.cloud.huawei.com"; // Singapore

    /** Connect API has its own oAuth2 token endpoint. */
    public const CONNECT_API_OAUTH2_TOKEN_URL = "/api/oauth2/v1/token";

    /**
     * POST: Importing Users.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892">Importing Users</a>
     */
    public const CONNECT_API_AUTH_SERVICE_USER_IMPORT = "/api/auth-service/v1/server/user:import";

    /**
     * POST: Exporting Users.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892">Exporting Users</a>
     */
    public const CONNECT_API_AUTH_SERVICE_USER_EXPORT = "/api/auth-service/v1/server/user:export";

    /**
     * GET: Authenticating a User's Access Token.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-verify-0000001182300271">Authenticating a User's Access Token</a>
     */
    public const CONNECT_API_AUTH_SERVICE_VERIFY_TOKEN = "/api/oauth2/third/v1/verify-token?productId={projectId}";

    /**
     * POST Revoking a User's Access Token.
     */
    public const CONNECT_API_AUTH_SERVICE_REVOKE_TOKEN = "/api/oauth2/third/v1/revoke-token?productId={projectId}";


    public const AUTH_PROVIDER_ANONYMOUS          = 0;
    public const AUTH_PROVIDER_HUAWEI_ID          = 1;
    public const AUTH_PROVIDER_FACEBOOK           = 2; // * not available in China.
    public const AUTH_PROVIDER_TWITTER            = 3; // * not available in China.
    public const AUTH_PROVIDER_WECHAT             = 4;
    public const AUTH_PROVIDER_HUAWEI_GAME_CENTER = 5;
    public const AUTH_PROVIDER_QQ                 = 6;
    public const AUTH_PROVIDER_WEIBO              = 7;
    public const AUTH_PROVIDER_GOOGLE             = 8; // * not available in China.
    public const AUTH_PROVIDER_GOOGLE_PLAY_GAMES  = 9; // * not available in China.
    public const AUTH_PROVIDER_SELF_OWNED_ACCOUNT = 10;
    public const AUTH_PROVIDER_MOBILE_NUMBER      = 11;
    public const AUTH_PROVIDER_EMAIL_ADDRESS      = 12;
    public const AUTH_PROVIDER_APPLE_ID           = 13;

    public const REPORT_API_BASE_URL = "https://www.huawei.com/auth/agc/report/read";
    public const PROJECT_API_BASE_URL = "https://www.huawei.com/auth/agc/project";
    public const PRODUCT_API_BASE_URL      = "https://www.huawei.com/auth/agc/product";
    public const PRODUCT_API_BASE_URL_READ = "https://www.huawei.com/auth/agc/product/read";

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
