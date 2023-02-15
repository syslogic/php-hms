<?php
namespace Tests;

use HMS\AppGallery\Connect\AuthService;
use HMS\AppGallery\Connect\ImportUser;
use HMS\AppGallery\Constants;

/**
 * HMS AppGallery AuthService Test
 *
 * @author Martin Zeitler
 */
class AppGalleryConnectTest extends BaseTestCase {

    private static ?AuthService $client;
    private static string $user_uid = '980624363634103296';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new AuthService( [
            'project_id'        => self::$project_id,
            'agc_client_id'     => self::$agc_client_id,
            'agc_client_secret' => self::$agc_client_secret,
            'base_url'          => Constants::CONNECT_API_BASE_URL_EU, // must match the default data storage location.
            'debug_mode'        => true
        ] );
        self::assertNotFalse( self::$client->is_ready() );
        self::load_user_access_token();
    }

    /** Test: Importing Users. */
    public function test_import_users() {
        $data = [
            ImportUser::fromArray( [
                'importUid' => uniqid('hms_'),
                'displayName' => 'PHPUnit User 01',
                'createTime' => time() * 1000,
                'providers' => [ (object) [
                    "provider" => 0,
                    "providerUid" => 9903824860586577776
                ]]
            ] )->asArray(),
            ImportUser::fromArray( [
                'importUid' => uniqid('hms_'),
                'displayName' => 'PHPUnit User 02',
                'createTime' => time() * 1000,
                'providers' => [ (object) [
                    "provider" => 0,
                    "providerUid" => 9903824860586577777
                ]]
            ] )->asArray()
        ];

        $result = self::$client->import_users( $data );
        self::assertTrue($result->code == 0, $result->message );
    }

    /** Test: Exporting Users. */
    public function test_export_users() {
        $result = self::$client->export_users();
        self::assertTrue( property_exists($result, 'totalBlock' ) && is_int($result->totalBlock) );
        self::assertTrue( property_exists($result, 'users' ) && is_array($result->users) );
        echo print_r($result->users, true);
    }

    /** Test: Authenticating a User's Access Token. */
    public function test_verify_access_token() {
        $result = self::$client->verify_access_token( self::$user_access_token );
        self::assertTrue( $result->code == 0, $result->message );
        echo print_r($result, true);
    }

    /** Test: Revoking a User's Access Token. */
    public function test_revoke_access_token() {
        $result = self::$client->revoke_access_token( self::$user_uid, self::$user_access_token );
        self::assertTrue( $result->code == 0, $result->message );
        echo print_r($result, true);
    }

    /** Test: Model ImportUser. */
    public function test_model_import_user() {
        $item = new ImportUser( [
            'importUid' => uniqid('hms_'),
            'displayName' => 'PHPUnit User',
            'createTime' => time() * 1000,
            'lastLoginTime' => time() * 1000,
            'emailVerified' => false,
            'providers' => [(object) [
                "provider" => "0",
                "providerUid" => "9903824860586577777",
                "photoUrl" => "https://weixin.qq.com/xxx.png",
                "displayName" => "HelloWorld",
                "openId" => "123456"
            ]]
        ] );
        self::assertTrue( is_array( $item->asArray() ) );
        self::assertTrue( $item->validate() );
    }
}
