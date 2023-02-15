<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\About;

use HMS\DriveKit\Constants;
use HMS\DriveKit\DriveKit;
use stdClass;

/**
 * Class HMS DriveKit API: About
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-aboutget-0000001050151684">About</a>
 * @author Martin Zeitler
 */
class About extends DriveKit {

    /**
     * @param string $fields The field names to return.
     * @return bool|stdClass The result of the API call.
     */
    public function get( string $fields='*' ): stdClass|bool {
        return $this->request( 'GET', Constants::DRIVE_KIT_ABOUT_URL . $fields, $this->auth_headers(), [
            'fields' => $fields
        ]);
    }
}
