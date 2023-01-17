<?php
namespace Tests;

use HMS\DriveKit\DriveKit;

/**
 * HMS DriveKit Test
 *
 * @author Martin Zeitler
 */
class DriveKitTest extends BaseTestCase {

    private static DriveKit|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new DriveKit( self::get_config() );
        // self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: About */
    public function test_about_get() {
        $result = self::$client->getAbout()->get('*');
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
    }

    /** Test: Files */
    public function test_files_get() {
        $result = self::$client->getFiles()->get('*');
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
    }

    /** Test: Changes */
    public function test_changes_start_cursor() {
        $result = self::$client->getChanges()->getStartCursor();
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
    }
}
