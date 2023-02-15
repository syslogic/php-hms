<?php /** @noinspection PhpUnused */
namespace HMS\WalletKit\TransitPass;

use HMS\WalletKit\Constants;
use HMS\WalletKit\WalletKit;
use HMS\WalletKit\WalletPass;

/**
 * Class HMS Wallet API: Transit Pass Model
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158448">Creating a Transit Pass Model</a>
 * @author Martin Zeitler
 */
class TransitPassModel extends WalletKit implements WalletPass {

    public function __construct( array|string $config ) {
        parent::__construct( $config );
    }

    public function create( array $model ): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_TRANSIT_PASS_MODEL;
        return $this->request('POST', $url, $this->auth_headers(), (object) $model);
    }

    public function query( string $model_id ): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_TRANSIT_PASS_MODEL . '/' . $model_id;
        return $this->request( 'GET', $url, $this->auth_headers(), [
            'modelId' => $model_id
        ]);
    }

    public function update( string $model_id, array $model, $partial=false ): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_TRANSIT_PASS_MODEL . '/' . $model_id;
        return $this->request( $partial ? 'PATCH':'POST', $url, $this->auth_headers(), (object) $model);
    }

    public function add_message( string $model_id, array $messages ): bool|\stdClass {
        return false;
    }
}
