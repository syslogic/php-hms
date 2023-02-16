<?php /** @noinspection PhpUnused */
namespace HMS\WalletKit\Offer;

use HMS\WalletKit\Constants;
use HMS\WalletKit\WalletKit;
use HMS\WalletKit\WalletPass;

/**
 * Class HMS Wallet API: Offer Model
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050160357 Creating an Offer Model
 * @author Martin Zeitler
 */
class OfferModel extends WalletKit implements WalletPass {

    public function __construct( array|string $config ) {
        parent::__construct( $config );
    }

    public function create( array $model ): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_OFFER_MODEL;
        return $this->request('POST', $url, $this->auth_headers(), (object) $model);
    }

    public function query( string $model_id ): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_OFFER_MODEL . '/' . $model_id;
        return $this->request( 'GET', $url, $this->auth_headers(), [
            'modelId' => $model_id
        ]);
    }

    public function update( string $model_id, array $model, $partial=false ): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_OFFER_MODEL . '/' . $model_id;
        return $this->request( $partial ? 'PATCH':'POST', $url, $this->auth_headers(), (object) $model);
    }

    public function add_message( string $model_id, array $messages ): bool|\stdClass {
        return false;
    }
}
