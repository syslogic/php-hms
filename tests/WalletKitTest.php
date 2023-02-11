<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace Tests;

use HMS\WalletKit\EventTicket\EventTicketModel;
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
        self::$client = new WalletKit( [ 'access_token' => '' ] );
    }

    /*
    public function test_skipped() {
        self::markTestSkipped( "WalletKit uses interactive OAuth2 flow -> www/walletkit.php." );
    }
    */

    /** Test: Model BoardingPassModel. */
    public function test_boarding_pass_model() {
        $item = self::$client->boardingPassModel();
        self::assertIsObject( $item );
    }

    /** Test: Model BoardingPassInstance. */
    public function test_boarding_pass_instance() {
        $item = self::$client->boardingPassInstance();
        self::assertIsObject( $item );
    }

    /** Test: Model EventTicketModel. */
    public function test_event_ticket_model() {
        $item = self::$client->eventTicketModel();
        self::assertIsObject( $item );
    }

    /** Test: Model EventTicketInstance. */
    public function test_event_ticket_instance() {
        $item = self::$client->eventTicketInstance();
        self::assertIsObject( $item );
    }

    /** Test: Model GiftCardModel. */
    public function test_gift_card_model() {
        $item = self::$client->giftCardModel();
        self::assertIsObject( $item );
    }

    /** Test: Model GiftCardInstance. */
    public function test_gift_card_instance() {
        $item = self::$client->giftCardInstance();
        self::assertIsObject( $item );
    }

    /** Test: Model LoyaltyCardModel. */
    public function test_loyalty_card_model() {
        $item = self::$client->loyaltyCardModel();
        self::assertIsObject( $item );
    }

    /** Test: Model LoyaltyCardInstance. */
    public function test_loyalty_card_instance() {
        $item = self::$client->loyaltyCardInstance();
        self::assertIsObject( $item );
    }

    /** Test: Model OfferModel. */
    public function test_offer_model() {
        $item = self::$client->offerModel();
        self::assertIsObject( $item );
    }

    /** Test: Model OfferInstance. */
    public function test_offer_instance() {
        $item = self::$client->offerInstance();
        self::assertIsObject( $item );
    }

    /** Test: Model TransitPassModel. */
    public function test_transit_pass_model() {
        $item = self::$client->transitPassModel();
        self::assertIsObject( $item );
    }

    /** Test: Model TransitPassInstance. */
    public function test_transit_pass_instance() {
        $item = self::$client->transitPassInstance();
        self::assertIsObject( $item );
    }
}
