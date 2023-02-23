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
            'project_id'             => self::$project_id,
            'oauth2_client_id'       => self::$oauth2_client_id,
            'agc_team_client_id'     => self::$agc_team_client_id,
            'agc_team_client_secret' => self::$agc_team_client_secret,
            'access_token'           => self::$user_access_token,
            'debug_mode'             => self::$debug_mode
        ] );
    }

    /** Test: Team Account List. */
    public function test_team_list() {
        $result = self::$client->team_list();
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
        self::assertTrue( property_exists($result, 'teams' ) && is_array($result->teams) );
        self::$team_id = $result->teams[0]->id;
        echo print_r($result->teams, true);
    }

    /** Test: Obtaining App Brief Information. */
    public function test_app_brief_info() {
        $result = self::$client->app_brief_info( self::$team_id );
        self::assertTrue( property_exists( $result, 'code' ) && $result->code == 0, $result->message );
    }
}
