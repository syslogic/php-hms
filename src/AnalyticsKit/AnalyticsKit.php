<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace HMS\AnalyticsKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;
use InvalidArgumentException;
use stdClass;

/**
 * Class HMS AnalyticsKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-common-interface-description-0000001050707180">AnalyticsKit</a>
 * @author Martin Zeitler
 */
class AnalyticsKit extends Wrapper {

    private string|null $url_user_data_export;
    private string|null $url_user_data_export_status;
    private string|null $url_user_data_deletion;
    private string|null $url_user_data_deletion_status;
    private string|null $url_raw_data_export;
    private string|null $url_raw_data_export_status; // postback URL
    private string|null $url_data_collection_import_user;
    private string|null $url_data_collection_import_item;
    private string|null $url_data_collection_import_event;
    private string|null $url_report_metrics_list;
    private string|null $url_report_dimensions_list;

    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $base_url = Constants::ANALYTICS_KIT_BASE_URL;
        $this->url_user_data_export             = $base_url.Constants::ANALYTICS_KIT_GDPR_USER_DATA_EXPORT;
        $this->url_user_data_export_status      = $base_url.Constants::ANALYTICS_KIT_GDPR_USER_DATA_EXPORT_STATUS;
        $this->url_user_data_deletion           = $base_url.Constants::ANALYTICS_KIT_GDPR_USER_DATA_DELETION;
        $this->url_user_data_deletion_status    = $base_url.Constants::ANALYTICS_KIT_GDPR_USER_DATA_DELETION_STATUS;
        $this->url_raw_data_export              = $base_url.Constants::ANALYTICS_KIT_RAW_DATA_EXPORT;
        $this->url_raw_data_export_status       = $base_url.Constants::ANALYTICS_KIT_RAW_DATA_EXPORT_STATUS; // postback URL
        $this->url_data_collection_import_user  = $base_url.Constants::ANALYTICS_KIT_DATA_COLLECTION_IMPORT_USER;
        $this->url_data_collection_import_item  = $base_url.Constants::ANALYTICS_KIT_DATA_COLLECTION_IMPORT_ITEM;
        $this->url_data_collection_import_event = $base_url.Constants::ANALYTICS_KIT_DATA_COLLECTION_IMPORT_EVENT;
        $this->url_report_metrics_list          = $base_url.Constants::ANALYTICS_KIT_REPORT_METRICS_LIST;
        $this->url_report_dimensions_list       = $base_url.Constants::ANALYTICS_KIT_REPORT_DIMENSIONS_LIST;

