<?php
namespace Tests;

use HMS\Core\Wrapper;

/**
 * HMS Core Wrapper Test
 *
 * @author Martin Zeitler
 */
class WrapperTest extends BaseTestCase {

    private static Wrapper|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new Wrapper( self::get_secret(), 2 );
    }

    /** Test: oAuth2 Token Refresh. */
    public function test_ready() {
        self::assertTrue( self::$client->is_ready(), 'The client is not ready.');
    }
}
