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
        self::$client = new Report( self::get_config() );
    }

    /** Test: Dummy. */
    public function test_dummy() {
        self::assertTrue( true );
    }
}
