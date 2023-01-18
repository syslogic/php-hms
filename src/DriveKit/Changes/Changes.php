<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Changes;

use HMS\DriveKit\DriveKit;
use HMS\DriveKit\Constants;

use InvalidArgumentException;
use stdClass;

/**
 * Class HMS DriveKit API: Changes
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-aboutget-0000001050151684">Changes</a>
 * @author Martin Zeitler
 */
class Changes extends DriveKit {

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
    public function getStartCursor(): stdClass|bool {
        return $this->guzzle_get(Constants::DRIVE_KIT_CHANGES_URL . '/getStartCursor', $this->auth_headers(), []);
    }
}
