<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace Tests;

use HMS\DriveKit\DriveKit;

/**
 * HMS DriveKit / About Test
 *
 * @author Martin Zeitler
 */
class DriveKitAboutTest extends BaseTestCase {

    /** @var DriveKit|null $client */
    private static ?DriveKit $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new DriveKit( self::get_user_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: About:get */
    public function test_get() {
        $result = self::$client->getAbout()->get();
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#about' );
        self::assertTrue( property_exists($result, 'storageQuota' ) && is_object($result->storageQuota ) );
        self::assertTrue( property_exists($result, 'user' ) && is_object($result->user ));
        $result->storageQuota->usedSpace = self::format_filesize($result->storageQuota->usedSpace);
        $result->storageQuota->userCapacity = self::format_filesize($result->storageQuota->userCapacity);
        $result->maxFileUploadSize = self::format_filesize($result->maxFileUploadSize);
        $result->maxThumbnailSize = self::format_filesize($result->maxThumbnailSize);
        echo print_r($result, true);
    }
}
