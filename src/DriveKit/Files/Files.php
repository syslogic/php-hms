<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Files;

use HMS\DriveKit\DriveKit;
use HMS\DriveKit\Constants;

use stdClass;

/**
 * Class HMS DriveKit API: Files
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-filesgetmetadata-0000001050153645">Files</a>
 * @author Martin Zeitler
 */
class Files extends DriveKit {

    /**
     * @param string $fileId The file ID.
     * @return bool|stdClass The result of the API call.
     */
    public function get( string $fileId ): stdClass|bool {
        return $this->guzzle_get(Constants::DRIVE_KIT_FILES_URL . $fileId, $this->auth_headers(), [

        ]);
    }
}
