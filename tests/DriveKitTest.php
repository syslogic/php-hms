<?php
namespace Tests;

use HMS\DriveKit\DriveKit;

/**
 * HMS DriveKit Test: Skipped.
 *
 * @author Martin Zeitler
 */
class DriveKitTest extends BaseTestCase {

    /** @var DriveKit|null */
    private static ?DriveKit $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new DriveKit( [ 'access_token' => '' ] );
    }

    /** Test: Skipped. */
    public function test_skipped() {
        self::markTestSkipped( "Huawei DriveKit uses OAuth2 flow -> www/drivekit.php." );
    }
}
