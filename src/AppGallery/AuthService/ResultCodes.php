<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery\AuthService;

/**
 * Class HMS AppGallery Connect AuthService Result Codes
 *
 * @link https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-errorcode-0000001142701050 Result Codes
 * @author Martin Zeitler
 */
class ResultCodes {

    /** 0 - Success. */
    public const SUCCESS = 0;

    /** 205524993 - Failed to authenticate the client token. */
    public const AUTHENTICATION_FAILED_CLIENT_TOKEN = 205524993;

    /** 205524994 - Failed to authenticate the access token. */
    public const AUTHENTICATION_FAILED_ACCESS_TOKEN = 205524994;

    /** 203816961 - Internal system error. */
    public const INTERNAL_SYSTEM_ERROR = 203816961;
}
