<?php
namespace Tests;

use HMS\Connect\AppInfo;
use HMS\Connect\AppLanguageInfo;
use HMS\Connect\Connect;
use InvalidArgumentException;

/**
 * HMS Connect Test
 *
 * @author Martin Zeitler
 */
class ConnectTest extends BaseTestCase {

    private static Connect|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new Connect( self::get_secret() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
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
