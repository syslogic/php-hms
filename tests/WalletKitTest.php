<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace Tests;

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

    /** Test: Skipped. */
    public function test_skipped() {
        self::markTestSkipped( "WalletKit uses interactive OAuth2 flow -> www/walletkit.php." );
    }
}
