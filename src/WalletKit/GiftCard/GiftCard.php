<?php /** @noinspection PhpUnused */
namespace HMS\WalletKit\GiftCard;

use HMS\WalletKit\Constants;
use HMS\WalletKit\Model\WalletObject;
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

    public function create(WalletObject $value): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_GIFT_CARD_MODEL;
        return $this->request('POST', $url, $this->auth_headers(), $value->asObject());
    }

    public function query(string $model_id): bool|\stdClass {
        $url = $this->base_url . Constants::WALLET_GIFT_CARD_MODEL . '/' . $model_id;
        return $this->request( 'GET', $url, $this->auth_headers(), [

        ]);
    }
}
