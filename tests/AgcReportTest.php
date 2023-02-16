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
