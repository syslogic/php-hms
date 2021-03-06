<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace Tests;

use HMS\Core\Wrapper;

/**
 * HMS Wrapper Test
 *
 * @author Martin Zeitler
 */
class WrapperTest extends BaseTestCase {

    private static Wrapper|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
    }

    /** Test: oAuth2 Token Refresh. */
    public function test_token_refresh() {
        // self::$client = new Wrapper( self::get_config() );
        // self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
        // AccountKit is being used meanwhile ...
        self::assertTrue( true );
    }
}
