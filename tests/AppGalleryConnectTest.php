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
    private static string $user_uid = '123';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new AuthService( [
            'product_id'        => self::$product_id,
            'agc_client_id'     => self::$agc_client_id,
            'agc_client_secret' => self::$agc_client_secret,
            'base_url'          => Constants::CONNECT_API_BASE_URL,
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
                'createTime' => time() * 1000,
                'providerUid'=> '1',
                'providers' => [ Constants::AUTH_PROVIDER_ANONYMOUS ]
            ] )->asArray(),
            ImportUser::fromArray( [
                'importUid' => uniqid('hms_'),
                'createTime' => time() * 1000,
                'providerUid'=> '2',
                'providers' => [ Constants::AUTH_PROVIDER_ANONYMOUS ]
            ] )->asArray(),
            ImportUser::fromArray( [
                'importUid' => uniqid('hms_'),
                'createTime' => time() * 1000,
                'providerUid'=> '3',
                'providers' => [ Constants::AUTH_PROVIDER_ANONYMOUS ]
            ] )->asArray()
        ];

        $result = self::$client->import_users( $data );
        self::assertTrue($result->code == 0, $result->message );
    }

    /** Test: Exporting Users. */
    public function test_export_users() {
        $result = self::$client->export_users();
        self::assertTrue( $result->code == 0, $result->message );
    }

    /** Test: Authenticating a User's Access Token. */
    public function test_verify_access_token() {
        $result = self::$client->verify_access_token( self::$user_access_token );
        self::assertTrue( $result->code == 0, $result->message );
    }

    /** Test: Revoking a User's Access Token. */
    public function test_revoke_access_token() {
        $result = self::$client->revoke_access_token( self::$user_uid, self::$user_access_token );
        self::assertTrue( $result->code == 0, $result->message );
    }

    /** Test: Model ImportUser. */
    public function test_model_import_user() {
        $item = new ImportUser( [
            'importUid' => 'W4Z34934F34dH93265R91'
        ] );
        self::assertTrue( is_array( $item->asArray() ) );
        self::assertTrue( $item->validate() );
    }
}
