<?php
namespace Tests;

use HMS\AppGallery\Connect\Connect;
use HMS\AppGallery\Publishing\AppInfo;
use HMS\AppGallery\Publishing\AppLanguageInfo;
use HMS\AppGallery\Publishing\Publishing;
use InvalidArgumentException;

/**
 * HMS AgConnect Publishing API Test
 *
 * @author Martin Zeitler
 */
class AppGalleryPublishingTest extends BaseTestCase {

    private static Connect|null $connect;
    private static Publishing|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::$connect = new Connect( self::get_config() );
        if ( self::$connect->is_ready() ) {
            self::$client = new Publishing( self::get_config() );
        }
    }

    /** Test: On Release Submission Callback. */
    public function test_on_submission_callback() {
        try {
            self::assertTrue(self::$client->on_submission_callback());
        } catch (InvalidArgumentException $e) {
            self::assertTrue( $e instanceof InvalidArgumentException);
        }
    }

    /** Test: Model AppInfo. */
    public function test_app_info() {
        $item = new AppInfo( [

        ] );
        self::assertTrue( is_array( $item->asArray() ) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model AppInfo. */
    public function test_app_language_info() {
        $item = new AppLanguageInfo( [

        ] );
        self::assertTrue( is_array( $item->asArray() ) );
        self::assertTrue( $item->validate() );
    }
}
