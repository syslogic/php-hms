<?php /** @noinspection PhpUnused */
namespace HMS\AccountKit;

/**
 * Class HMS AccountKit Error Codes
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-error-codes-0000001062371380">Error Codes</a>
 * @author Martin Zeitler
 */
class ResultCodes {

    /** 1101 / 20002 - The value of `client_id` is in an incorrect format. */
    public const CLIENT_ID_HAS_INVALID_FORMAT     = 20002;

    /** 1101 / 20022 - The value of `redirect_uri` is in an incorrect format. */
    public const REDIRECT_URI_HAS_INVALID_FORMAT  = 20022;

    /** 1101 / 20023 - The value of `redirect_uri` in `code` does not match the redirection URL set in AppGallery Connect. */
    public const REDIRECT_URI_DOES_NOT_MATCH_CODE = 20023;

    /** 1101 / 20086 - Invalid need_code parameter. */
    public const INVALID_NEED_CODE_PARAMETER      = 20086;


    // TODO ...
}
