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
        $filtering = new stdClass();
        $filtering->currency = 'USD';
        $result = self::$client->publisher_report( '2020-01-01','2022-12-31', $filtering, 'STAT_BREAK_DOWNS_APP_ID', 'STAT_TIME_GRANULARITY_DAILY', 1, 10, 'earnings', 'DESC' );
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
        self::assertTrue( property_exists($result, 'code') && $result->code == 0 );
        self::assertTrue( property_exists($result, 'data') && is_object($result->data) );
        self::assertTrue( property_exists($result->data, 'page_info') && is_object($result->data->page_info) );
        self::assertTrue( property_exists($result->data, 'list') && is_array($result->data->list) );
    }
}
