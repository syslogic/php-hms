<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery\Report;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use HMS\AppGallery\Connect;
use HMS\AppGallery\Constants;

/**
 * Class HMS AppGallery Connect Report Wrapper
 *
 * @author Martin Zeitler
 */
class Report extends Connect {

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->base_url = Constants::CONNECT_API_BASE_URL;
        if (isset($config['base_url'])) {$this->base_url = $config['base_url'];}
        $this->access_token = $this->get_access_token(true);
    }

    /**
     * @throws GuzzleException
     */
    public function download(string $source_url, string $destination_path ): void {
        $request = [
            RequestOptions::HEADERS => $this->request_headers(),
            RequestOptions::DEBUG => $this->debug_mode,
            RequestOptions::SINK => $destination_path
        ];
        $this->client->get( $source_url, $request );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-iapexport-0000001158365061 Obtaining the Download and Installation Report URL */
    public function download_and_installation_report( string $language='en-US', string $start_time='20230101', string $end_time='20230131', string $group_by='date', string $export_type='CSV' ): string|null {
        $url = $this->base_url.Constants::REPORT_API_DOWNLOAD_AND_INSTALLATION_GET_URL.$this->oauth2_client_id;
        $headers = $this->auth_headers(true);
        $payload = [
            'language' => $language,
            'startTime' => $start_time,
            'endTime' => $end_time,
            'groupBy' => $group_by,
            'exportType' => $export_type
        ];
        $result = $this->request('GET', $url, $headers, $payload );
        if (property_exists($result, 'fileURL')) {
            return $result->fileURL;
        }
        return null;
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-appdownloadexport-0000001158365059 Obtaining the In-App Purchases Report URL */
    public function in_app_purchases_report( string $language='en-US', string $start_time='20230101', string $end_time='20230131', string $group_by='date', string $export_type='CSV' ): string|null {
        $url = $this->base_url.Constants::REPORT_API_IN_APP_PURCHASES_GET_URL.$this->oauth2_client_id;
        $headers = $this->auth_headers(true);
        $payload = [
            'language' => $language,
            'startTime' => $start_time,
            'endTime' => $end_time,
            'groupBy' => $group_by,
            'exportType' => $export_type
        ];
        $result = $this->request('GET', $url, $headers, $payload );
        if (property_exists($result, 'fileURL')) {
            return $result->fileURL;
        }
        return null;
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-orderanalysisexport-0000001111685214 Obtaining the Paid App Report URL */
    public function paid_apps_report( string $language='en-US', string $start_time='20230101', string $end_time='20230131', string $group_by='date', string $export_type='CSV' ) {
        $url = $this->base_url.Constants::REPORT_API_PAID_APPS_GET_URL.$this->oauth2_client_id;
        $headers = $this->auth_headers(true);
        $payload = [
            'language' => $language,
            'startTime' => $start_time,
            'endTime' => $end_time,
            'groupBy' => $group_by,
            'exportType' => $export_type
        ];
        $result = $this->request('GET', $url, $headers, $payload );
        if (property_exists($result, 'fileURL')) {
            return $result->fileURL;
        }
        return null;
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-orderdetailexport-0000001158245073 Obtaining the Paid App Details Report URL */
    public function paid_app_details_report( string $language='en-US', string $start_time='20230101', string $end_time='20230131', int $query_type=0, string $export_type='CSV' ): string|null {
        $url = $this->base_url.Constants::REPORT_API_PAID_APP_DETAILS_GET_URL.$this->oauth2_client_id;
        $headers = $this->auth_headers(true);
        $payload = [
            'language' => $language,
            'startTime' => $start_time,
            'endTime' => $end_time,
            'queryType' => $query_type,
            'filterCondition' => 'countryId',
            'filterConditionValue' => 'CN',
            'exportType' => $export_type
        ];
        $result = $this->request('GET', $url, $headers, $payload );
        if (property_exists($result, 'fileURL')) {
            return $result->fileURL;
        }
        return null;
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-appdownloadfailexport-0000001158365063 Obtaining the Installation Failure Data Report URL */
    public function installation_failure_report( string $language='en-US', string $start_time='20230101', string $end_time='20230131', string $group_by='date', string $export_type='CSV' ): string|null {
        $url = $this->base_url.Constants::REPORT_API_INSTALLATION_FAILURE_GET_URL.$this->oauth2_client_id;
        $headers = $this->auth_headers(true);
        $payload = [
            'language' => $language,
            'startTime' => $start_time,
            'endTime' => $end_time,
            'groupBy' => $group_by,
            'exportType' => $export_type
        ];
        $result = $this->request('GET', $url, $headers, $payload );
        if (property_exists($result, 'fileURL')) {
            return $result->fileURL;
        }
        return null;
    }
}
