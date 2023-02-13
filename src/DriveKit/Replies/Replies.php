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
    public function list( string $fileId, string $commentId, string $fields='' ): stdClass|bool {
        $url = str_replace(['{fileId}', '{commentId}'], [$fileId, $commentId], Constants::DRIVE_KIT_COMMENT_REPLIES_URL);
        return $this->request( 'GET', $url, $this->auth_headers(), [
            'fields' => $fields
        ]);
    }

    /**
     * @return bool|stdClass The result of the API call.
     */
    public function get( string $fileId, string $commentId ): stdClass|bool {
        return false;
    }

    /**
     * HTTP PATCH
     * @return bool|stdClass The result of the API call.
     */
    public function update( string $fileId, string $commentId ): stdClass|bool {
        return false;
    }

    /**
     * @return bool|stdClass The result of the API call.
     */
    public function delete( string $fileId, string $commentId ): stdClass|bool {
        return false;
    }
}
