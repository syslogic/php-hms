<?php /** @noinspection PhpUnused */
namespace HMS\WalletKit\EventTicket;

use HMS\WalletKit\Constants;
use HMS\WalletKit\IWalletPass;
use HMS\WalletKit\Model\WalletObject;
use HMS\WalletKit\WalletKit;

/**
 * Class HMS Wallet API: Event Ticket
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158460">Creating an Event Ticket Model</a>
 * @author Martin Zeitler
 */
class EventTicket extends WalletKit implements IWalletPass {

    public function __construct( array|string $config ) {
        parent::__construct( $config );
    }

    public function create_model( WalletObject $value ): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_EVENT_TICKET_MODEL;
        return $this->request('POST', $url, $this->auth_headers(), $value->asObject());
    }

    public function query_model(string $model_id): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_EVENT_TICKET_MODEL . '/' . $model_id;
        return $this->request( 'GET', $url, $this->auth_headers(), [

        ]);
    }
}
