<?php /** @noinspection PhpUnused */
namespace HMS\PushKit;

/**
 * Class HMS PushKit Constants
 *
 * @see https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/https-send-api-0000001050986197
 * @author Martin Zeitler
 */
class ResultCodes {

    /** 80000000 - Success. */
    public const SUBMISSION_SUCCESS                 = 80000000;

    /**
     * 80100000 - The message is successfully sent to some tokens.
     * Tokens identified by illegal_tokens are those to which the message failed to be sent.
     */
    public const SUBMISSION_PARTIAL_SUCCESS         = 80100000;

    /** 80100001 - The number of tokens must be 1 when a message is sent in synchronous mode. */
    public const SYNCHRONOUS_MODE_TOKEN_THRESHOLD   = 80100001;

    /** 80100003 - Incorrect message structure. */
    public const INCORRECT_MESSAGE_STRUCTURE        = 80100003;

    /** 80100004 - The message expiration time is earlier than the current time. */
    public const PARAM_TTL_EXPIRED_ALREADY          = 80100004;

    /** 80100013 The <code>collapse_key</code> message field is invalid. */
    public const PARAM_COLLAPSE_KEY_INVALID         = 80100013;

    /** 80100017 - A maximum of 100 topic-based messages can be sent at the same time. */
    public const TOPIC_BASED_MESSAGES_THRESHOLD     = 80100017;

    /** 80200001 - OAuth2 authentication error. */
    public const OAUTH_AUTHENTICATION_ERROR         = 80200001;

    /** 80200003 - OAuth2 token expired. */
    public const OAUTH_TOKEN_EXPIRED                = 80200003;

    /** 80300002 - The current app does not have the permission to send messages. */
    public const PUSHKIT_NO_PERMISSION              = 80300002;

    /** 80300007 - All tokens are invalid. */
    public const SUBMISSION_ALL_TOKENS_INVALID      = 80300007;

    /** 80300010 - The number of tokens in the message body exceeds the default value (1000). */
    public const TOKENS_PER_MESSAGE_THRESHOLD       = 80300010;

    /** 80300013 - Invalid receipt URL. */
    public const INVALID_RECEIPT_URL_OR_CERTIFICATE = 80300013;

    /** 80600003 - Failed to request the OAuth service. */
    public const OAUTH_CREDENTIALS_ERROR            = 80600003;

    /** 81000001 - An internal error of the system occurs. */
    public const INTERNAL_SYSTEM_ERROR              = 81000001;
}
