<?php /** @noinspection PhpUnused */
namespace HMS\WalletKit\TransitPass;

use HMS\WalletKit\Constants;
use HMS\WalletKit\WalletPass;
use HMS\WalletKit\WalletKit;

/**
 * Class HMS Wallet API: Transit Pass Instance
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158448">Creating a Transit Pass Model</a>
 * @author Martin Zeitler
 */
class TransitPassInstance extends WalletKit implements WalletPass {

    public function __construct( array|string $config ) {
        parent::__construct( $config );
    }

    /** @noinspection PhpParameterNameChangedDuringInheritanceInspection */
    public function create( array $instance ): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_TRANSIT_PASS_INSTANCE;
        return $this->request('POST', $url, $this->auth_headers(), (object) $instance);
    }

    /** @noinspection PhpParameterNameChangedDuringInheritanceInspection */
    public function query( string $instance_id ): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_TRANSIT_PASS_INSTANCE . '/' . $instance_id;
        return $this->request( 'GET', $url, $this->auth_headers(), [
            'instanceId' => $instance_id
        ]);
    }

    /** @noinspection PhpParameterNameChangedDuringInheritanceInspection */
    public function update( string $instance_id, array $instance, $partial=false ): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_TRANSIT_PASS_INSTANCE . '/' . $instance_id;
        return $this->request( $partial ? 'PATCH':'POST', $url, $this->auth_headers(), (object) $instance);
    }

    /** @noinspection PhpParameterNameChangedDuringInheritanceInspection */
    public function add_message(string $instance_id, array $messages ): bool|\stdClass {
        return false;
    }
}
