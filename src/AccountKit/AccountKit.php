<?php
namespace HMS\AccountKit;

use HMS\Core\Wrapper;

/**
 * Class HMS AccountKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-obtain-token_hms_reference-0000001050048618">AccountKit</a>
 * @author Martin Zeitler
 */
class AccountKit extends Wrapper {

    public function __construct( array $config ) {
        parent::__construct( $config, 3 );
    }
}
