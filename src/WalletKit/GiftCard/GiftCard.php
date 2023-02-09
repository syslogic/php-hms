<?php /** @noinspection PhpUnused */
namespace HMS\WalletKit\GiftCard;

use HMS\WalletKit\WalletKit;

/**
 * Class HMS Wallet API: Gift Card
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158424">Creating a Gift Card Model</a>
 * @author Martin Zeitler
 */
class GiftCard extends WalletKit {

    public function __construct( array|string $config ) {
        parent::__construct( $config );

    }
}
