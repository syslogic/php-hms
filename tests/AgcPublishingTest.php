<?php
namespace Tests;

use HMS\AppGallery\Model\AppInfo;
use HMS\AppGallery\Model\AppLanguageInfo;
use HMS\AppGallery\Publishing\Publishing;

/**
 * HMS AppGallery Connect Publishing API Test
 *
 * @author Martin Zeitler
 */
class AgcPublishingTest extends BaseTestCase {

    private static ?Publishing $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new Publishing( self::get_config() );
    }

    /** Test: On Release Submission Callback. */
    public function test_on_submission_callback() {
        try {
            self::assertTrue(self::$client->on_submission_callback());
        } catch (\InvalidArgumentException $e) {
            self::assertTrue( $e instanceof \InvalidArgumentException);
        }
    }

    /** Obtaining the File Upload URL */
    public function test_request_file_upload_url() {

    }

    /** Uploading a File */
    public function test_upload_file() {

    }

    /** Updating App File Information */
    public function test_update_file_info( $file_url, $file_size ) {

    }

    /** Test: Model AppInfo. */
    public function test_model_app_info() {
        $item = new AppInfo( [

        ] );
        self::assertTrue( is_array( $item->asArray() ) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model AppInfo. */
    public function test_model_app_language_info() {
        $item = new AppLanguageInfo( [

        ] );
        self::assertTrue( is_array( $item->asArray() ) );
        self::assertTrue( $item->validate() );
    }
}
