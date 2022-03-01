<?php
namespace Tests\client;

use HMS\LocationKit\LocationKit;
use Tests\BaseTestCase;

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
        self::$client = new LocationKit( self::get_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Dummy. */
    public function test_dummy() {
        self::assertTrue( true );
    }
}
