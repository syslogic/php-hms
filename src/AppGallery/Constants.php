<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery;

/**
 * Class HMS AppGallery Connect Constants
 *
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

    /** @link https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892 Importing Users */
    public const CONNECT_API_AUTH_SERVICE_USER_IMPORT = "/api/auth-service/v1/server/user:import";

    /** @link https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892 Exporting Users */
    public const CONNECT_API_AUTH_SERVICE_USER_EXPORT = "/api/auth-service/v1/server/user:export";

    /** @link https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-verify-0000001182300271 Authenticating a User's Access Token */
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

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-obtain_token-0000001158365043  */
    public const PUBLISH_API_BASE_URL = "https://connect-api.cloud.huawei.com/";

    /**
     * @param int appId App ID.
     * @param string suffix File name extension, such as apk, rpk, pdf, jpg, jpeg, png, bmp, mp4, mov, and aab.
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-upload-url-0000001158365047
     */
    public const PUBLISH_API_FILE_UPLOAD_URL = "api/publish/v2/upload-url";

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-appid-list-0000001111845086 Querying the App ID Corresponding to an App Package Name */
    public const PUBLISH_API_APP_ID_LIST = "api/publish/v2/appid-list";

    /**
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-info-query-0000001158365045 Querying App Information
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-info-update-0000001111685198 Updating App Basic Information
     */
    public const PUBLISH_API_APP_INFO = "api/publish/v2/app-info";

    /**
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-language-info-update-0000001158245057 Updating App Localization Information
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-language-info-delete-0000001111845088 Deleting App Localization Information
     */
    public const PUBLISH_API_APP_LANGUAGE_INFO = "api/publish/v2/app-language-info";

    /**
     * Request: Content-Type: multipart/form-data
     * Response: Content-Type: application/json
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-upload-file-0000001158245059 Uploading a File
     */

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-upload-fragment-file-0000001158365049 Uploading Files by Chunk */

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-file-info-0000001111685202 Updating App File Information */
    public const PUBLISH_API_APP_FILE_INFO = "api/publish/v2/app-file-info";

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-submit-0000001158245061 Submitting an App for Release */
    public const PUBLISH_API_APP_SUBMIT = "api/publish/v2/app-submit";

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-submit-with-file-0000001111845092 Submitting an App for Release in Download Mode */
    public const PUBLISH_API_APP_SUBMIT_WITH_FILE = "api/publish/v2/app-submit-with-file";

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-phased-release-state-0000001158365051 Changing Phased Release Status */
    public const PUBLISH_API_PHASED_RELEASE_STATE = "api/publish/v2/phased-release/state";

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-phased-release-0000001111685204 Updating Phased Release */
    public const PUBLISH_API_PHASED_RELEASE = "api/publish/v2/phased-release";

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-gms-0000001111845094 Setting the GMS Dependency Flag for an App */
    public const PUBLISH_API_GMS_DEPENDENCY_FLAG = "api/publish/v2/properties/gms";

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-update-releasetime-0000001158365053 Updating the Release Time of a Version */
    public const PUBLISH_API_UPDATE_RELEASE_TIME = "api/publish/v2/on-shelf-time";

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-query-aabfile-0000001111685206 Querying the Compilation Status of an App Package */
    public const PUBLISH_API_QUERY_COMPILATION_STATUS = "api/publish/v2/aab/compile/status";

    public const PUBLISH_API_CERTIFICATES = "https://developer.huawei.com/consumer/en/service/josp/agc/index.html#/myApp/{appId}/9249519184596012000";
}
