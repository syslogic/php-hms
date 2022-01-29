<?php
namespace Tests\client;

use HMS\AccountKit\AccountKit;
use Tests\BaseTestCase;

/**
 * HMS AccountKit Test
 *
 * @author Martin Zeitler
 */
class AccountKitTest extends BaseTestCase {

    private static AccountKit|null $client;
    private static string|null $access_token;

    private const PARSE_ACCESS_TOKEN  = 'PARSE_ACCESS_TOKEN has failed.';
    private const VERIFY_ID_TOKEN     = 'VERIFY_ID_TOKEN has failed.';
    private const GET_USER_INFO       = 'GET_USER_INFO has failed.';

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

    /**
     * TODO: Parse an Access Token.
     */
    public function test_parse_access_token() {
        self::$access_token = self::$client->get_access_token();
        self::assertNotNull( self::$access_token, self::CLIENT_NOT_READY );
        self::assertTrue( self::$client->parse_access_token( self::$access_token ), self::PARSE_ACCESS_TOKEN );
    }

    /**
     * TODO: Obtain User Information.
     */
    public function test_get_user_info() {
        self::$access_token = self::$client->get_access_token();
        self::assertNotNull( self::$access_token, self::CLIENT_NOT_READY );

        self::assertNull( self::$client->get_user_info( self::$access_token ), self::GET_USER_INFO );
    }

    /**
     * TODO: Verify an ID Token.
     */
    public function test_verify_id_token() {
        self::$access_token = self::$client->get_access_token();
        self::assertNotNull( self::$access_token, self::CLIENT_NOT_READY );

        $id_token = '...';
        self::assertTrue( self::$client->verify_id_token( $id_token ), self::VERIFY_ID_TOKEN );
    }

}
