<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Thumbnail;

use HMS\DriveKit\Constants;
use HMS\DriveKit\DriveKit;
use stdClass;

/**
 * Class HMS DriveKit API: Thumbnail
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-thumbnailget-0000001050151706 Thumbnail
 * @author Martin Zeitler
 */
class Thumbnail extends DriveKit {

    /**
     * @param string $file_id The file ID.
     * @return bool|stdClass The result of the API call.
     */
    public function get( string $file_id ): stdClass|bool {
        $url = str_replace('{fileId}', $file_id, Constants::DRIVE_KIT_THUMBNAILS_URL);
        return $this->request( 'GET', $url, $this->auth_headers(), ['form' => 'content'] );
    }
}
