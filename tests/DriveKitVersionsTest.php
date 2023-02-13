<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace Tests;

use HMS\DriveKit\DriveKit;

/**
 * HMS DriveKit / History Versions Test
 *
 * @author Martin Zeitler
 */
class DriveKitVersionsTest extends BaseTestCase {

    /** @var DriveKit|null $client */
    private static ?DriveKit $client;
    protected static string $version_id = '';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new DriveKit( self::get_user_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Comments:list */
    public function test_list() {
        $result = self::$client->getHistoryVersions()->list( self::$file_id );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#historyVersionList' );
        self::assertTrue( property_exists($result, 'historyVersions' ) && is_array($result->historyVersions) );
        self::$version_id = $result->historyVersions[0]->id;
        echo print_r($result, true);
    }

    /** Test: Comments:get */
    public function test_get() {
        $result = self::$client->getHistoryVersions()->get( self::$file_id, self::$version_id );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#historyVersion' );
        self::assertTrue( property_exists($result, 'editedTime' ) && is_string($result->editedTime) );
        self::assertTrue( property_exists($result, 'mimeType' ) && is_string($result->mimeType) );
        self::assertTrue( property_exists($result, 'id' ) );
        echo print_r($result, true);
    }

    /** Test: Comments:update */
    public function test_update() {
        $result = self::$client->getHistoryVersions()->update( self::$file_id, self::$version_id );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#historyVersion' );
        self::assertTrue( property_exists($result, 'editedTime' ) && is_string($result->editedTime) );
        self::assertTrue( property_exists($result, 'mimeType' ) && is_string($result->mimeType) );
        self::assertTrue( property_exists($result, 'id' ) );
        echo print_r($result, true);
    }

    /** Test: Comments:delete */
    public function test_delete() {
        $result = self::$client ->getHistoryVersions()->delete( self::$file_id, self::$version_id );
        self::assertTrue( $result );
    }

    /** TearDown After Class */
    public static function tearDownAfterClass(): void {
        parent::tearDownAfterClass();
        $result = self::$client->getHistoryVersions()->list( self::$file_id );
        if (sizeof($result->historyVersions) > 0) {
            foreach ($result->historyVersions as $version) {
                self::$client->getHistoryVersions()->delete( self::$file_id, $version->id );
            }
        }
    }
}
