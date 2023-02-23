<?php
namespace Tests;

use HMS\AppGallery\Project\Project;

/**
 * HMS AppGallery Connect Project API Test
 *
 * @author Martin Zeitler
 */
class AgcProjectTest extends BaseTestCase {

    private static ?Project $client;
    private static int $team_id = 0;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::load_user_access_token();
        self::$debug_mode = true;

        self::$client = new Project( [
            'package_name'     => self::$package_name,
            'access_token'     => self::$user_access_token,
            'debug_mode'       => self::$debug_mode
        ] );
    }

    /** Test: Team Account List. */
    public function test_team_list() {
        $result = self::$client->team_list();
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
        self::assertTrue( property_exists($result, 'teams' ) && is_array($result->teams) );
        self::$developer_id = $result->teams[0]->id;
        self::$team_id = $result->teams[0]->id;
        echo print_r($result->teams, true);
    }

    /** Test: Obtaining App Brief Information. */
    public function test_app_brief_info() {
        $result = self::$client->app_brief_info( self::$team_id, self::$package_name );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }

    /** Test: Obtaining the Configuration File. */
    public function test_app_config_file() {
        $result = self::$client->app_config_file( self::$team_id, self::$agc_app_client_id );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }

    /** Test: Adding a Certificate Fingerprint. */
    public function test_add_certificate_fingerprint() {
        $result = self::$client->add_certificate_fingerprint( self::$team_id, self::$developer_id, self::$agc_app_client_id );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }

    /** Test: Querying the Certificate Fingerprint and App Secret. */
    public function test_get_certificate_fingerprint() {
        $result = self::$client->get_certificate_fingerprint( self::$team_id, self::$developer_id, self::$agc_app_client_id );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }

    /** Test: Querying Service Enabling Status. */
    public function test_service_status() {
        $result = self::$client->service_status( self::$project_id, self::$agc_app_client_id );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }

    /** Test: Querying Project Details and Apps Under the Project. */
    public function test_project_details() {
        $result = self::$client->project_details( self::$project_id );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }

    /** Test: Querying the Project List. */
    public function test_project_list() {
        $result = self::$client->project_list( self::$team_id );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }
}
