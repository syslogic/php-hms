<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Replies;

use HMS\DriveKit\DriveKit;
use HMS\DriveKit\Constants;

use stdClass;

/**
 * Class HMS DriveKit API: Replies
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-replieslist-0000001050151720">Replies</a>
 * @author Martin Zeitler
 */
class Replies extends DriveKit {

    /**
     * @return bool|stdClass The result of the API call.
     */
    public function list( string $fileId ): stdClass|bool {
        $url = str_replace('{fileId}', $fileId, Constants::DRIVE_KIT_REPLIES_URL);
        return $this->guzzle_get($url, $this->auth_headers(), []);
    }
}
