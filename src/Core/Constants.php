<?php
namespace HMS\Core;

/**
 * Class HMS Core Constants
 *
 * @author Martin Zeitler
 */
class Constants {

    /** @const URL_OAUTH2_TOKEN_REFRESH_V2 - The legacy v2 endpoint is being used by PushKit. */
    public const URL_OAUTH2_TOKEN_REFRESH_V2 = "https://oauth-login.cloud.huawei.com/oauth2/v2/token";

    /** @const URL_OAUTH2_TOKEN_REFRESH - The v3 endpoint is being used by AccountKit. */
    public const URL_OAUTH2_TOKEN_REFRESH   = "https://oauth-login.cloud.huawei.com/oauth2/v3/token";
}
