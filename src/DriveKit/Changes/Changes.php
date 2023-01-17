<?php /** @noinspection PhpUnused */
namespace HMS\DriveKit\Changes;

use HMS\AccountKit\AccountKit;
use HMS\DriveKit\DriveKit;
use HMS\DriveKit\Constants;

use stdClass;

/**
 * Class HMS DriveKit API: Changes
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-api-aboutget-0000001050151684">Changes</a>
 * @author Martin Zeitler
 */
class Changes extends DriveKit {

    public function __construct( array $config ) {

        parent::__construct( $config );

        /* TODO: Authorization Code. */
        $account_kit = new AccountKit( $config );
        $this->access_token = $account_kit->get_access_token();
    }

    /**
     * @return bool|stdClass The result of the API call.
     */
    public function getStartCursor(): stdClass|bool {
        return $this->guzzle_get(Constants::DRIVE_KIT_CHANGES_URL . '/getStartCursor', $this->auth_headers(), []);
    }
}
