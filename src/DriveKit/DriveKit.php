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

    /** Constructor */
    public function __construct( array|string $config ) {

        parent::__construct( $config );
        $this->post_init();

        /* Obtain an access-token. */
        $account_kit = new AccountKit( $config );
        $this->access_token = $account_kit->get_access_token();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->api_key, $this->api_signature);
    }
}
