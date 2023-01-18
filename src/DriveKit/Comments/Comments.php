<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Comments;

use HMS\DriveKit\DriveKit;
use HMS\DriveKit\Constants;

use InvalidArgumentException;
use stdClass;

/**
 * Class HMS DriveKit API: Comments
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-commentslist-0000001050151714">Comments</a>
 * @author Martin Zeitler
 */
class Comments extends DriveKit {

    public function __construct( array $config ) {

        // unsure if this call is even required.
        parent::__construct( $config );

        if (isset( $config['access_token'] )) {
            $this->access_token = $config['access_token'];
        } else {
            throw new InvalidArgumentException('DriveKit requires an access token.');
        }
    }

    /**
     * @return bool|stdClass The result of the API call.
     */
    public function list( string $fileId ): stdClass|bool {
        $url = str_replace('{fileId}', $fileId, Constants::DRIVE_KIT_COMMENTS_URL);
        return $this->guzzle_get($url, $this->auth_headers(), []);
    }
}
