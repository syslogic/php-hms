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
        self::$client = new Project( [
            'project_id'                => self::$project_id,
            'agc_team_client_id'        => self::$agc_team_client_id,
            'agc_team_client_secret'    => self::$agc_team_client_secret,
            'agc_project_client_id'     => self::$agc_project_client_id,
            'agc_project_client_secret' => self::$agc_project_client_secret,
            'debug_mode'                => self::$debug_mode
        ] );
    }

    /** Test: Dummy. */
    public function test_dummy() {
        self::assertTrue( true );
    }
}
