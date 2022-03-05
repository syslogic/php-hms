<?php
namespace HMS\AdsKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class HMS AdsKit Wrapper
 *
 * @author Martin Zeitler
 */
class AdsKit extends Wrapper {

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
