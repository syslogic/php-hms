<?php
namespace Tests;

use HMS\GameService\GameService;

/**
 * HMS GameService Test
 *
 * @author Martin Zeitler
 */
class GameServiceTest extends BaseTestCase {

    private static GameService|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new GameService( self::get_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Dummy. */
    public function test_dummy() {
        self::assertTrue( true );
    }
}
