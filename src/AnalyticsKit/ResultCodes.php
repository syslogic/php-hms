<?php /** @noinspection PhpUnused */
namespace HMS\AnalyticsKit;

/**
 * Class HMS AnalyticsKit Result Codes
 * all HTTP 400.
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-export-personal-data-0000001050987229#section53004114522">Result Codes</a>
 * @author Martin Zeitler
 */
class ResultCodes {

    /**
     * 0 - Request successful.
     * Check and correct the parameter value.
     */
    public const REQUEST_SUCCESSFUL = 0;

    /**
     * 10020 - Invalid parameter.
     * Check and correct the parameter value.
     */
    public const INVALID_PARAMETER = 10020;

    /**
     * 10008 - Requests are too frequent.
     * Display a message prompting the user to reduce the frequency
     * of requesting data export and asking the user to try again later.
     */
    public const REQUESTS_TOO_FREQUENT = 10008;

    /**
     * 10030 - The data cannot be exported because it has been deleted at the request of the user.
     * Display a message indicating that the data has been deleted.
     */
    public const DATA_ALREADY_DELETED_BY_USER = 10030;

    /**
     * 110031 - The data cannot be exported because the interval between this data export request and the previous one is less than two months.
     * Display a message notifying the user that the interval between two consecutive data export requests must be two months at least.
     */
    public const DATA_EXPORT_REQUEST_INTERVAL = 10020;

    /**
     * 10032 - The data cannot be deleted because it is being exported.
     * Display a message indicating that the data is being exported and asking the user to try again after the data export is complete.
     */
    public const DATA_CURRENTLY_BEING_EXPORTED = 10032;

    /**
     * 10033 - The data has been deleted.
     * Display a message indicating that the data has been deleted.
     */
    public const DATA_HAS_BEEN_DELETED = 10033;

    /**
     * 10009 - The number of ongoing export tasks of an app reaches 3, which is the upper limit.
     * Try again after some or all of the ongoing tasks are complete.
     */
    public const TOO_MANY_ONGOING_EXPORT_TASKS = 10020;

    /**
     * 19910 - Authentication request timed out.
     * Internal error of the authentication server.
     * Try again later.
     */
    public const AUTHENTICATION_REQUEST_TIMED_OUT = 10020;
}
