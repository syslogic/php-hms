<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\About;

use HMS\AccountKit\AccountKit;
use HMS\DriveKit\DriveKit;
use HMS\DriveKit\Constants;

use stdClass;

/**
 * Class HMS DriveKit API: About
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-aboutget-0000001050151684">About</a>
 * @author Martin Zeitler
 */
class About extends DriveKit {

    public function __construct( array $config ) {

        parent::__construct( $config );

        /* Obtain an access-token. */
        $account_kit = new AccountKit( $config );
        $this->access_token = $account_kit->get_access_token();
    }

    /**
     * @param string $fields The field names to return.
     * @return bool|stdClass The result of the API call.
     */
    public function get( string $fields='*' ): stdClass|bool {
        return $this->guzzle_get(Constants::DRIVE_KIT_ABOUT_URL . $fields, $this->auth_headers(), []);
    }
}
