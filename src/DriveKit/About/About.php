<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\About;

use HMS\DriveKit\DriveKit;
use HMS\DriveKit\Constants;

use InvalidArgumentException;
use stdClass;

/**
 * Class HMS DriveKit API: About
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-aboutget-0000001050151684">About</a>
 * @author Martin Zeitler
 */
class About extends DriveKit {

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
     * @param string $fields The field names to return.
     * @return bool|stdClass The result of the API call.
     */
    public function get( string $fields='*' ): stdClass|bool {
        return $this->guzzle_get(Constants::DRIVE_KIT_ABOUT_URL . $fields, $this->auth_headers(), []);
    }
}
