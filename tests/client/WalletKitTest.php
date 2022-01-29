<?php
namespace Tests\client;

use HMS\WalletKit\WalletKit;
use Tests\BaseTestCase;

/**
 * HMS WalletKit Test
 *
 * @author Martin Zeitler
 */
class WalletKitTest extends BaseTestCase {

    private static WalletKit|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new WalletKit( self::get_secret() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Dummy. */
    public function test_dummy() {
        self::assertTrue( true );
    }
}
