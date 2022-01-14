<?php
namespace Tests;

use HMS\HiAnalytics\HiAnalytics;

/**
 * HMS HiAnalytics Test
 *
 * @author Martin Zeitler
 */
class HiAnalyticsTest extends BaseTestCase {

    private static HiAnalytics|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new HiAnalytics( self::get_secret() );
    }

    /** Test: oAuth2 Token Refresh. */
    public function test_ready() {
        self::assertTrue( self::$client->is_ready(), 'The client is not ready.');
    }
}
