<?php
namespace HMS\MapKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;

/**
 * Class HMS MapKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/web-overview-0000001052619173">LocationKit</a>
 * @author Martin Zeitler
 */
class MapKit extends Wrapper {

    public function __construct( array|string $config ) {
        parent::__construct( $config );

        /* Obtain an access-token. */
        $account_kit = new AccountKit(['client_id' => $this->app_id, 'client_secret' => $this->app_secret]);
        $this->access_token = $account_kit->get_access_token();
    }
}
