<?php /** @noinspection PhpUnused */
namespace HMS\AnalyticsKit;

/**
 * Class HMS AnalyticsKit Constants
 *
 * @author Martin Zeitler
 */
class Constants {

    /**
     *
     * - Sign in to AppGallery Connect and click My projects.
     * - Find your project, and click the app for which you want to view analysis data.
     * - Go to HUAWEI Analytics > Management > Analysis settings > API management.
     * - You can then obtain <rootUrl> of the related APIs from API access address.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-common-interface-description-0000001050707180#section777183816123">API Access Address</a>
     */
    public const ANALYTICS_KIT_BASE_URL                       = "https://datacollector-drcn-dt-hicloud.com/";

    public const ANALYTICS_KIT_GDPR_USER_DATA_EXPORT          = "analytics/gdpr/user_data_export_requests/v2";
    public const ANALYTICS_KIT_GDPR_USER_DATA_EXPORT_STATUS   = "analytics/gdpr/user_data_export_tasks/v2";

    public const ANALYTICS_KIT_GDPR_USER_DATA_DELETION        = "analytics/gdpr/user_deletion_requests/v2";
    public const ANALYTICS_KIT_GDPR_USER_DATA_DELETION_STATUS = "analytics/gdpr/user_deletion_tasks/v2";

    public const ANALYTICS_KIT_RAW_DATA_EXPORT                = "analytics/export/raw_data_requests/v2";
    public const ANALYTICS_KIT_RAW_DATA_EXPORT_STATUS         = ""; // this is a postback URL

    public const ANALYTICS_KIT_DATA_COLLECTION_IMPORT_USER    = "analytics/datacollection/import/user";
    public const ANALYTICS_KIT_DATA_COLLECTION_IMPORT_ITEM    = "analytics/datacollection/import/item";
    public const ANALYTICS_KIT_DATA_COLLECTION_IMPORT_EVENT   = "analytics/datacollection/import/event";

    public const ANALYTICS_KIT_REPORT_METRICS_LIST            = "analytics/report/metrics/list/v1";
    public const ANALYTICS_KIT_REPORT_DIMENSIONS_LIST         = "analytics/report/dimension/list/v1";

}
