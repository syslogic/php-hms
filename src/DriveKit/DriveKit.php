<?php
namespace HMS\DriveKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;

/**
 * Class HMS DriveKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/server-public-info-0000001050159641">DriveKit</a>
 * @author Martin Zeitler
 */
class DriveKit extends Wrapper {

    public function __construct( array|string $config ) {
        parent::__construct( $config );

        /* Obtain an access-token. */
        $account_kit = new AccountKit(['client_id' => $this->app_id, 'client_secret' => $this->app_secret]);
        $this->access_token = $account_kit->get_access_token();
    }
}
