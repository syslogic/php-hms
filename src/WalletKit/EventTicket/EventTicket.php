<?php /** @noinspection PhpUnused */
namespace HMS\WalletKit\EventTicket;

use HMS\WalletKit\WalletKit;

/**
 * Class HMS Wallet API: Event Ticket
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158460">Creating an Event Ticket Model</a>
 * @author Martin Zeitler
 */
class EventTicket extends WalletKit {

    public function __construct( array|string $config ) {
        parent::__construct( $config );

    }
}
