<?php /** @noinspection PhpUnused */
namespace HMS\WalletKit\TransitPass;

use HMS\WalletKit\WalletKit;

/**
 * Class HMS Wallet API: Transit Pass
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158448">Creating a Transit Pass Model</a>
 * @author Martin Zeitler
 */
class TransitPass extends WalletKit {

    public function __construct( array|string $config ) {
        parent::__construct( $config );

    }
}
