<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Thumbnail;

use HMS\DriveKit\DriveKit;
use HMS\DriveKit\Constants;

use stdClass;

/**
 * Class HMS DriveKit API: Thumbnail
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-thumbnailget-0000001050151706">Thumbnail</a>
 * @author Martin Zeitler
 */
class Thumbnail extends DriveKit {

    /**
     * @return bool|stdClass The result of the API call.
     */
    public function get( string $fileId ): stdClass|bool {
        $url = str_replace('{fileId}', $fileId, Constants::DRIVE_KIT_THUMBNAILS_URL);
        return $this->request( 'GET', $url, $this->auth_headers(), []);
    }
}
