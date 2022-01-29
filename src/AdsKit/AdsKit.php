<?php
namespace HMS\AdsKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;

/**
 * Class HMS AdsKit Wrapper
 *
 * @author Martin Zeitler
 */
class AdsKit extends Wrapper {

    public function __construct( array|string $config ) {
        parent::__construct( $config );

        /* Obtain an access-token. */
        $account_kit = new AccountKit(['client_id' => $this->app_id, 'client_secret' => $this->app_secret]);
        $this->access_token = $account_kit->get_access_token();
    }
}
