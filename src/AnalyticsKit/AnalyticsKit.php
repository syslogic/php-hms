<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace HMS\AnalyticsKit;

use HMS\Core\Wrapper;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class HMS AnalyticsKit Wrapper
 *
 * @@link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-common-interface-description-0000001050707180 AnalyticsKit
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

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->withBaseUrl(Constants::ANALYTICS_KIT_BASE_URL);
        if (isset($config['access_token'])) {
            $this->access_token = $config['access_token'];
        } else {
            throw new \InvalidArgumentException('DriveKit requires an user access token.');
        }
        $this->post_init();
        return $this;
    }

    public function withBaseUrl( string $base_url ): Wrapper {
        $this->base_url = $base_url;
        $this->url_user_data_export             = $this->base_url.Constants::ANALYTICS_KIT_GDPR_USER_DATA_EXPORT;
        $this->url_user_data_export_status      = $this->base_url.Constants::ANALYTICS_KIT_GDPR_USER_DATA_EXPORT_STATUS;
        $this->url_user_data_deletion           = $this->base_url.Constants::ANALYTICS_KIT_GDPR_USER_DATA_DELETION;
        $this->url_user_data_deletion_status    = $this->base_url.Constants::ANALYTICS_KIT_GDPR_USER_DATA_DELETION_STATUS;
        $this->url_raw_data_export              = $this->base_url.Constants::ANALYTICS_KIT_RAW_DATA_EXPORT;
        $this->url_raw_data_export_status       = $this->base_url.Constants::ANALYTICS_KIT_RAW_DATA_EXPORT_STATUS; // postback URL
        $this->url_data_collection_import_user  = $this->base_url.Constants::ANALYTICS_KIT_DATA_COLLECTION_IMPORT_USER;
        $this->url_data_collection_import_item  = $this->base_url.Constants::ANALYTICS_KIT_DATA_COLLECTION_IMPORT_ITEM;
        $this->url_data_collection_import_event = $this->base_url.Constants::ANALYTICS_KIT_DATA_COLLECTION_IMPORT_EVENT;
        $this->url_report_metrics_list          = $this->base_url.Constants::ANALYTICS_KIT_REPORT_METRICS_LIST;
        $this->url_report_dimensions_list       = $this->base_url.Constants::ANALYTICS_KIT_REPORT_DIMENSIONS_LIST;
        return $this;
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->oauth2_client_secret, $this->oauth2_api_scope, $this->oauth2_api_scope, $this->oauth2_redirect_url);
        unset($this->agcc_project_client_id, $this->agcc_project_client_secret);
        unset($this->api_key, $this->api_signature);
        unset($this->developer_id);
    }

    /** Provide HTTP request headers as array. */
    #[ArrayShape(['Content-Type' => 'string', 'Authorization' => 'string', 'x-app-id' => 'int', 'x-product-id' => 'int'])]
    protected function auth_headers(): array {
        return [
            "Content-Type" => "application/json; charset=utf-8",
            "Authorization" => "Bearer $this->access_token",
            "x-app-id" => $this->oauth2_client_id,
            "x-product-id" => $this->project_id
        ];
    }

    /**
     * Exporting Personal Data.
     *
     * @@link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-export-personal-data-0000001050987229 Exporting Personal Data
     * @param string|null $aaid Anonymous user ID, which can be obtained using the API on the device side.
     * @return \stdClass
     */
    public function request_user_data_export( ?string $aaid=null ): \stdClass {
        $payload = [];
        if ($aaid != null) {$payload = ['aaid' => $aaid];}
        return $this->request('POST', $this->url_user_data_export, $this->auth_headers(), $payload);
    }

    /**
     * Querying the Export Task Status.
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-query-export-task-status-new-0000001135560119 Querying the Export Task Status
     * @param string|null $aaid Anonymous user ID, which can be obtained using the API on the device side.
     * @return \stdClass
     */
    public function request_user_data_export_status( ?string $aaid=null ): \stdClass {
        $payload = [];
        if ($aaid != null) {$payload = ['aaid' => $aaid];}
        return $this->request('POST', $this->url_user_data_export_status, $this->auth_headers(), $payload);
    }

    /**
     * Deleting Personal Data.
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-delete-personal-data-0000001050747213 Deleting Personal Data
     * @param string|null $aaid Anonymous user ID, which can be obtained using the API on the device side.
     * @return \stdClass
     */
    public function request_user_data_deletion( ?string $aaid=null ): \stdClass {
        $payload = [];
        if ($aaid != null) {$payload = ['aaid' => $aaid];}
        return $this->request('POST', $this->url_user_data_deletion, $this->auth_headers(), $payload);
    }

    /**
     * Querying the Deletion Task Status.
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-query-deletion-task-status-new-0000001088418298 Querying the Deletion Task Status
     * @param string|null $aaid Anonymous user ID, which can be obtained using the API on the device side.
     * @return \stdClass
     */
    public function request_user_data_deletion_status( ?string $aaid ): \stdClass {
        $payload = [];
        if ($aaid != null) {$payload = ['aaid' => $aaid];}
        return $this->request('POST', $this->url_user_data_deletion_status, $this->auth_headers(), $payload);
    }

    /**
     * Creating a Data Export Task.
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-create-data-export-task-0000001050987231#section195846692412 Creating a Data Export Task
     * @param string|null $aaid Anonymous user ID, which can be obtained using the API on the device side.
     * @return \stdClass
     */
    public function request_raw_data_export( ?string $aaid ): \stdClass {
        $payload = [];
        if ($aaid != null) {$payload = ['aaid' => $aaid];}
        return $this->request('POST', $this->url_user_data_export, $this->auth_headers(), $payload);
    }

    /**
     * Receiving the Execution Status of a Data Export Task ??
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-create-data-export-task-0000001050987231#section195846692412 Receiving the Execution Status of a Data Export Task
     * @return \stdClass
     */
    public function receive_raw_data_export_status( ): \stdClass {
        return $this->request('POST', $this->url_user_data_export_status, $this->auth_headers(), []);
    }

    /**
     * Importing Custom User Attributes.
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-import-customized-user-attributes-0000001050747215 Importing Custom User Attributes
     * @param array $data
     * @return \stdClass|false
     */
    public function data_collection_import_user( array $data ): \stdClass|false {
        if (sizeof($data) < 1 || sizeof($data) > 100) {
            throw new \InvalidArgumentException('the userdata_set must have 1-100 items');
        }
        return $this->request('POST', $this->url_data_collection_import_user, $this->auth_headers(), [
            'data_type' => 1,
            'userdata_set' => $data
        ] );
    }

    /**
     * Importing Content.
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-import-content-0000001205881011 Importing Content
     * @param array $data
     * @return \stdClass
     */
    public function data_collection_import_item( array $data ): \stdClass {
        if (sizeof($data) < 1 || sizeof($data) > 100) {
            throw new \InvalidArgumentException('the item_set must have 1-100 items');
        }
        return $this->request('POST', $this->url_data_collection_import_item, $this->auth_headers(), [
            'data_type' => 2,
            'item_set' => $data
        ] );
    }

    /**
     * Reporting User Behavior.
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/android-api-report-user-behavior-0000001205631635 Reporting User Behavior
     * @param array $data
     * @return \stdClass
     */
    public function data_collection_import_event( array $data ): \stdClass {
        if (sizeof($data) < 1 || sizeof($data) > 100) {
            throw new \InvalidArgumentException('the event_set must have 1-100 items');
        }
        return $this->request('POST', $this->url_data_collection_import_event, $this->auth_headers(), [
            'data_type'        => 3,
            "protocol_version" => 1,
            "timestamp"        => time(),
            "appid"            => $this->oauth2_client_id,
            "productid"        => $this->project_id,
            'package_name'     => $this->package_name,
            'event_set'        => $data
        ] );
    }

    /**
     * Querying Open Metrics and Dimensions.
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/querying-open-indicators-and-dimensions-0000001152958663 Querying Open Metrics and Dimensions
     * @param string $lang
     * @param int $size
     * @param int $curr_page
     * @return \stdClass
     */
    public function query_metrics_and_dimensions( string $lang='en', int $size=10, int $curr_page=1 ): \stdClass {
        if (! in_array($lang, ['en', 'cn', 'ru'])) {
            throw new \InvalidArgumentException('lang must must be one of: en, cn, ru');
        }
        return $this->request('POST', $this->url_data_collection_import_item, $this->auth_headers(), [
            'lang' => $lang,
            'size' => $size,
            'curr_page' => $curr_page
        ] );
    }

    /**
     * Querying Dimension Values.
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/querying-dimension-values-0000001106240464 Querying Dimension Values
     * @param string $metric
     * @param string $dimension
     * @param string $lang
     * @param int $size
     * @param int $from
     * @return \stdClass
     */
    public function query_dimensions( string $metric, string $dimension, string $lang='en', int $size=10, int $from=0 ): \stdClass {
        if (! in_array($lang, ['en', 'cn', 'ru'])) {
            throw new \InvalidArgumentException('lang must must be one of: en, cn, ru');
        }
        return $this->request('POST', $this->url_data_collection_import_item, $this->auth_headers(), [
            'metric_name' => $metric,
            'dim_name' => $dimension,
            'lang' => $lang,
            'size' => $size,
            'from' => $from
        ] );
    }

    /**
     * Querying Statistical Metrics.
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/querying-tatistical-indicators-0000001152959491 Querying Statistical Metrics
     * @param string $metric
     * @param array $dimensions
     * @param string|null $start_date
     * @param string|null $end_date
     * @param string|null $filters
     * @param string|null $order_by
     * @param string $lang
     * @param int $size
     * @param int $curr_page
     * @return \stdClass
     */
    public function query_metrics( string $metric, array $dimensions, string|null $start_date, string|null $end_date,
                                   string|null $filters, string|null $order_by, string $lang='en', int $size=10,
                                   int $curr_page=1 ): \stdClass {
        if (! in_array($lang, ['en', 'cn', 'ru'])) {
            throw new \InvalidArgumentException('lang must must be one of: en, cn, ru');
        }
        return $this->request('POST', $this->url_data_collection_import_item, $this->auth_headers(), [
            'metric'     => $metric,
            'dimensions' => $dimensions,
            'start_date' => $start_date,
            'end_date'   => $end_date,
            'filters'    => $filters,
            'order_by'   => $order_by,
            'lang'       => $lang,
            'size'       => $size,
            'curr_page'  => $curr_page
        ] );
    }
}
