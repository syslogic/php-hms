<?php
namespace HMS\AppGallery\Publishing;

use HMS\Core\Wrapper;

/**
 * Class HMS AppGallery Publishing Wrapper
 *
 * @author Martin Zeitler
 */
class Publishing extends Wrapper {

    public function __construct( array|string $config ) {
        parent::__construct( $config );
    }

    /**
     * GET: Obtaining the File Upload URL.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-upload-url-0000001158365047">Obtaining the File Upload URL</a>
     */
    public function request_file_upload_url(string $upload_url, string $auth_code, string $file_path) {

    }

    /**
     * Uploading a File.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-upload-file-0000001158245059">Uploading a File</a>
     */
    public function upload_file(string $upload_url, string $auth_code, string $file_path) {

    }

    /**
     * Updating App File Information.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-file-info-0000001111685202">Updating App File Information</a>
     */
    public function update_file_info($file_url, $file_size) {

    }

    /**
     * On Submission Callback
     * TODO: emulate & process post-back.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-notify-release-0000001158245063">Submission Callback</a>
     */
    public function on_submission_callback(): bool {
        $key_file = '/var/www/.credentials/agconnect.pem';
        $item = new SubmissionCallback( $key_file );

        return true; // TODO
    }
}
