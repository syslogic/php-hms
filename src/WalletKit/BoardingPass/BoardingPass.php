<?php /** @noinspection PhpUnused */
namespace HMS\WalletKit\BoardingPass;

use HMS\WalletKit\WalletKit;

/**
 * Class HMS Wallet API: Boarding Pass
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158436">Creating a Boarding Pass Model</a>
 * @author Martin Zeitler
 */
class BoardingPass extends WalletKit {

    public function __construct( array|string $config ) {
        parent::__construct( $config );

    }
}
