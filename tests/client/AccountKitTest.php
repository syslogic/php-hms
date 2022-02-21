<?php
namespace Tests\client;

use HMS\AccountKit\AccountKit;
use HMS\AccountKit\IdTokenInfo;
use HMS\AccountKit\TokenInfo;
use HMS\AccountKit\UserInfo;
use JetBrains\PhpStorm\ArrayShape;
use Tests\BaseTestCase;

/**
 * HMS AccountKit Test
 *
 * @author Martin Zeitler
 */
class AccountKitTest extends BaseTestCase {

    private static AccountKit|null $client;
    private static string|null $app_access_token;
    private static string|null $user_access_token;
    private static string|null $id_token = '...';

    private const PARSE_ACCESS_TOKEN  = 'PARSE_ACCESS_TOKEN has failed.';
    private const VERIFY_ID_TOKEN     = 'VERIFY_ID_TOKEN has failed.';
    private const GET_USER_INFO       = 'GET_USER_INFO has failed.';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        parent::setUpBeforeClass();

        self::$client = new AccountKit( self::get_secret() );
        self::$app_access_token = self::$client->get_access_token();
        self::assertNotNull( self::$app_access_token, self::CLIENT_NOT_READY );

        self::$user_access_token = self::$app_access_token; // this is obviously wrong.
        self::assertNotNull( self::$user_access_token, self::CLIENT_NOT_READY );
    }

    #[ArrayShape(['client_id' => "int", 'client_secret' => "string"])]
    protected static function get_secret(): array {
        return ['client_id' => self::$app_id, 'client_secret' => self::$app_secret];
    }

    /** Test: Obtaining Access Token. */
    public function test_get_access_token() {
        self::$app_access_token = self::$client->get_access_token();
        self::assertNotNull( self::$app_access_token, self::CLIENT_NOT_READY );
    }

    /** Parse an Access Token. */
    public function test_parse_access_token() {
        $result = self::$client->parse_access_token( self::$app_access_token );
        self::assertTrue( $result instanceof TokenInfo, self::PARSE_ACCESS_TOKEN );
        self::assertTrue( $result->validate(), self::PARSE_ACCESS_TOKEN );
    }

    /**
     * TODO: Obtain User Information.
     * oAuth2 Error -> Not rights for this app token,Pls use user token.
     */
    public function test_get_user_info() {
        $result = self::$client->get_user_info( self::$user_access_token );
        self::assertTrue( $result instanceof UserInfo, self::GET_USER_INFO );
    }

    /** TODO: Verify an ID Token. */
    public function test_verify_id_token() {
        $result = self::$client->verify_id_token( self::$id_token );
        self::assertTrue( $result instanceof IdTokenInfo, self::VERIFY_ID_TOKEN );
    }
}
