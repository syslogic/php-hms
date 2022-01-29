<?php
namespace Tests\client;

use HMS\AppGallery\Publishing\Publishing;
use HMS\AppGallery\Publishing\AppInfo;
use HMS\AppGallery\Publishing\AppLanguageInfo;
use InvalidArgumentException;
use Tests\BaseTestCase;

/**
 * HMS AgConnect Publishing API Test
 *
 * @author Martin Zeitler
 */
class ConnectPublishingTest extends BaseTestCase {

    private static Publishing|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new Publishing( self::get_secret() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
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
