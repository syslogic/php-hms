<?php
namespace HMS\AppGallery\Publishing;

use HMS\AppGallery\Connect;
use HMS\AppGallery\Constants;

/**
 * Class HMS AppGallery Connect Publishing Wrapper
 *
 * @author Martin Zeitler
 */
class Publishing extends Connect {

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->base_url = Constants::PUBLISH_API_BASE_URL;
        if (isset($config['base_url'])) {$this->base_url = $config['base_url'];}
        $this->access_token = $this->get_access_token(true);
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-upload-url-0000001158365047 Obtaining the File Upload URL */
    public function request_file_upload_url(): bool|\stdClass {
        $url = $this->base_url.Constants::PUBLISH_API_FILE_UPLOAD_URL;
        $headers = $this->auth_headers(true);
        $payload = ['appId' => $this->oauth2_client_id, 'releaseType' => 1, 'suffix' => 'aab'];
        return $this->request('GET', $url, $headers, $payload );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-upload-file-0000001158245059 Uploading a File */
    public function upload_file( string $upload_url, string $auth_code, string $file_path ): bool|\stdClass  {
        $headers = $this->auth_headers(true);
        $payload = [];
        return $this->request('POST', $upload_url, $headers, $payload);
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-file-info-0000001111685202 Updating App File Information */
    public function update_file_info( $file_url, $file_size ) {
        $url = $this->base_url.Constants::PUBLISH_API_APP_FILE_INFO;
        $headers = $this->auth_headers(true);
        $payload = [];
        return $this->request('POST', $url, $headers, $payload);
    }

    /**
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-notify-release-0000001158245063 Submission Callback
     * TODO: emulate & process post-back.
     */
    public function on_submission_callback(): bool {
        $key_file = '/var/www/.credentials/agconnect.pem';
        $item = new SubmissionCallback( $key_file );
        return true; // TODO
    }
}
