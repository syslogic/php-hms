<?php
namespace Tests;

use HMS\AdsKit\AdsKit;

/**
 * HMS AdsKit Test
 *
 * @author Martin Zeitler
 */
class AdsKitTest extends BaseTestCase {

    private static AdsKit|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new AdsKit( self::get_secret() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Dummy. */
    public function test_dummy() {
        self::assertTrue( true );
    }
}
