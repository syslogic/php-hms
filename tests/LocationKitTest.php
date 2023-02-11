<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace Tests;

use HMS\LocationKit\LocationKit;

/**
 * HMS LocationKit Test: Skipped.
 *
 * @author Martin Zeitler
 */
class LocationKitTest extends BaseTestCase {

    /** @var LocationKit|null $client */
    private static ?LocationKit $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new LocationKit( [ 'access_token' => '' ] );
    }

    /** Test: Skipped. */
    public function test_skipped() {
        self::markTestSkipped( "LocationKit uses an interactive OAuth2 flow -> www/locationkit.php." );
    }
}
