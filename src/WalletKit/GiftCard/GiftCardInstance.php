<?php /** @noinspection PhpUnused */
namespace HMS\WalletKit\GiftCard;

use HMS\WalletKit\Constants;
use HMS\WalletKit\WalletKit;
use HMS\WalletKit\WalletPass;

/**
 * Class HMS Wallet API: Gift Card Instance
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158424 Creating a Gift Card Model
 * @author Martin Zeitler
 */
class GiftCardInstance extends WalletKit implements WalletPass {

    public function __construct( array|string $config ) {
        parent::__construct( $config );
    }

    /** @noinspection PhpParameterNameChangedDuringInheritanceInspection */
    public function create( array $instance ): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_GIFT_CARD_INSTANCE;
        return $this->request('POST', $url, $this->auth_headers(), (object) $instance);
    }

    /** @noinspection PhpParameterNameChangedDuringInheritanceInspection */
    public function query( string $instance_id ): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_GIFT_CARD_INSTANCE . '/' . $instance_id;
        return $this->request( 'GET', $url, $this->auth_headers(), [
            'instanceId' => $instance_id
        ]);
    }

    /** @noinspection PhpParameterNameChangedDuringInheritanceInspection */
    public function update( string $instance_id, array $instance, $partial=false ): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_GIFT_CARD_INSTANCE . '/' . $instance_id;
        return $this->request( $partial ? 'PATCH':'POST', $url, $this->auth_headers(), (object) $instance);
    }

    /** @noinspection PhpParameterNameChangedDuringInheritanceInspection */
    public function add_message(string $instance_id, array $messages ): bool|\stdClass {
        return false;
    }
}
