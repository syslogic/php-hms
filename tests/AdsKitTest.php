<?php
namespace Tests;

use HMS\AdsKit\AdsKit;

/**
 * HMS AdsKit Test
 *
 * @author Martin Zeitler
 */
class AdsKitTest extends BaseTestCase {

    private static ?AdsKit $client;
    private const CURRENCIES = ['EUR', 'CNY', 'USD'];
    private const START_DATE = '2022-01-01';
    private const END_DATE = '2022-12-31';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new AdsKit( self::get_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Publisher Report  */
    public function test_publisher_report() {
        $filtering = new \stdClass();
        foreach (self::CURRENCIES as $currency) {
            $filtering->currency = $currency;
            $result = self::$client->publisher_report( self::START_DATE,self::END_DATE, $filtering );
            self::assertTrue( property_exists($result, 'data') && is_object($result->data) );
            self::assertTrue( property_exists($result->data, 'page_info') && is_object($result->data->page_info) );
            self::assertTrue( property_exists($result->data, 'list') && is_array($result->data->list) );
            echo print_r($result->data, true);
        }
    }
}
