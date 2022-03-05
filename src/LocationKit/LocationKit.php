<?php
namespace HMS\LocationKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;

/**
 * Class HMS LocationKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/web-overview-0000001052619173">LocationKit</a>
 * @author Martin Zeitler
 */
class LocationKit extends Wrapper {

    public function __construct( array|string $config ) {
        parent::__construct( $config );

        /* Obtain an access-token. */
        $account_kit = new AccountKit( $config );
        $this->access_token = $account_kit->get_access_token();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init() {

    }
}
