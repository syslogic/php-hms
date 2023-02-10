<?php
namespace Tests;

use HMS\SearchKit\SearchKit;

/**
 * HMS SearchKit Test: Skipped.
 *
 * @author Martin Zeitler
 */
class SearchKitTest extends BaseTestCase {

    private static ?SearchKit $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new SearchKit( [ 'access_token' => '' ] );
    }

    /** Test: Skipped. */
    public function test_skipped() {
        self::markTestSkipped( "Huawei SearchKit uses OAuth2 flow -> www/searchkit.php." );
    }
}