        /* Obtain an access-token. */
        $account_kit = new AccountKit(['client_id' => $this->app_id, 'client_secret' => $this->app_secret]);
        $this->access_token = $account_kit->get_access_token();
    }

    /** Provide HTTP request headers as array. */
    protected function auth_header(): array {
        return [
            "Content-Type: application/json",
            "Authorization: Bearer $this->access_token",
            "x-product-id: $this->product_id",
            "x-app-id: $this->app_id"
        ];
    }

    /**
     * Exporting Personal Data.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-export-personal-data-0000001050987229">Exporting Personal Data</a>
     * @param string $aaid
     * @return stdClass
     */
    public function request_user_data_export( string|null $aaid ): stdClass {
        $payload = [];
        if ($aaid != null) {$payload = (object)['aaid' => $aaid];}
        return $this->curl_request('POST', $this->url_user_data_export, $this->auth_header(), $payload);
    }

    /**
     * Querying the Export Task Status.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-query-export-task-status-new-0000001135560119">Querying the Export Task Status</a>
     * @param string $aaid
     * @return stdClass
     */
    public function request_user_data_export_status( string $aaid ): stdClass {
        $payload = ['aaid' => $aaid];
        return $this->curl_request('POST', $this->url_user_data_export_status, $this->auth_header(), $payload);
    }

    /**
     * Deleting Personal Data.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-delete-personal-data-0000001050747213">Deleting Personal Data</a>
     * @param string $aaid
     * @return stdClass
     */
    public function request_user_data_deletion( string $aaid ): stdClass {
        $payload = ['aaid' => $aaid];
        return $this->curl_request('POST', $this->url_user_data_deletion, $this->auth_header(), $payload);
    }

    /**
     * Querying the Deletion Task Status.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-query-deletion-task-status-new-0000001088418298">Querying the Deletion Task Status</a>
     * @param string $aaid
     * @return stdClass
     */
    public function request_user_data_deletion_status( string $aaid ): stdClass {
        $payload = ['aaid' => $aaid];
        return $this->curl_request('POST', $this->url_user_data_deletion_status, $this->auth_header(), $payload);
    }

    /**
     * Creating a Data Export Task.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-create-data-export-task-0000001050987231#section195846692412">Creating a Data Export Task</a>
     * @param string $aaid
     * @return stdClass
     */
    public function request_raw_data_export( string $aaid ): stdClass {
        $payload = ['aaid' => $aaid];
        return $this->curl_request('POST', $this->url_user_data_export, $this->auth_header(), $payload);
    }

    /**
     * TODO: Receiving the Execution Status of a Data Export Task.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-create-data-export-task-0000001050987231#section195846692412">Receiving the Execution Status of a Data Export Task</a>
     * @return stdClass
     */
    public function receive_raw_data_export_status( ): stdClass {
        return new stdClass();
    }

    /**
     * Importing Custom User Attributes.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-import-customized-user-attributes-0000001050747215">Importing Custom User Attributes</a>
     * @param array $data
     * @return stdClass
     */
    public function data_collection_import_user( array $data ): stdClass|false {
        if (sizeof($data) < 1 || sizeof($data) > 100) {
            throw new InvalidArgumentException('the userdata_set must have 1-100 items');
        }
        $payload = ['data_type' => 1, 'userdata_set' => $data];
        return $this->curl_request('POST', $this->url_data_collection_import_user, $this->auth_header(), $payload);
    }

    /**
     * Importing Content.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-import-content-0000001205881011">Importing Content</a>
     * @param array $data
     * @return stdClass
     */
    public function data_collection_import_item( array $data ): stdClass {
        if (sizeof($data) < 1 || sizeof($data) > 100) {
            throw new InvalidArgumentException('the item_set must have 1-100 items');
        }
        $payload = ['data_type' => 2, 'item_set' => $data];
        return $this->curl_request('POST', $this->url_data_collection_import_item, $this->auth_header(), $payload);
    }

    /**
     * Reporting User Behavior.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-report-user-behavior-0000001205631635">Reporting User Behavior</a>
     * @param array $data
     * @return stdClass
     */
    public function data_collection_import_event( array $data ): stdClass {
        if (sizeof($data) < 1 || sizeof($data) > 100) {
            throw new InvalidArgumentException('the event_set must have 1-100 items');
        }
        $payload = [
            'data_type'        => 3,
            "protocol_version" => 1,
            "appid"            => $this->app_id,
            "productid"        => $this->product_id,
            'package_name'     => $this->package_name,
            'event_set'        => $data
        ];
        return $this->curl_request('POST', $this->url_data_collection_import_item, $this->auth_header(), $payload);
    }

    /**
     * Querying Open Metrics and Dimensions.
     *
     * @param string $lang
     * @param int $size
     * @param int $curr_page
     * @return stdClass
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/querying-open-indicators-and-dimensions-0000001152958663">Querying Open Metrics and Dimensions</a>
     */
    public function query_metrics_and_dimensions( string $lang='en', int $size=10, int $curr_page = 1 ): stdClass {
        if (! in_array($lang, ['en', 'cn', 'ru'])) {
            throw new InvalidArgumentException('lang must must be one of: en, cn, ru');
        }
        $payload = ['lang' => $lang, 'size' => $size, 'curr_page' => $curr_page];
        return $this->curl_request('POST', $this->url_data_collection_import_item, $this->auth_header(), $payload);
    }

    /**
     * Querying Dimension Values.
     *
     * @param string $metric
     * @param string $dimension
     * @param string $lang
     * @param int $size
     * @param int $from
     * @return stdClass
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/querying-dimension-values-0000001106240464">Querying Dimension Values</a>
     */
    public function query_dimensions( string $metric, string $dimension, string $lang='en', int $size=10, int $from=0 ): stdClass {
        if (! in_array($lang, ['en', 'cn', 'ru'])) {
            throw new InvalidArgumentException('lang must must be one of: en, cn, ru');
        }
        $payload = ['metric_name' => $metric, 'dim_name' => $dimension, 'lang' => $lang, 'size' => $size, 'from' => $from];
        return $this->curl_request('POST', $this->url_data_collection_import_item, $this->auth_header(), $payload);
    }

    /**
     * Querying Statistical Metrics.
     *
     * @param string $metric
     * @param array $dimensions
     * @param string|null $start_date
     * @param string|null $end_date
     * @param string|null $filters
     * @param string|null $order_by
     * @param string $lang
     * @param int $size
     * @param int $curr_page
     * @return stdClass
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/querying-tatistical-indicators-0000001152959491">Querying Statistical Metrics</a>
     */
    public function query_metrics( string $metric, array $dimensions, string|null $start_date, string|null $end_date, string|null $filters, string|null $order_by, string $lang='en', int $size=10, int $curr_page=1 ): stdClass {
        if (! in_array($lang, ['en', 'cn', 'ru'])) {
            throw new InvalidArgumentException('lang must must be one of: en, cn, ru');
        }
        $payload = [
            'metric'     => $metric,
            'dimensions' => $dimensions,
            'start_date' => $start_date,
            'end_date'   => $end_date,
            'filters'    => $filters,
            'order_by'   => $order_by,
            'lang'       => $lang,
            'size'       => $size,
            'curr_page'  => $curr_page
        ];
        return $this->curl_request('POST', $this->url_data_collection_import_item, $this->auth_header(), $payload);
    }
}
