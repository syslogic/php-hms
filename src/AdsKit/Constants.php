<?php /** @noinspection PhpUnused */
namespace HMS\AdsKit;

/**
 * Class HMS AdsKit Constants
 *
 * @author Martin Zeitler
 */
class Constants {
    public const ADS_KIT_BASE_URL = "https://ads.cloud.huawei.com/openapi/monetization/reports/v1/publisher";

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/query-publisher-service-reports-0000001050933546#section185541446104014 Time Granularity */
    public const ADS_KIT_GRANULARITY = [
        'STAT_TIME_GRANULARITY_DAILY',
        'STAT_TIME_GRANULARITY_MONTHLY',
        'STAT_TIME_GRANULARITY_SUMMARY'
    ];

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/query-publisher-service-reports-0000001050933546#section558495224016 Ad Formats */
    public const ADS_KIT_FORMATS = [
        'AD_TYPE_SPLASH',
        'AD_TYPE_BANNER',
        'AD_TYPE_NATIVE',
        'AD_TYPE_ROLL',
        'AD_TYPE_REWARDVIDEO',
        'AD_TYPE_MAGAZINELOCK',
        'AD_TYPE_INTERSTITIAL',
        'AD_TYPE_APPICON'
    ];

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/query-publisher-service-reports-0000001050933546#section1577191034116 Grouping Conditions */
    public const ADS_KIT_GROUPING = [
        'STAT_BREAK_DOWNS_COUNTRY',
        'STAT_BREAK_DOWNS_APP_ID',
        'STAT_BREAK_DOWNS_PLACEMENT_ID',
        'STAT_BREAK_DOWNS_AD_TYPE'
    ];
    public const ADS_KIT_ORDER_FIELDS = [
        'stat_datetime',
        'earnings',
        'reached_ad_requests',
        'matched_reached_ad_requests',
        'show_count',
        'click_count',
        'ad_requests_match_rate',
        'ad_requests_show_rate',
        'click_through_rate'
    ];

    public const ADS_KIT_ORDER_TYPES = [
        'DESC',
        'ASC'
    ];
}
