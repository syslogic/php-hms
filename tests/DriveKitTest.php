<?php
namespace Tests;

use HMS\DriveKit\DriveKit;

/**
 * HMS DriveKit Test
 *
 * @author Martin Zeitler
 */
class DriveKitTest extends BaseTestCase {

    private static DriveKit|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new DriveKit( self::get_secret() );
    }

    /** Test: oAuth2 Token Refresh. */
    public function test_ready() {
        self::assertTrue( self::$client->is_ready(), 'The client is not ready.');
    }
}