<?php /** @noinspection PhpUnused */
namespace HMS\AccountKit;

/**
 * Class HMS AccountKit Constants
 *
 * @author Martin Zeitler
 */
class Constants {
    public const URL_OAUTH2_TOKEN       = "https://oauth-login.cloud.huawei.com/oauth2/v3/token";
    public const URL_OAUTH2_TOKEN_INFO  = "https://oauth-login.cloud.huawei.com/oauth2/v3/tokeninfo";
    public const URL_OAUTH2_TOKEN_REVOCATION = "https://oauth-login.cloud.huawei.com/oauth2/v3/revoke";
    public const URL_ACCOUNT_KIT_TOKEN_INFO = "https://oauth-api.cloud.huawei.com/rest.php?nsp_fmt=JSON&nsp_svc=huawei.oauth2.user.getTokenInfo";
    public const URL_ACCOUNT_KIT_USER_INFO  = "https://account.cloud.huawei.com/rest.php?nsp_svc=GOpen.User.getInfo";
}
