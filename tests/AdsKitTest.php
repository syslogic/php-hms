<?php
namespace Tests;

use HMS\AdsKit\AdsKit;
use stdClass;

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
        self::$client = new AdsKit( self::get_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Dummy. */
    public function test_publisher_report() {
        $start_date = '2022-01-01';
        $end_date = '2022-12-31';
        $filtering = new stdClass();
        $filtering->currency = 'EUR';
        $result = self::$client->publisher_report( $start_date, $end_date, $filtering, 'STAT_BREAK_DOWNS_APP_ID', 'STAT_TIME_GRANULARITY_DAILY' );
        self::assertTrue( true );
    }
}
