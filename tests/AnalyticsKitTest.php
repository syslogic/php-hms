<?php
namespace Tests;

use HMS\AnalyticsKit\AnalyticsKit;

/**
 * HMS AnalyticsKit Test
 *
 * @author Martin Zeitler
 */
class AnalyticsKitTest extends BaseTestCase {

    private static AnalyticsKit|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new AnalyticsKit( self::get_secret() );
        self::assertTrue( self::$client->is_ready(), 'The client is not ready.' );
    }

    /** Test: Dummy. */
    public function test_dummy() {
        self::assertTrue( true );
    }
}
