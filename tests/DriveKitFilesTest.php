<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace Tests;

use HMS\DriveKit\Constants;
use HMS\DriveKit\DriveKit;

/**
 * HMS DriveKit Test: Skipped.
 *
 * @author Martin Zeitler
 */
class DriveKitFilesTest extends BaseTestCase {

    /** @var DriveKit|null $client */
    private static ?DriveKit $client;
    protected static string $upload_file_name = 'build/mapkit_01.png';
    protected static string $test_folder_name = 'phpunit_test';
    protected static array $test_created_ids = [];

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new DriveKit( self::get_user_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
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
        self::assertTrue( property_exists($result, 'files' ) && is_array($result->files));
        if (sizeof($result->files) == 0) {self::markTestSkipped('empty directory listing');}
        echo print_r($result, true);
    }

    /** Test: Files:delete */
    public function test_delete_folders() {
        $result = self::$client->getFiles()->list();
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#fileList' );
        self::assertTrue( property_exists($result, 'files' ) && is_array($result->files) );
        if (sizeof($result->files) == 0) {
            self::markTestSkipped('Empty directory listing.');
        } else {
            $files = [];
            foreach ($result->files as $file) {
                if (
                    $file->mimeType == Constants::DRIVE_KIT_MIME_TYPE_FOLDER &&
                    str_starts_with($file->fileName, self::$test_folder_name)
                ) {
                    echo "Deleting $file->fileName -> $file->id.\n";
                    $files[] = $file->id;
                }
            }
            if (sizeof($files) == 0) {
                self::markTestSkipped('No files with mime-type ' . Constants::DRIVE_KIT_MIME_TYPE_FOLDER . ' found.');
            } else {
                $result = self::$client->getFiles()->delete($files);
                self::assertTrue($result);
            }
        }
    }

    /** Test: Files:create */
    public function test_create_folder() {
        $result = self::$client ->getFiles()->create_folder( self::$test_folder_name );
        if (property_exists($result, 'code' ) && $result->code == 403) {
            self::markTestSkipped($result->message);
        }
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#file' );
        self::assertTrue( property_exists($result, 'mimeType' ));
        self::assertTrue( property_exists($result, 'id' ));
        self::$test_created_ids[] = $result->id;
        echo print_r($result, true);
    }

    public function test_create_folder_structure() {
        $result = self::$client ->getFiles()->create_folder_structure( [
            self::$test_folder_name => [
                'test1',
                'test2',
                'test3',
                'test4' => [
                    'test5',
                    'test6'
                ]
            ]
        ] );
        self::assertTrue( is_array($result) );
        foreach ($result as $file) {
            self::assertTrue( property_exists($file, 'category' ) && $file->category == 'drive#file' );
            self::assertTrue( property_exists($file, 'mimeType' ));
            self::assertTrue( property_exists($file, 'id' ));
            self::$test_created_ids[] = $file->id;
        }
        echo print_r($result, true);
    }

    /** Test: Files:create.content */
    public function test_create_content() {
        $result = self::$client ->getFiles()->create_content( self::$upload_file_name );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#file' );
        self::assertTrue( property_exists($result, 'mimeType') && $result->mimeType == 'image/png' );
        self::assertTrue( property_exists($result, 'riskFile') && !$result->riskFile );
        self::assertTrue( property_exists($result, 'id' ));
        self::$test_created_ids[] = $result->id;
        echo print_r($result, true);
    }

    /**
     * TearDown After Class: Deleting all the created IDs.
     * @link self::$test_created_ids.
     */
    public static function tearDownAfterClass(): void {
        parent::tearDownAfterClass();
        if (sizeof(self::$test_created_ids) > 0) {
            self::$client ->getFiles()->delete( self::$test_created_ids );
        }
    }
}
