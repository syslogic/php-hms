<?php
namespace Tests;

use HMS\AccountKit\AccountKit;

/**
 * HMS AccountKit Test
 *
 * @author Martin Zeitler
 */
class AccountKitTest extends BaseTestCase {

    private static AccountKit|null $client;
    private static string|null $access_token;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new AccountKit( self::get_secret() );
    }

    /** Test: Obtaining Access Token. */
    public function test_get_access_token() {
        self::$access_token = self::$client->get_access_token();
        self::assertNotNull( self::$access_token, self::CLIENT_NOT_READY );
    }
}
