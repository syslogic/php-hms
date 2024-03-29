<?php
namespace HMS\AppGallery\Publishing;

use GuzzleHttp\RequestOptions;
use HMS\AppGallery\Connect;
use HMS\AppGallery\Constants;

/**
 * Class HMS AppGallery Connect Publishing Wrapper
 *
 * @link https://www.postman.com/huawei-agc/workspace/huawei-appgallery-connect-api/collection/17042659-0dc70b00-adb4-49e4-b61f-d268f800c223?ctx=documentation Postman
 * @author Martin Zeitler
 */
class Publishing extends Connect {

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->base_url = Constants::CONNECT_API_BASE_URL;
        if (isset($config['base_url'])) {$this->base_url = $config['base_url'];}
        $this->access_token = $this->get_access_token(true);
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-upload-url-0000001158365047 Obtaining the File Upload URL */
    public function request_file_upload_url( string $suffix='aab' ): bool|\stdClass {
        $url = $this->base_url.Constants::PUBLISH_API_FILE_UPLOAD_URL;
        $headers = $this->auth_headers(true);
        $payload = ['appId' => $this->oauth2_client_id, 'releaseType' => 1, 'suffix' => $suffix];
        return $this->request('GET', $url, $headers, $payload );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-upload-file-0000001158245059 Uploading a File */
    public function upload_file( string $upload_url, string $auth_code, string $file_path ): bool|\stdClass  {
        if (! file_exists($file_path)) {return false;}
        $headers = $this->auth_headers(true);
        unset($headers['Content-Type']); // important.
        $file_name = basename($file_path);
        $request = [
            RequestOptions::HEADERS => $headers,
            RequestOptions::DEBUG => $this->debug_mode,
            RequestOptions::MULTIPART => [
                ['name' => 'authCode', 'contents' => $auth_code],
                ['name' => 'file', 'filename' => $file_name, 'contents' => fopen( $file_path, 'r' )],
                ['name' => 'fileCount', 'contents' => 1]
            ]
        ];
        $response = $this->client->post( $upload_url, $request );
        return json_decode($response->getBody()->getContents())->result;
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-app-file-info-0000001111685202 Updating App File Information */
    public function update_file_info( string $file_path, string $file_dest_url, int $file_size ): bool|\stdClass {
        $url = $this->base_url.Constants::PUBLISH_API_APP_FILE_INFO.'?releaseType=1&appId=' . $this->oauth2_client_id;
        $headers = $this->auth_headers(true);
        $payload = [
            'fileType' => 5,
            'deviceType' => 4,
            'files' => [
                $this->get_file_info( $file_path, $file_dest_url, $file_size )
            ]
        ];
        return $this->request('PUT', $url, $headers, $payload);
    }

    public function submit_release(): bool|\stdClass {
        $url = $this->base_url.Constants::PUBLISH_API_APP_SUBMIT.'?releaseType=1&appId=' . $this->oauth2_client_id;
        $headers = $this->auth_headers(true);
        return $this->request('PUT', $url, $headers);
    }

    public function update_phased_release( string $state='RELEASE', int $release_type=1): bool|\stdClass {
        $release_types = [1, 3];
        if (! in_array($release_type, $release_types)) {
            $message = 'Invalid release type: ' .$release_type . ', permitted: '. implode(', ', $release_types);
            throw new \InvalidArgumentException($message);
        }
        $states = ['SUSPEND', 'RELEASE'];
        if (! in_array($state, $states)) {
            $message = 'Invalid state: ' .$state . ', permitted: '. implode(', ', $states);
            throw new \InvalidArgumentException($message);
        }
        $url = $this->base_url.Constants::PUBLISH_API_PHASED_RELEASE.'??releaseType=' . $release_type . '&appId=' . $this->oauth2_client_id;
        $headers = $this->auth_headers(true);
        $payload = ['state' => $state];
        return $this->request('PUT', $url, $headers, $payload );
    }

    public function update_phased_release_state( string $state='RELEASE' ): bool|\stdClass {
        $url = $this->base_url.Constants::PUBLISH_API_PHASED_RELEASE_STATE.'?&appId=' . $this->oauth2_client_id;
        $headers = $this->auth_headers(true);
        $states = ['SUSPEND', 'RELEASE'];
        if (! in_array($state, $states)) {
            $message = 'Invalid state: ' .$state . ', permitted: '. implode(', ', $states);
            throw new \InvalidArgumentException($message);
        }
        $payload = ['state' => $state];
        return $this->request('PUT', $url, $headers, $payload );
    }

    private function get_file_info( string $file_path, string $file_dest_url, int $file_size ): \stdClass {
        $file_info = new \stdClass();
        $file_info->fileName = basename($file_path);
        $file_info->fileDestUrl = $file_dest_url;
        $file_info->size = $file_size;
        return $file_info;
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
