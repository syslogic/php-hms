<?php
namespace Tests;

use HMS\AnalyticsKit\AnalyticsKit;
use HMS\AnalyticsKit\ResultCodes;

/**
 * HMS AnalyticsKit Test
 *
 * @author Martin Zeitler
 */
class AnalyticsKitTest extends BaseTestCase {

    private static ?AnalyticsKit $client;
    private static ?string $test_aaid = null;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        parent::setUpBeforeClass();

        self::$client = new AnalyticsKit( self::get_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Exporting Personal Data. */
    public function test_user_data_export() {
        $result = self::$client->request_user_data_export( self::$test_aaid );
        self::assertTrue(property_exists($result, 'code'));
        //Error 10031: user data exported in two month
        self::assertTrue( $result->code === ResultCodes::DATA_EXPORT_REQUEST_INTERVAL, "Error $result->code -> $result->message" ); // user data exported in two month
    }

    /** Test: Querying the Export Task Status. */
    public function test_user_data_export_status() {
        $result = self::$client->request_user_data_export_status( self::$test_aaid );
        self::assertTrue(property_exists($result, 'code'));
        self::assertTrue( $result->code === ResultCodes::REQUEST_SUCCESSFUL, "Error $result->code -> $result->message" );
    }

    /** Test: Deleting Personal Data. */
    public function test_user_data_deletion() {
        $result = self::$client->request_user_data_deletion( self::$test_aaid );
        self::assertTrue(property_exists($result, 'code'));
        // Error 10002: Request frequency exceeds system limit!
        self::assertTrue( $result->code === ResultCodes::REQUEST_SUCCESSFUL, "Error $result->code -> $result->message" );
    }

    /** Test: Querying the Deletion Task Status. */
    public function test_user_data_deletion_status() {
        $result = self::$client->request_user_data_deletion_status( self::$test_aaid );
        self::assertTrue(property_exists($result, 'code'));
        // Error 10002: Request frequency exceeds system limit!
        self::assertTrue( $result->code === ResultCodes::REQUEST_SUCCESSFUL, "Error $result->code -> $result->message" );
    }

    /** Test: Creating a Data Export Task. */
    public function test_raw_data_export() {
        $result = self::$client->request_raw_data_export( self::$test_aaid );
        self::assertTrue(property_exists($result, 'code'));
        // Error 10031: user data exported in two month
        self::assertTrue( $result->code === ResultCodes::DATA_EXPORT_REQUEST_INTERVAL, "Error $result->code -> $result->message" );
    }

    /** TODO Test: Receiving the Execution Status of a Data Export Task; post-back. */
    public function test_raw_data_export_status() {

        self::assertTrue( true );
    }

    /** TODO Test: Importing Custom User Attributes. */
    public function test_data_collection_import_user() {

        self::assertTrue( true );
    }

    /** TODO Test: Importing Content. */
    public function test_data_collection_import_item() {

        self::assertTrue( true );
    }

    /** TODO Test: Reporting User Behavior. */
    public function test_data_collection_import_event() {

        self::assertTrue( true );
    }

    /** Test: Querying Open Metrics and Dimensions. */
    public function test_query_metrics_and_dimensions() {
        $result = self::$client->query_metrics_and_dimensions( 'en', 10,  1 );
        self::assertTrue(property_exists($result, 'code'));
        // Error 10020: importItem4DataCollection.importItem.itemSet: must not be null, importItem4DataCollection.importItem.dataType: must not be null
        self::assertTrue( $result->code === ResultCodes::REQUEST_SUCCESSFUL, "Error $result->code: $result->message" );
    }

    /** TODO Test: Querying Dimension Values. */
    public function test_query_dimensions() {

        self::assertTrue( true );
    }

    /** TODO Test: Querying Statistical Metrics. */
    public function test_query_metrics() {

        self::assertTrue( true );
    }
}
