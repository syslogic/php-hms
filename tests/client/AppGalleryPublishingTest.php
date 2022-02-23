<?php
namespace Tests\client;

use HMS\AppGallery\Connect\Connect;
use HMS\AppGallery\Publishing\Publishing;
use HMS\AppGallery\Publishing\AppInfo;
use HMS\AppGallery\Publishing\AppLanguageInfo;
use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use Tests\BaseTestCase;

/**
 * HMS AgConnect Publishing API Test
 *
 * @author Martin Zeitler
 */
class AppGalleryPublishingTest extends BaseTestCase {

    private static Connect|null $connect;
    private static Publishing|null $client;

    protected static int $agc_client_id = 0;
    protected static string|null $agc_client_key = null;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::$agc_client_id = (int) getenv('HUAWEI_CONNECT_API_CLIENT_ID');
        self::assertTrue(is_int(self::$client_id), self::ENV_VAR_CONNECT_API_CLIENT_ID);

        self::$agc_client_key = getenv('HUAWEI_CONNECT_API_CLIENT_KEY');
        self::assertTrue(is_string(self::$client_secret), self::ENV_VAR_CONNECT_API_CLIENT_KEY);

        self::$connect = new Connect( self::get_secret() );
        if ( self::$connect->is_ready() ) {
            self::$client = new Publishing( self::get_secret() );
        }
    }

    #[ArrayShape(['client_id' => "int", 'client_secret' => "string"])]
    protected static function get_secret(): array {
        return ['client_id' => self::$agc_client_id, 'client_secret' => self::$agc_client_key];
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
