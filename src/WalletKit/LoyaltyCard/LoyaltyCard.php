<?php /** @noinspection PhpUnused */
namespace HMS\WalletKit\LoyaltyCard;

use HMS\WalletKit\WalletKit;

/**
 * Class HMS Wallet API: Loyalty Card
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158390">Creating a Loyalty Card Model</a>
 * @author Martin Zeitler
 */
class LoyaltyCard extends WalletKit {

    public function __construct( array|string $config ) {
        parent::__construct( $config );

    }
}
