<?php
namespace HMS\GameService;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;

/**
 * Class HMS GameService Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/verify-login-signature-0000001050123503">GameService</a>
 * @author Martin Zeitler
 */
class GameService extends Wrapper {

    /** Constructor */
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
