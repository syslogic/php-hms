<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace HMS\AnalyticsKit;

use HMS\Core\Wrapper;
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
        parent::__construct( $config, 3 );
        if ($this->is_ready()) {
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
        }
    }

    /** Provide HTTP request headers as array. */
    protected function auth_header(): array {
        return [
            "Content-Type: application/json", "Authorization: Bearer $this->access_token",
            "x-product-id: $this->project_id", // equal product_id.
            "x-app-id: $this->client_id"       // equal app_id.
        ];
    }

    /**
     * Exporting Personal Data.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/topic-list-api-0000001050706152">Querying the Topic Subscription List</a>
     * @param string $token
     * @return stdClass
     */
    public function request_user_data_export( string $aaid ): stdClass {
        $payload = ['aaid' => $aaid];
        return $this->curl_request('POST', $this->url_user_data_export, $payload, $this->auth_header());
    }
}
