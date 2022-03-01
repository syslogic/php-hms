<?php
namespace Tests\client;

use HMS\AppGallery\Connect\AuthService;
use HMS\AppGallery\Connect\Connect;
use HMS\AppGallery\Connect\ImportUser;
use HMS\AppGallery\Connect\ResultCodes;
use JetBrains\PhpStorm\ArrayShape;
use Tests\BaseTestCase;

/**
 * HMS AppGallery AuthService Test
 *
 * @author Martin Zeitler
 */
class AppGalleryConnectTest extends BaseTestCase {

    private static Connect|null $connect;
    private static AuthService|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::$connect = new Connect( self::get_config() );
        if ( self::$connect->is_ready() ) {
            self::$client = new AuthService( self::get_config() );
        }
    }

    /** Test: Importing Users. */
    public function test_import_users() {
        $data = [
            ImportUser::fromArray( ['importUid' => 'W4Z34934F34dH93265R96'] )->asArray(),
            ImportUser::fromArray( ['importUid' => 'W4Z34934F34dH93265R97'] )->asArray(),
            ImportUser::fromArray( ['importUid' => 'W4Z34934F34dH93265R98'] )->asArray()
        ];

        $result = self::$client->import_users( $data );
        // self::assertFalse($result->code === ResultCodes::AUTHENTICATION_FAILED_CLIENT_TOKEN );
        self::assertNotFalse( $result );
    }

    /** Test: Exporting Users. */
    public function test_export_users() {
        $result = self::$client->export_users();
        self::assertFalse( $result ); // TODO...
    }

    /** Test: Authenticating a User's Access Token. */
    public function test_verify_access_token() {
        $result = self::$client->verify_access_token();
        self::assertFalse( $result ); // TODO...
    }

    /** Test: Revoking a User's Access Token. */
    public function test_revoke_access_token() {
        $result = self::$client->revoke_access_token();
        self::assertFalse( $result ); // TODO...
    }


    /** Test: Model ImportUser. */
    public function test_import_user() {
        $item = new ImportUser( [

        ] );
        self::assertTrue( is_array( $item->asArray() ) );
        self::assertTrue( $item->validate() );
    }
}
