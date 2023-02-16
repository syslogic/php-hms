<?php
namespace HMS\AppGallery\Publishing;

use HMS\Core\Wrapper;

/**
 * Class HMS AppGallery Publishing Wrapper
 *
 * @author Martin Zeitler
 */
class Publishing extends Wrapper {

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->post_init();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->api_key, $this->api_signature);
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-upload-url-0000001158365047 Obtaining the File Upload URL */
    public function request_file_upload_url( string $upload_url, string $auth_code, string $file_path ) {

    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-upload-file-0000001158245059 Uploading a File */
    public function upload_file( string $upload_url, string $auth_code, string $file_path ) {

    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-file-info-0000001111685202 Updating App File Information */
    public function update_file_info( $file_url, $file_size ) {

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
