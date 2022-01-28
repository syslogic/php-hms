<?php /** @noinspection PhpUnused */
namespace HMS\AgConnect\AuthService;

/**
 * Class HMS AppGallery Connect AuthService Constants
 *
 * @author Martin Zeitler
 */
class Constants {

    /**
     * POST: Importing Users.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892">Importing Users</a>
     */
    public const CONNECT_API_AUTH_SERVICE_USER_IMPORT = "api/auth-service/v1/server/user:import";

    /**
     * POST: Exporting Users.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892">Exporting Users</a>
     */
    public const CONNECT_API_AUTH_SERVICE_USER_EXPORT = "api/auth-service/v1/server/user:export";

    /**
     * GET: Authenticating a User's Access Token.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-verify-0000001182300271">Authenticating a User's Access Token</a>
     */
    public const CONNECT_API_AUTH_SERVICE_VERIFY_TOKEN = "api/oauth2/third/v1/verify-token?productId={productId}";

    /**
     * POST
     */
    public const CONNECT_API_AUTH_SERVICE_REVOKE_TOKEN = "api/oauth2/third/v1/revoke-token?productId={productId}";


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
}
