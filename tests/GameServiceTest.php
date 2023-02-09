<?php
namespace Tests;

use HMS\GameService\GameService;

/**
 * HMS GameService Test
 *
 * @author Martin Zeitler
 */
class GameServiceTest extends BaseTestCase {

    private static ?GameService $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new GameService( self::get_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Dummy. */
    public function test_parse_delivery_notification() {
        $result = self::$client->parse_delivery_notification("{}");
        self::assertTrue( is_object($result) );
    }

    /** Test: Dummy. */
    public function test_send_delivery_success_notification() {
        $result = self::$client->send_delivery_success_notification("", "", "", 0);
        self::assertTrue( $result->code == 200 );
    }
}
