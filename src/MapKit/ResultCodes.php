<?php /** @noinspection PhpUnused */
namespace HMS\MapKit;

/**
 * Class HMS MapKit Result Codes
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/error-code-0000001050161430">Result Codes</a>
 * @author Martin Zeitler
 */
class ResultCodes {

    /** 200 / 0 - The request was successful. */
    public const OK = 0;

    /** 501 / 3 - The method was not found on the server. */
    public const UNKNOWN_ERROR = 3;

    /** 404 / 5 - The request URL was invalid. */
    public const NOT_FOUND = 5;

    /** 401 / 6 - Invalid or expired token. */
    public const REQUEST_DENIED_TOKEN = 6;

    /** 406 / 7 - Invalid content type. */
    public const INVALID_REQUEST_CONTENT_TYPE = 7;

    /** 406 / 8 - Invalid accept type. */
    public const INVALID_REQUEST_ACCEPT_TYPE = 8;

    /** 400 / 105 - Parameter error. */
    public const INVALID_REQUEST_PARAMETER = 105;

    /** 503 / 110 - Internal server error. */
    public const UNKNOWN_ERROR_INTERNAL = 110;

    /** 503 / 111 - The request was discarded because the service is busy. */
    public const UNKNOWN_ERROR_BUSY = 111;

    /** 503 / 114 - No service was found for the request. */
    public const UNKNOWN_ERROR_SERVICE = 114;

    /** 405 / 403 - The app ID does not have the service call permission. */
    public const REQUEST_DENIED_PERMISSION = 403;

    /** 401 / 010001 - The authentication service is abnormal. */
    public const UNKNOWN_ERROR_AUTH_SERVICE = '010001';

    /** 401 / 010002 - Incorrect certificate fingerprint. */
    public const REQUEST_DENIED_FINGERPRINT = '010002';

    /** 401 / 010003 - Unauthorized API call. */
    public const REQUEST_DENIED_UNAUTHORIZED_CALL = '010003';

    /** 200 / 010004 - The search is successful but no record is found. */
    public const ZERO_RESULTS = '010004';

    /** 403 / 010006 - Paid API calls reach the limit. */
    public const OVER_QUERY_LIMIT_PAID_API_LIMIT = '010006';

    /** 400 / 010007 - Place search failure. */
    public const INVALID_REQUEST = '010007';

    /** 400 / 0010008 - Route data does not exist. */
    public const INVALID_REQUEST_NO_ROUTE_DATA = '010008';

    /** 400 / 010009 - Cross-region route planning is not supported. */
    public const INVALID_REQUEST_CROSS_REGION_ROUTE = '010009';

    /** 400 / 010010 - Invalid parameter. */
    public const INVALID_REQUEST_PARAMETER_2 = '010010';

    /** 500 / 010012 - Internal server error. */
    public const UNKNOWN_ERROR_INTERNAL_SERVER_ERROR = '010012';

    /** 401 / 010017 - Invalid request signature. */
    public const INVALID_REQUEST_SIGNATURE = '010017';

    /** 503 / 010018 - The service is degraded because the server is busy. */
    public const REQUEST_DENIED_BUSY = '010018';

    /** 400 / 010019 - Departure places or destinations exceed 25. */
    public const REQUEST_DENIED_LOCATION_COUNT = '010019';

    /** 400 / 010020 - The linear distance between the departure place and destination exceeds the upper limit. */
    public const REQUEST_DENIED_LINEAR_DISTANCE = '010020';

    /** 403 / 010024 - The API is in arrears. */
    public const OVER_QUERY_LIMIT_ARREARS = '010024';

    /** 400 / 010025 - The departure place, destination, or waypoint does not support navigation. */
    public const INVALID_REQUEST_NAVIGATION_NOT_SUPPORTED = '010025';

    /** 403 / 010027 - You have not subscribed to any pay-as-you-go plan. */
    public const OVER_QUERY_LIMIT_NOT_SUBSCRIBED = '010027';

    /** 403 / 010037 - The QPS exceeds the quota. */
    public const OVER_QUERY_LIMIT_PER_SECOND = '010037';

    /** 400 / 010038 - The number of longitude-latitude pairs exceeds 512. */
    public const BAD_REQUEST_ELEVATION_WAYPOINTS = '010038';
}
