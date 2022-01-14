<?php
namespace Tests;

use HMS\LocationKit\LocationKit;

/**
 * HMS LocationKit Test
 *
 * @author Martin Zeitler
 */
class LocationKitTest extends BaseTestCase {

    private static LocationKit|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new LocationKit( self::get_secret() );
        self::assertTrue( self::$client->is_ready(), 'The client is not ready.' );
    }

    /** Test: Dummy. */
    public function test_dummy() {
        self::assertTrue( true );
    }
}
