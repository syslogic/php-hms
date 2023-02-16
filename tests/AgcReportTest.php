<?php
namespace Tests;

use HMS\AppGallery\Report\Report;

/**
 * HMS AppGallery Connect Report API Test
 *
 * @author Martin Zeitler
 */
class AgcReportTest extends BaseTestCase {

    private static ?Report $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new Report( [
            'project_id'                => self::$project_id,
            'oauth2_client_id'          => self::$oauth2_client_id,
            'agc_team_client_id'        => self::$agc_team_client_id,
            'agc_team_client_secret'    => self::$agc_team_client_secret,
            'debug_mode'                => self::$debug_mode
        ] );
    }

    /** Test: Obtaining the Download and Installation Report. */
    public function test_download_and_installation_report() {
        $destination_path = self::$resource_path . 'download_and_installation.xlsx';
        $source_url = self::$client->download_and_installation_report('en-US', '20230101', '20230131', 'date', 'EXCEL');
        self::assertTrue( $source_url != null );
        self::$client->download( $source_url, $destination_path );
        self::assertTrue( file_exists($destination_path) && filesize($destination_path) > 0 );
    }

    /** Test: Obtaining the In-App Purchases Report. */
    public function test_in_app_purchases_report() {
        $destination_path = self::$resource_path . 'in_app_purchases.xlsx';
        $source_url = self::$client->in_app_purchases_report('en-US', '20230101', '20230131', 'date', 'EXCEL');
        self::assertTrue( $source_url != null );
        self::$client->download( $source_url, $destination_path );
        self::assertTrue( file_exists($destination_path) && filesize($destination_path) > 0 );
    }

    /** Test: Obtaining the Paid App Report. */
    public function test_paid_apps_report() {
        $destination_path = self::$resource_path . 'paid_apps.xlsx';
        $source_url = self::$client->paid_apps_report('en-US', '20230101', '20230131', 'date', 'EXCEL');
        self::assertTrue( $source_url != null );
        self::$client->download( $source_url, $destination_path );
        self::assertTrue( file_exists($destination_path) && filesize($destination_path) > 0 );
    }

    /** Test: Obtaining the Paid App Details Report. */
    public function test_paid_app_details_report() {
        $destination_path = self::$resource_path . 'paid_app_details.xlsx';
        $source_url = self::$client->paid_app_details_report('en-US', '20230101', '20230131', 0, 'EXCEL');
        self::assertTrue( $source_url != null );
        self::$client->download( $source_url, $destination_path );
        self::assertTrue( file_exists($destination_path) && filesize($destination_path) > 0 );
    }

    /** Test: Obtaining the Installation Failure Data Report. */
    public function test_installation_failure_report() {
        $destination_path = self::$resource_path . 'installation_failure.xlsx';
        $source_url = self::$client->installation_failure_report('en-US', '20230101', '20230131', 'date', 'EXCEL');
        self::assertTrue( $source_url != null );
        self::$client->download( $source_url, $destination_path );
        self::assertTrue( file_exists($destination_path) && filesize($destination_path) > 0 );
    }
}
