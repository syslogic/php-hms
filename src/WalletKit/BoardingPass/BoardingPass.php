<?php /** @noinspection PhpUnused */
namespace HMS\WalletKit\BoardingPass;

use HMS\WalletKit\Constants;
use HMS\WalletKit\HwWalletObject;
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

    public function create(HwWalletObject $value) {
        $url = $this->base_url . Constants::WALLET_BOARDING_PASS_MODEL;
        return $this->guzzle_post($url, $this->auth_headers(), $value);
    }

    public function query(string $model_id): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_BOARDING_PASS_MODEL . '/' . $model_id;
        return $this->guzzle_get($url, $this->auth_headers(), [

        ]);
    }
}
