<?php
namespace Tests\client;

use HMS\AppGallery\AuthService\AuthService;
use HMS\AppGallery\AuthService\ImportUser;
use Tests\BaseTestCase;

/**
 * HMS AppGallery AuthService Test
 *
 * @author Martin Zeitler
 */
class ConnectAuthServiceTest extends BaseTestCase {

    private static AuthService|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new AuthService( self::get_secret() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Importing Users. */
    public function test_import_users() {
        $data = [
            ImportUser::fromArray( ['importUid' => 'W4Z34934F34dH93265R96'] )->asArray(),
            ImportUser::fromArray( ['importUid' => 'W4Z34934F34dH93265R97'] )->asArray(),
            ImportUser::fromArray( ['importUid' => 'W4Z34934F34dH93265R98'] )->asArray()
        ];
        self::$client->import_users( $data );
    }

    /** Test: Exporting Users. */
    public function test_export_users() {
        self::$client->export_users();
    }

    /** Test: Authenticating a User's Access Token. */
    public function test_verify_access_token() {
        self::$client->verify_access_token();
    }

    /** Test: Revoking a User's Access Token. */
    public function test_revoke_access_token() {
        self::$client->revoke_access_token();
    }


    /** Test: Model ImportUser. */
    public function test_import_user() {
        $item = new ImportUser( [

        ] );
        self::assertTrue( is_array( $item->asArray() ) );
        self::assertTrue( $item->validate() );
    }
}
