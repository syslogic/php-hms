<?php
namespace Tests\client;

use HMS\AppGallery\Connect\AuthService;
use HMS\AppGallery\Connect\Connect;
use HMS\AppGallery\Connect\ImportUser;
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
        self::$connect = new Connect( self::get_secret() );
        $access_token = self::$connect->get_access_token();

        self::$client = new AuthService( self::get_secret() );
    }

    #[ArrayShape(['client_id' => "int", 'client_secret' => "string"])]
    protected static function get_secret(): array {
        $client_id  = getenv('HUAWEI_CONNECT_API_CLIENT_ID');
        $client_key = getenv('HUAWEI_CONNECT_API_CLIENT_KEY');
        return ['client_id' => $client_id, 'client_secret' => $client_key];
    }

    /** Test: Importing Users. */
    public function test_import_users() {
        $data = [
            ImportUser::fromArray( ['importUid' => 'W4Z34934F34dH93265R96'] )->asArray(),
            ImportUser::fromArray( ['importUid' => 'W4Z34934F34dH93265R97'] )->asArray(),
            ImportUser::fromArray( ['importUid' => 'W4Z34934F34dH93265R98'] )->asArray()
        ];
        $result = self::$client->import_users( $data );
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
