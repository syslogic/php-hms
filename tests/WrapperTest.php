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
    public function test_token_refresh_v1() {
        self::$client = new Wrapper( self::get_secret(), 1 );
        self::assertTrue( self::$client->is_ready(), "The client is not ready; endpoint v1." );
    }

    /** Test: oAuth2 Token Refresh. */
    public function test_token_refresh_v2() {
        self::$client = new Wrapper( self::get_secret(), 2 );
        self::assertTrue( self::$client->is_ready(), "The client is not ready; endpoint v2." );
    }

    /** Test: oAuth2 Token Refresh. */
    public function test_token_refresh_v3() {
        self::$client = new Wrapper( self::get_secret(), 3 );
        self::assertTrue( self::$client->is_ready(), "The client is not ready; endpoint v3." );
    }
}
