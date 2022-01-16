<?php
namespace Tests;

use HMS\AnalyticsKit\AnalyticsKit;
use HMS\AnalyticsKit\ResultCodes;
use stdClass;

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
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Exporting Personal Data. */
    public function test_user_data_export() {
        $aaid = 'test';
        $result = self::$client->request_user_data_export( $aaid );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::DATA_EXPORT_REQUEST_INTERVAL, "Error $result->code: $result->message" ); // user data exported in two month
    }

    /** Test: Querying the Export Task Status. */
    public function test_user_data_export_status() {
        $aaid = 'test';
        $result = self::$client->request_user_data_export_status( $aaid );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::REQUEST_SUCCESSFUL, "Error $result->code: $result->message" );
    }

    /** Test: Deleting Personal Data. */
    public function test_user_data_deletion() {
        $aaid = 'test';
        $result = self::$client->request_user_data_deletion( $aaid );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::REQUEST_SUCCESSFUL, "Error $result->code: $result->message" );
    }

    /** Test: Querying the Deletion Task Status. */
    public function test_user_data_deletion_status() {
        $aaid = 'test';
        $result = self::$client->request_user_data_deletion_status( $aaid );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::REQUEST_SUCCESSFUL, "Error $result->code: $result->message" );
    }

    /** Test: Creating a Data Export Task. */

    /** Test: Receiving the Execution Status of a Data Export Task. */

    /** Test: Importing Custom User Attributes. */

    /** Test: Importing Content. */

    /** Test: Reporting User Behavior. */

    /** Test: Querying Open Metrics and Dimensions. */
    public function test_query_metrics_and_dimensions() {
        $result = self::$client->query_metrics_and_dimensions( 'en', 10,  1 );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::REQUEST_SUCCESSFUL, "Error $result->code: $result->message" );
    }

    /** Test: Querying Dimension Values. */

    /** Test: Querying Statistical Metrics. */
}
