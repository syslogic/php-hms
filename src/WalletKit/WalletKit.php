<?php
namespace HMS\WalletKit;

use HMS\Core\Wrapper;
use HMS\WalletKit\BoardingPass\BoardingPass;
use HMS\WalletKit\EventTicket\EventTicket;
use HMS\WalletKit\GiftCard\GiftCard;
use HMS\WalletKit\LoyaltyCard\LoyaltyCard;
use HMS\WalletKit\Offer\Offer;
use HMS\WalletKit\TransitPass\TransitPass;
use InvalidArgumentException;

/**
 * Class HMS WalletKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158460">WalletKit</a>
 * @author Martin Zeitler
 */
class WalletKit extends Wrapper {

    protected string $base_url;

    public function __construct( array|string $config ) {

        parent::__construct( $config );
        $this->post_init();

        // $this->base_url = Constants::WALLET_SERVER_CN;
        $this->base_url = Constants::WALLET_SERVER_EU;

        if (is_array($config) && isset($config['access_token'])) {
            $this->access_token = $config['access_token'];
        } else {
            throw new InvalidArgumentException('WalletKit requires an user access token.');
        }
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->api_key, $this->api_signature);
    }

    private function config(): array {
        return [
            'access_token' => $this->access_token,
            'oauth2_client_id' => $this->oauth2_client_id,
            'oauth2_client_secret' => $this->oauth2_client_secret,
            'debug_mode' => $this->debug_mode,
            'base_url' => $this->base_url
        ];
    }

    /**
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158436">Creating a Boarding Pass Model</a>
     */
    public function getBoardingPass(): BoardingPass {
        return new BoardingPass( $this->config() );
    }

    /**
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158460">Creating an Event Ticket Model</a>
     */
    public function getEventTicket(): EventTicket {
        return new EventTicket( $this->config() );
    }

    /**
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158424">Creating a Gift Card Model</a>
     */
    public function getGiftCard(): GiftCard {
        return new GiftCard( $this->config() );
    }

    /**
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158390">Creating a Loyalty Card Model</a>
     */
    public function getLoyaltyCard(): LoyaltyCard {
        return new LoyaltyCard( $this->config() );
    }

    /**
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050160357">Creating an Offer Model</a>
     */
    public function getOffer(): Offer {
        return new Offer( $this->config() );
    }

    /**
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158448">Creating a Transit Pass Model</a>
     */
    public function getTransitPass(): TransitPass {
        return new TransitPass( $this->config() );
    }
}
