<?php
namespace HMS\WalletKit;

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
    }
}
