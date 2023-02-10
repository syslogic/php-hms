<?php
namespace Tests;

use HMS\LocationKit\LocationKit;

/**
 * HMS LocationKit Test: Skipped.
 *
 * @author Martin Zeitler
 */
class LocationKitTest extends BaseTestCase {

    private static ?LocationKit $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new LocationKit( [ 'access_token' => '' ] );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Skipped. */
    public function test_skipped() {
        self::markTestSkipped( "Huawei LocationKit uses OAuth2 flow -> www/locationkit.php." );
    }
}
