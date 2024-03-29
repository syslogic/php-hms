<?php
namespace HMS\WalletKit;

use HMS\Core\Wrapper;
use HMS\WalletKit\BoardingPass\BoardingPassInstance;
use HMS\WalletKit\BoardingPass\BoardingPassModel;
use HMS\WalletKit\EventTicket\EventTicketInstance;
use HMS\WalletKit\EventTicket\EventTicketModel;
use HMS\WalletKit\GiftCard\GiftCardInstance;
use HMS\WalletKit\GiftCard\GiftCardModel;
use HMS\WalletKit\LoyaltyCard\LoyaltyCardInstance;
use HMS\WalletKit\LoyaltyCard\LoyaltyCardModel;
use HMS\WalletKit\Offer\OfferInstance;
use HMS\WalletKit\Offer\OfferModel;
use HMS\WalletKit\TransitPass\TransitPassInstance;
use HMS\WalletKit\TransitPass\TransitPassModel;

/**
 * Class HMS WalletKit Wrapper
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158460 WalletKit
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
            throw new \InvalidArgumentException('WalletKit requires an user access token.');
        }
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->developer_id, $this->project_id, $this->product_id, $this->package_name);
        unset($this->agc_project_client_id, $this->agcc_project_client_secret);
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

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158436 Creating a Boarding Pass Model */
    public function boardingPassModel(): BoardingPassModel {
        return new BoardingPassModel( $this->config() );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/add-instance-0000001050158442 Adding a Boarding Pass Instance */
    public function boardingPassInstance(): BoardingPassInstance {
        return new BoardingPassInstance( $this->config() );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158460 Creating an Event Ticket Model */
    public function eventTicketModel(): EventTicketModel {
        return new EventTicketModel( $this->config() );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/add-instance-0000001050158466 Adding an Event Ticket Instance */
    public function eventTicketInstance(): EventTicketInstance {
        return new EventTicketInstance( $this->config() );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158424 Creating a Gift Card Model */
    public function giftCardModel(): GiftCardModel {
        return new GiftCardModel( $this->config() );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/add-instance-0000001050158430 Adding a Gift Card Instance */
    public function giftCardInstance(): GiftCardInstance {
        return new GiftCardInstance( $this->config() );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158390 Creating a Loyalty Card Model */
    public function loyaltyCardModel(): LoyaltyCardModel {
        return new LoyaltyCardModel( $this->config() );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/add-instance-0000001050158396 Adding a Loyalty Card Instance */
    public function loyaltyCardInstance(): LoyaltyCardInstance {
        return new LoyaltyCardInstance( $this->config() );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050160357 Creating an Offer Model */
    public function offerModel(): OfferModel {
        return new OfferModel( $this->config() );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/add-instance-0000001050160363 Adding an Offer Instance */
    public function offerInstance(): OfferInstance {
        return new OfferInstance( $this->config() );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/create-model-0000001050158448 Creating a Transit Pass Model */
    public function transitPassModel(): TransitPassModel {
        return new TransitPassModel( $this->config() );
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/add-instance-0000001050158454 Adding a Transit Pass Instance */
    public function transitPassInstance(): TransitPassInstance {
        return new TransitPassInstance( $this->config() );
    }
}
