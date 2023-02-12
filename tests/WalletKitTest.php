<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace Tests;

use HMS\WalletKit\WalletObject\WalletObject;
use HMS\WalletKit\WalletKit;

/**
 * HMS WalletKit Test: Skipped.
 *
 * @author Martin Zeitler
 */
class WalletKitTest extends BaseTestCase {

    /** @var WalletKit|null $client */
    private static ?WalletKit $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        parent::load_user_access_token();
        self::$client = new WalletKit( self::get_user_config() );
    }

    public function test_skipped() {
        self::markTestSkipped( "WalletKit uses an interactive OAuth2 flow -> www/walletkit.php." );
    }

    /** Test: Model WalletObject */
    public function test_wallet_object() {
        $item = new WalletObject([
        "passVersion" => "1.0",
        "passTypeIdentifier" => "hwpass.com.huawei.wallet.loyalty",
        "passStyleIdentifier" => "loyaltyModel",
        "organizationName" => "Huawei",
        "organizationPassId" => "356688115",
        "serialNumber" => "40001",
        "fields" => [
            "countryCode"=> "CN",
            "allowMultiUser"=> "false",
            "status" => [
                "state" => "active",
                "effectTime" => "2019-11-13T00:00:00.111Z",
                "expireTime" => "2028-11-20T00:00:00.111Z"
            ],
            "locationList" => [
                ["longitude" => "114.0679603815", "latitude" => "22.6592051284"]
            ],
            "barCode" => [
                "text" => "1118466050",
                "type" => "codabar",
                "value" => "1118466050",
                "encoding" => "UTF-8"
            ],
            "commonFields"=> [
                ["key" => "logo", "value" => "https://www.huawei.com/XXX.png", "label" => "Logo"],
                ["key" => "backgroundImage", "value" => "https://www.huawei.com/XXX.png", "label" => "Background"],
                ["key" => "name", "value" => "XXX Gold Loyalty Card", "label" => "Card Name", "localizedValue" => "cardName"],
                ["key" => "merchantName", "value" => "XXX Super Market", "label" => "Merchant", "localizedValue" => "merchantNameI18N"],
                ["key" => "cardNumber", "value" => "356688115", "label" => "Card Number"],
                ["key" => "balance", "value" => "$199", "label" => "Balance"],
                ["key" => "memberName", "value" => "Joe Wiley", "label" => "Name"]
            ],
            "appendFields" => [
                ["key" => "backgroundColor", "value" => "#483d8b", "label" => "Background Color"],
                ["key" => "hotline", "value" => "8006011450", "label" => "Hotline"],
                ["key" => "website", "value" => "https://www.huawei.com", "label" => "Website"],
                ["key" => "level", "value" => "Gold", "label" => "Membership Tier"],
                ["key" => "points", "value" => "2000", "label" => "Points"]
            ],
            "messageList" => [
                ["key" => "message[0]", "value" => "Best wishes.", "label" => "Message"]
            ],
            "imageList" => [
                ["key" => "mainImage[0]", "value" => "https://www.huawei.com/XXX0.png"],
                ["key" => "mainImage[1]", "value" => "https://www.huawei.com/XXX1.png"],
                ["key" => "mainImage[2]", "value" => "https://www.huawei.com/XXX2.png"]
            ],
            "localized" => [
                ["key" => "cardName", "language" => "zh-cn", "value" => "XXX Gold Loyalty Card"],
                ["key" => "cardName", "language" => "en", "value" => "XXX Gold Loyalty Card"],
                ["key" => "merchantNameI18N", "language" => "zh-cn", "value" => "Huawei Online Store"],
                ["key" => "merchantNameI18N", "language" => "en", "value" => "Huawei Online Store"]
            ]
        ]
        ]);
        self::assertIsObject( $item->asObject() );
    }

    /** Test: Model BoardingPassModel */
    public function test_boarding_pass_model() {
        $item = self::$client->boardingPassModel();
        self::assertIsObject( $item );
    }

    /** Test: Model BoardingPassInstance */
    public function test_boarding_pass_instance() {
        $item = self::$client->boardingPassInstance();
        self::assertIsObject( $item );
    }

    /** Test: Model EventTicketModel */
    public function test_event_ticket_model() {
        $item = self::$client->eventTicketModel();
        self::assertIsObject( $item );
    }

    /** Test: Model EventTicketInstance */
    public function test_event_ticket_instance() {
        $item = self::$client->eventTicketInstance();
        self::assertIsObject( $item );
    }

    /** Test: Model GiftCardModel */
    public function test_gift_card_model() {
        $item = self::$client->giftCardModel();
        self::assertIsObject( $item );
    }

    /** Test: Model GiftCardInstance */
    public function test_gift_card_instance() {
        $item = self::$client->giftCardInstance();
        self::assertIsObject( $item );
    }

    /** Test: Model LoyaltyCardModel */
    public function test_loyalty_card_model() {
        $item = self::$client->loyaltyCardModel();
        self::assertIsObject( $item );
    }

    /** Test: Model LoyaltyCardInstance */
    public function test_loyalty_card_instance() {
        $item = self::$client->loyaltyCardInstance();
        self::assertIsObject( $item );
    }

    /** Test: Model OfferModel */
    public function test_offer_model() {
        $item = self::$client->offerModel();
        self::assertIsObject( $item );
    }

    /** Test: Model OfferInstance */
    public function test_offer_instance() {
        $item = self::$client->offerInstance();
        self::assertIsObject( $item );
    }

    /** Test: Model TransitPassModel */
    public function test_transit_pass_model() {
        $item = self::$client->transitPassModel();
        self::assertIsObject( $item );
    }

    /** Test: Model TransitPassInstance */
    public function test_transit_pass_instance() {
        $item = self::$client->transitPassInstance();
        self::assertIsObject( $item );
    }
}
