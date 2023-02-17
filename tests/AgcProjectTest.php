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

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$debug_mode = true;
        self::$client = new Project( [
            'project_id'                => self::$project_id,
            'oauth2_client_id'          => self::$oauth2_client_id,
            'agc_team_client_id'        => self::$agc_team_client_id,
            'agc_team_client_secret'    => self::$agc_team_client_secret,
            'agc_project_client_id'     => self::$agc_project_client_id,
            'agc_project_client_secret' => self::$agc_project_client_secret,
            'agc_app_client_id'         => self::$agc_app_client_id,
            'agc_app_client_secret'     => self::$agc_app_client_secret,
            'debug_mode'                => self::$debug_mode
        ] );
    }

    /** Test: Team Account List. */
    public function test_team_list() {
        $result = self::$client->team_list();
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }
}
