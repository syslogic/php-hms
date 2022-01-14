<?php
namespace HMS\Core;

/**
 * Class HMS Core Constants
 *
 * @author Martin Zeitler
 */
class Constants {

    /** @const URL_OAUTH2_TOKEN_REFRESH_V1 - The legacy v1 endpoint is being used by GameService (AppGalleryKit). */
    public const URL_OAUTH2_TOKEN_REFRESH_V1 = "https://connect-api.cloud.huawei.com/api/oauth2/v1/token";

    /** @const URL_OAUTH2_TOKEN_REFRESH_V2 - The legacy v2 endpoint is being used by PushKit. */
    public const URL_OAUTH2_TOKEN_REFRESH_V2 = "https://oauth-login.cloud.huawei.com/oauth2/v2/token";

    /** @const URL_OAUTH2_TOKEN_REFRESH - The v3 endpoint is being used by AccountKit (default value). */
    public const URL_OAUTH2_TOKEN_REFRESH_V3 = "https://oauth-login.cloud.huawei.com/oauth2/v3/token";
    public const URL_OAUTH2_TOKEN_REFRESH    = self::URL_OAUTH2_TOKEN_REFRESH_V3;
}
