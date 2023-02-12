<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace Tests;

use HMS\DriveKit\DriveKit;

/**
 * HMS DriveKit Test: Skipped.
 *
 * @author Martin Zeitler
 */
class DriveKitFilesTest extends BaseTestCase {

    /** @var DriveKit|null $client */
    private static ?DriveKit $client;

    protected static string $folder_name = 'phpunit_test';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        parent::load_user_access_token();
        self::$client = new DriveKit( [ 'access_token' => self::$user_access_token ] );
    }

    /** Test: Files:about */
    public function test_about() {
        $result = self::$client ->getFiles()->getAbout()->get();
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#about' );
        self::assertTrue( property_exists($result, 'storageQuota' ) && is_object($result->storageQuota ) );
        self::assertTrue( property_exists($result, 'user' ) && is_object($result->user ));
        echo print_r($result, true);
    }

    /** Test: Files:list */
    public function test_list() {
        $result = self::$client ->getFiles()->list();
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#fileList' );
        self::assertTrue( property_exists($result, 'files' ));
        self::assertTrue( is_array($result->files) );
        echo print_r($result, true);
    }

    public function test_create_folder() {
        $result = self::$client ->getFiles()->create_folder( self::$folder_name );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#file' );
        self::assertTrue( property_exists($result, 'mimeType' ));
        self::assertTrue( property_exists($result, 'id' ));
        echo print_r($result, true);
    }
}
