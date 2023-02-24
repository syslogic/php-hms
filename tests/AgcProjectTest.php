<?php
namespace Tests;

use HMS\AppGallery\Constants;
use HMS\AppGallery\Project\Project;

/**
 * HMS AppGallery Connect Project API Test
 *
 * @author Martin Zeitler
 */
class AgcProjectTest extends BaseTestCase {

    private static ?Project $client;

    /** Android debug keystore SHA-265 fingerprint */
    private static string $key_fingerprint = '09:3F:65:B3:A8:FB:8E:B3:6D:90:E9:A8:CA:AC:29:72:AF:70:4F:47:1E:CE:5A:3A:9F:EF:F6:8E:EC:20:16:D3';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::load_user_access_token();
        self::$client = new Project( [
            'base_url'     => Constants::CONNECT_API_BASE_URL_EU,
            'access_token' => self::$user_access_token,
            'developer_id' => self::$developer_id,
            'package_name' => self::$package_name,
            'debug_mode'   => self::$debug_mode
        ] );
    }

    /** Test: Team Account List. */
    public function test_team_list() {
        $result = self::$client->team_list();
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
        self::assertTrue( property_exists($result, 'teams' ) && is_array($result->teams) );
        self::assertTrue( self::$developer_id == $result->teams[0]->id );
        echo print_r($result->teams, true);
    }

    /** Test: Obtaining App Brief Information. */
    public function test_app_brief_info() {
        $result = self::$client->app_brief_info( self::$developer_id, self::$package_name );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }

    /** Test: Obtaining the Configuration File. */
    public function test_app_config_file() {
        $result = self::$client->app_config_file( self::$developer_id, self::$agc_app_client_id );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }

    /** Test: Adding a Certificate Fingerprint. */
    public function test_add_certificate_fingerprint() {
        $result = self::$client->add_certificate_fingerprint( self::$developer_id, self::$developer_id, self::$agc_app_client_id, self::$key_fingerprint );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }

    /** Test: Querying the Certificate Fingerprint and App Secret. */
    public function test_get_certificate_fingerprint() {
        $result = self::$client->get_certificate_fingerprint( self::$developer_id, self::$developer_id, self::$agc_app_client_id );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }

    /** Test: Querying Service Enabling Status. */
    public function test_service_status() {
        $result = self::$client->service_status( self::$project_id, self::$agc_app_client_id );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }

    /** Test: Querying Project Details and Apps Under the Project. */
    public function test_project_details() {
        $result = self::$client->project_details( self::$project_id, true );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }

    /** Test: Querying the Project List. */
    public function test_project_list() {
        $result = self::$client->project_list( self::$developer_id );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }
}
