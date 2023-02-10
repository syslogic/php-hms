<?php
namespace Tests;

use HMS\AccountKit\AccountKit;
use HMS\AccountKit\TokenInfo;

/**
 * HMS AccountKit Test
 *
 * @author Martin Zeitler
 */
class AccountKitTest extends BaseTestCase {

    private static ?AccountKit $client;
    private static ?string $app_access_token = null;
    private static ?string $user_access_token = null;
    private static ?string $id_token = null;
    private static string $user_access_token_path = '../.credentials/huawei_token.json';

    private const PARSE_ACCESS_TOKEN = 'PARSE_ACCESS_TOKEN has failed.';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        parent::setUpBeforeClass();
        self::$client = new AccountKit( self::get_config() );
        self::$app_access_token = self::$client->get_access_token();
        self::assertNotNull( self::$app_access_token, self::CLIENT_NOT_READY );

        if (file_exists(self::$user_access_token_path)) {
            $data = json_decode(file_get_contents(self::$user_access_token_path));

            self::$user_access_token = $data->access_token;
            self::assertNotNull( self::$user_access_token, self::CLIENT_NOT_READY );

            self::$id_token = $data->id_token;
            self::assertNotNull( self::$id_token, self::CLIENT_NOT_READY );

        } else {
            self::markTestSkipped('File not found: ' . self::$user_access_token_path);
        }
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
     * Obtain User Information.
     * oAuth2 Error -> Not rights for this app token, Pls use user token.
     */
    public function test_get_user_info() {
        if (file_exists(self::$user_access_token_path)) {
            $data = json_decode(file_get_contents(self::$user_access_token_path));
            self::$user_access_token = $data->access_token;
            $result = self::$client->get_user_info( self::$user_access_token );
            self::assertTrue( property_exists($result, 'access_token') );
        } else {
            $this->markTestSkipped('File not found: ' . self::$user_access_token_path);
        }
    }

    /** Verify an ID Token. */
    public function test_verify_id_token() {
        if (file_exists(self::$user_access_token_path)) {
            $data = json_decode(file_get_contents(self::$user_access_token_path));
            self::$id_token = $data->id_token;
            $result = self::$client->verify_id_token( self::$id_token );
            self::assertTrue( $result->code == 200, 'verify_id_token: '.$result->message );
        } else {
            $this->markTestSkipped('File not found: ' . self::$user_access_token_path);
        }
    }
}
