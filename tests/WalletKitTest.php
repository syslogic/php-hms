<?php
namespace Tests;

use HMS\WalletKit\WalletKit;

/**
 * HMS WalletKit Test: Skipped.
 *
 * @author Martin Zeitler
 */
class WalletKitTest extends BaseTestCase {

    private static ?WalletKit $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new WalletKit( [ 'access_token' => '' ] );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Skipped. */
    public function test_skipped() {
        self::markTestSkipped( "Huawei WalletKit uses OAuth2 flow -> www/walletkit.php." );
    }
}
