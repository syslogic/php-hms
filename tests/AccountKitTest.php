<?php
namespace Tests;

use HMS\AccountKit\AccountKit;
use HMS\AccountKit\Model\IdTokenInfo;
use HMS\AccountKit\Model\TokenInfo;
use HMS\AccountKit\Model\TokenRequest;
use HMS\AccountKit\Model\UserInfo;

/**
 * HMS AccountKit Test
 *
 * @author Martin Zeitler
 */
class AccountKitTest extends BaseTestCase {

    private static ?AccountKit $client;
    private static ?string $app_access_token = null;
    private static string $user_access_token_path = '../.credentials/huawei_token.json';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        parent::setUpBeforeClass();
        self::$client = new AccountKit( self::get_config() );
        self::$app_access_token = self::$client->get_access_token();
        self::assertNotNull( self::$app_access_token, self::CLIENT_NOT_READY );

        if (file_exists(self::$user_access_token_path)) {
            $data = json_decode(file_get_contents(self::$user_access_token_path));
            self::assertNotNull( $data, 'Failed to parse JSON: ' . self::$user_access_token_path);
            self::$user_access_token = $data->access_token;
            self::assertNotNull( self::$user_access_token, self::CLIENT_NOT_READY );
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
        self::assertTrue( property_exists($result, 'access_token') );
        echo print_r($result, true);
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
            self::assertTrue( property_exists($result, 'openID') );
            self::assertTrue( property_exists($result, 'displayName') );
            self::assertTrue( property_exists($result, 'displayNameFlag') );
            self::assertTrue( property_exists($result, 'headPictureURL') );
            echo print_r($result, true);
        } else {
            $this->markTestSkipped('File not found: ' . self::$user_access_token_path);
        }
    }

    /** Verify an ID Token. */
    public function test_verify_id_token() {
        if (file_exists(self::$user_access_token_path)) {
            $data = json_decode(file_get_contents(self::$user_access_token_path));
            $result = self::$client->verify_id_token( $data->id_token );
            $data = $result->asObject();
            self::assertTrue( property_exists($data, 'typ') && $data->typ == 'JWT' );
            self::assertTrue( property_exists($data, 'alg') && $data->alg == 'RS256' );
            echo print_r($data, true);
        } else {
            $this->markTestSkipped('File not found: ' . self::$user_access_token_path);
        }
    }

    /** Test: Model IdTokenInfo. */
    public function test_model_id_token_info() {
        $item = new IdTokenInfo([ ]);
        self::assertTrue( is_object( $item ) );
    }

    /** Test: Model TokenInfo. */
    public function test_model_token_info() {
        $item = new TokenInfo([ ]);
        self::assertTrue( is_object( $item ) );
    }

    /** Test: Model TokenRequest. */
    public function test_model_token_request() {
        $item = new TokenRequest([ ]);
        self::assertTrue( is_object( $item ) );
    }

    /** Test: Model UserInfo. */
    public function test_model_user_info() {
        $item = new UserInfo([ ]);
        self::assertTrue( is_object( $item ) );
    }
}
