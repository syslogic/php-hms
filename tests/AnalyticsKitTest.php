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
    private static ?string $test_aaid = 'test';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new AnalyticsKit( array_merge( self::get_user_config(), [
            'oauth2_client_id' => self::$oauth2_client_id,
            'package_name' => self::$package_name,
            'product_id' => self::$product_id,
            'debug_mode' => true
        ]) );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Exporting Personal Data. */
    public function test_user_data_export() {
        $result = self::$client->request_user_data_export( self::$test_aaid );
        self::assertTrue(property_exists($result, 'code'));
        //HTTP 400 + Error 10031: user data exported in two month.
        self::assertTrue(  in_array($result->code, [0, 400]) );
    }

    /** Test: Querying the Export Task Status. */
    public function test_user_data_export_status() {
        $result = self::$client->request_user_data_export_status( self::$test_aaid );
        self::assertTrue( property_exists($result, 'code') && $result->code === ResultCodes::REQUEST_SUCCESSFUL, "Error $result->code -> $result->message" );
        self::assertTrue( property_exists($result, 'task_list') && is_array($result->task_list));
        echo print_r($result->task_list, true);
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
    public function test_receive_raw_data_export_status() {
        $result = self::$client->receive_raw_data_export_status();
        // self::assertTrue( property_exists($result, 'code') && $result->code === ResultCodes::REQUEST_SUCCESSFUL, "Error $result->code -> $result->message" );
        self::assertTrue( property_exists($result, 'task_list') && is_array($result->task_list));
        echo print_r($result->task_list, true);
    }

    private function get_user_set( string $id, string $name, string $value ): \stdClass {
        $prop = new \stdClass();
        $prop->id = $id;
        $prop->properties = new \stdClass();
        $prop->properties->id = $name;
        $prop->properties->value = "$value";
        return $prop;
    }

    private function get_item_set( string $id, string $type, string $name ): \stdClass {
        $prop = new \stdClass();
        $prop->id = $id;
        $prop->type = $type;
        $prop->name = $name;
        return $prop;
    }

    private function get_event_set( string $aaid, string $request_id, string $event_session, string $event_id, string $timestamp ): \stdClass {
        $prop = new \stdClass();
        $prop->aaid = $aaid;
        $prop->requestId = $request_id;
        $prop->eventSessionName = $event_session;
        $prop->eventId = $event_id;
        $prop->eventTime = $timestamp;
        $prop->timestamp = $timestamp;
        return $prop;
    }

    /** Test: Importing Custom User Attributes. */
    public function test_data_collection_import_user() {
        $prop1 = $this->get_user_set( "1", "vip_user", "true" );
        $prop2 = $this->get_user_set( "2", "favorite_sport", "football" );
        $result = self::$client->data_collection_import_user( [ $prop1, $prop2 ] );
        self::assertTrue(property_exists($result, 'code') && $result->code == 0);
    }

    /** Test: Importing Content. */
    public function test_data_collection_import_item() {
        $prop1 = $this->get_item_set( "1", "item", "cat" );
        $prop2 = $this->get_item_set( "2", "item", "dog" );
        $result = self::$client->data_collection_import_item( [ $prop1, $prop2 ] );
        self::assertTrue(property_exists($result, 'code') && $result->code == 0);
    }

    /** TODO Test: Reporting User Behavior. */
    public function test_data_collection_import_event() {
        $prop1 = $this->get_event_set( self::$test_aaid, "1", "1","1", "" . time() );
        $prop2 = $this->get_event_set( self::$test_aaid,"2", "1", "2", "" . time() );
        $result = self::$client->data_collection_import_event( [ $prop1, $prop2 ] );
        self::assertTrue(property_exists($result, 'code') && $result->code == 0);
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
        $result = self::$client->query_dimensions("x", "y" );
        self::assertTrue(property_exists($result, 'code'));
    }

    /** TODO Test: Querying Statistical Metrics. */
    public function test_query_metrics() {
        $result = self::$client->query_metrics("x", ["y"], null, null, null, null, 'en', 10);
        self::assertTrue(property_exists($result, 'code'));
    }
}
