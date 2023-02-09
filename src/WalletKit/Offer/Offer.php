<?php /** @noinspection PhpUnused */
namespace HMS\WalletKit\Offer;

use HMS\WalletKit\WalletKit;

/**
 * Class HMS Wallet API: Offer
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050160357">Creating an Offer Model</a>
 * @author Martin Zeitler
 */
class Offer extends WalletKit {

    public function __construct( array|string $config ) {
        parent::__construct( $config );

    }
}
