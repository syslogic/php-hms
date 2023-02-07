<?php
namespace Tests;

use HMS\AccountKit\AccountKit;
use HMS\AccountKit\IdTokenInfo;
use HMS\AccountKit\TokenInfo;
use HMS\AccountKit\UserInfo;

/**
 * HMS AccountKit Test
 *
 * @author Martin Zeitler
 */
class AccountKitTest extends BaseTestCase {

    private static ?AccountKit $client;
    private static ?string $app_access_token;
    private static ?string $user_access_token;
    private static ?string $id_token = '';
    private static string $user_access_token_path = '../../.credentials/huawei_token.json';
    private static string $id_token_path = '../../.credentials/id_token.json';

    private const PARSE_ACCESS_TOKEN = 'PARSE_ACCESS_TOKEN has failed.';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        parent::setUpBeforeClass();

        self::$client = new AccountKit( self::get_config() );
        self::$app_access_token = self::$client->get_access_token();
        self::assertNotNull( self::$app_access_token, self::CLIENT_NOT_READY );

        self::$user_access_token = ''; // this is obviously wrong.
        self::assertNotNull( self::$user_access_token, self::CLIENT_NOT_READY );
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
        if (file_exists(self::$user_access_token_path)) {
            self::$user_access_token = json_decode(file_get_contents(self::$user_access_token_path));
            $result = self::$client->get_user_info( self::$user_access_token );
            self::assertTrue( $result instanceof UserInfo, 'UserInfo: '.$result->error );
        } else {
            $this->markTestSkipped('File not found: ' . self::$user_access_token_path);
        }
    }

    /** TODO: Verify an ID Token. */
    public function test_verify_id_token() {
        if (file_exists(self::$id_token_path)) {
            self::$id_token = json_decode(file_get_contents(self::$id_token_path));
            $result = self::$client->verify_id_token( self::$id_token );
            self::assertTrue( $result instanceof IdTokenInfo, 'IdTokenInfo: '.$result->error );
        } else {
            $this->markTestSkipped('File not found: ' . self::$id_token_path);
        }
    }
}
