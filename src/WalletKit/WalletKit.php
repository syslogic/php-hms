<?php
namespace HMS\WalletKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;

/**
 * Class HMS WalletKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/overview-0000001057087079">WalletKit</a>
 * @author Martin Zeitler
 */
class WalletKit extends Wrapper {

    public function __construct( array|string $config ) {
        parent::__construct( $config );

        /* Obtain an access-token. */
        $account_kit = new AccountKit( $config );
        $this->access_token = $account_kit->get_access_token();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init() {
        unset($this->api_key, $this->api_signature);
    }
}
