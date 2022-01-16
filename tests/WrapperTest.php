<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace Tests;

use HMS\Core\Config;
use HMS\Core\Wrapper;

/**
 * HMS Wrapper Test
 *
 * @author Martin Zeitler
 */
class WrapperTest extends BaseTestCase {

    private static Wrapper|null $client;
    private static Config|null $config;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
    }

    /** Test: oAuth2 Token Refresh. */
    public function test_token_refresh_v2() {
        self::$client = new Wrapper( self::get_secret(), 2 );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: oAuth2 Token Refresh. */
    public function test_token_refresh_v3() {
        self::$client = new Wrapper( self::get_secret(), 3 );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Load Config from file agconnect-services.json. */
    public function test_config() {
        self::$config = new Config( null );
        self::assertTrue( self::$config->get_app_id() > 0, self::CONFIG_NOT_LOADED );
    }
}
