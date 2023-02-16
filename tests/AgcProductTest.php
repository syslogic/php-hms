<?php
namespace Tests;

use HMS\AppGallery\Product\Product;

/**
 * HMS AppGallery Connect Product API Test
 *
 * @author Martin Zeitler
 */
class AgcProductTest extends BaseTestCase {

    private static ?Product $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$debug_mode = true;
        self::$client = new Product([
            'project_id' => self::$project_id,
            'agc_team_client_id' => self::$agc_team_client_id,
            'agc_team_client_secret' => self::$agc_team_client_secret,
            'agc_project_client_id' => self::$agc_project_client_id,
            'agc_project_client_secret' => self::$agc_project_client_secret,
            'debug_mode' => self::$debug_mode
        ]);
        self::assertNotFalse(self::$client->is_ready());
    }
    /** Test: Dummy. */
    public function test_dummy() {
        self::assertTrue( true );
    }
}
