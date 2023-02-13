<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace Tests;

use HMS\DriveKit\DriveKit;

/**
 * HMS DriveKit / Changes Test
 *
 * @author Martin Zeitler
 */
class DriveKitChangesTest extends BaseTestCase {

    /** @var DriveKit|null $client */
    private static ?DriveKit $client;

    protected static ?string $start_cursor;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new DriveKit( self::get_user_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Changes:getStartCursor */
    public function test_cursor() {
        // Getting a start cursor
        $result = self::$client->getChanges()->cursor();
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#startCursor' );
        self::assertTrue( property_exists($result, 'startCursor' ) && is_string($result->startCursor) );
        self::$start_cursor = $result->startCursor;
    }

    /** Test: Changes:list */
    public function test_list() {
        self::assertTrue( is_string(self::$start_cursor) );
        $result = self::$client->getChanges()->list( self::$start_cursor );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#changeList' );
        self::assertTrue( property_exists($result, 'newStartCursor' ) && is_string($result->newStartCursor) );
        self::assertTrue( property_exists($result, 'changes' ) && is_array($result->changes ) );
        self::$start_cursor = $result->newStartCursor;
        echo print_r($result, true);
    }

    /** Test: Changes:subscribe */
    public function test_subscribe() {
        self::assertTrue( is_string(self::$start_cursor) );
        $notification_url = $_SERVER['HUAWEI_OAUTH2_REDIRECT_URL'].'notify_drivekit';
        $result = self::$client->getChanges()->subscribe( self::$start_cursor, 'test', $notification_url, 'xyz' );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'api#channel' );
        self::assertTrue( property_exists($result, 'resourceId' ) && is_string($result->resourceId) );
        echo print_r($result, true);
    }

}
