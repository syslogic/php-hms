<?php /** @noinspection PhpUnused */
namespace HMS\LocationKit;

/**
 * Class HMS LocationKit Result Codes
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/web-error-code-0000001052202593 Result Codes
 * @author Martin Zeitler
 */
class ResultCodes {

    /** 0 - Request successful. */
    public const OK = 0;

    /** 100000 - Parameter error. */
    public const PARAMETER_ERROR = 100000;

    /** 100001 - The API key has expired or failed to be parsed. */
    public const API_KEY_EXPIRED_OR_INVALID = 100001;

    /** 100002 - Authentication failed. */
    public const AUTHENTICATION_FAILED = 100002;

    /** 100003 - Internal service error. */
    public const INTERNAL_SERVICE_ERROR = 100003;

    /** 500000 - The pay-as-you-go plan subscription status is incorrect. */
    public const SUBSCRIPTION_STATUS_ERROR = 500000;

    /** 500001 - This service is unavailable for you. */
    public const SERVICE_UNAVAILABLE_TO_YOU = 500001;

    /** 500032 - The number of parameters is invalid; < 10.000. */
    public const PARAMETER_COUNT_THRESHOLD = 500032;

    /** 701200001 - Mandatory parameters are missing. */
    public const MANDATORY_PARAMETERS_MISSING = 701200001;

    /** 701200002 - Incorrect parameter format. */
    public const INCORRECT_PARAMETER_FORMAT = 701200002;

    /** 701200003 - No valid fingerprint information is available. */
    public const NO_FINGERPRINT_INFORMATION_AVAILABLE = 701200003;

    /** 701200004 - Invalid cell information. */
    public const INVALID_CELL_INFORMATION = 701200004;

    /** 701200005 - The number of Wi-Fi data records exceeds the maximum. */
    public const WIFI_DATA_RECORDS_THRESHOLD = 701200005;

    /** 701200006 - The number of cell data records exceeds the maximum. */
    public const CELL_DATA_RECORDS_THRESHOLD = 701200006;

    /** 701200007 - The number of neighboring cell data records exceeds the maximum. */
    public const NEIGHBORING_CELL_DATA_RECORDS_THRESHOLD = 701200007;

    /** 701600001 - The number of indoor MAC addresses does not reach the minimum for triggering indoor location. */
    public const INSUFFICIENT_INDOOR_MAC_FOR_LOCATION = 701600001;

    /** 701600002 - The number of MAC addresses exceeds the maximum. */
    public const INDOOR_MAC_ADDRESSES_THRESHOLD = 701600002;

    /** 702100001 - Mandatory parameters are missing for IP address location. */
    public const MANDATORY_PARAMETERS_MISSING_IP_LOCATION = 702100001;

    /** 701600002 - Invalid parameter format for IP address location. */
    public const INVALID_PARAMETER_FORMAT_IP_LOCATION = 701600002;

    /** 702200001 - The IP address location result is empty. */
    public const EMPTY_RESULT_IP_LOCATION = 702200001;
}
