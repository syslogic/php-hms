<?php
namespace Tests;

use HMS\Connect\AppInfo;
use HMS\Connect\AppLanguageInfo;
use HMS\Connect\Connect;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * HMS AppGallery Connect Test
 *
 * @author Martin Zeitler
 */
class ConnectTest extends TestCase {

    private static Connect|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new Connect( [
            'client_id'     => (int)    getenv('HUAWEI_CLIENT_ID'),
            'client_secret' => (string) getenv('HUAWEI_CLIENT_SECRET')
        ] );
        self::assertTrue( self::$client->is_ready(), 'The client is not ready.');
    }

    /** Test: oAuth2 Token Refresh. */
    public function test_on_submission_callback() {
        try {
            self::assertTrue(self::$client->on_submission_callback());
        } catch (InvalidArgumentException $e) {
            self::assertTrue( $e instanceof InvalidArgumentException);
        }
    }

    /** Test: Model AppInfo. */
    public function test_app_info() {
        $item = new AppInfo();
        self::assertTrue( is_array($item->asArray()) );
    }

    /** Test: Model AppInfo. */
    public function test_app_language_info() {
        $item = new AppLanguageInfo();
        self::assertTrue( is_array($item->asArray()) );
    }
}
