<?php
namespace Tests;

use HMS\AppGallery\Connect\AuthService;
use HMS\AppGallery\Connect\Connect;
use HMS\AppGallery\Connect\ImportUser;
use HMS\AppGallery\Connect\ResultCodes;

/**
 * HMS AppGallery AuthService Test
 *
 * @author Martin Zeitler
 */
class AppGalleryConnectTest extends BaseTestCase {

    private static Connect|null $connect;
    private static AuthService|null $client;

    private static string $test_token = 'xyz';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::$connect = new Connect( self::get_config() );
        self::assertNotFalse( self::$connect->is_ready() );

        self::$client = new AuthService( self::get_config() );
        self::assertNotFalse( self::$client->is_ready() );
    }

    /** Test: Importing Users. */
    public function test_import_users() {
        $data = [
            ImportUser::fromArray( [
                'importUid' => 'W4Z34934F34dH93265R91'
            ] )->asArray(),
            ImportUser::fromArray( [
                'importUid' => 'W4Z34934F34dH93265R92'
            ] )->asArray(),
            ImportUser::fromArray( [
                'importUid' => 'W4Z34934F34dH93265R93'
            ] )->asArray()
        ];

        $result = self::$client->import_users( $data );
        self::assertFalse($result->code === ResultCodes::AUTHENTICATION_FAILED_CLIENT_TOKEN, $result->message );
    }

    /** Test: Exporting Users. */
    public function test_export_users() {
        $result = self::$client->export_users();
        self::assertTrue( $result->code != 401, $result->message );
    }

    /** Test: Authenticating a User's Access Token. */
    public function test_verify_access_token() {
        $result = self::$client->verify_access_token( self::$test_token );
        self::assertTrue( $result->code == 404 );
    }

    /** Test: Revoking a User's Access Token. */
    public function test_revoke_access_token() {
        $result = self::$client->revoke_access_token( self::$test_token );
        self::assertTrue( $result->code != 401, $result->message );
    }


    /** Test: Model ImportUser. */
    public function test_import_user() {
        $item = new ImportUser( [

        ] );
        self::assertTrue( is_array( $item->asArray() ) );
        self::assertTrue( $item->validate() );
    }
}
