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

    protected static int $agc_client_id = 0;
    protected static string|null $agc_client_key = null;

    private const ENV_VAR_CONNECT_API_CLIENT_ID   = 'Variable HUAWEI_CONNECT_API_CLIENT_ID is not set.';
    private const ENV_VAR_CONNECT_API_CLIENT_KEY  = 'Variable HUAWEI_CONNECT_API_CLIENT_KEY is not set.';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::$agc_client_id = (int) getenv('HUAWEI_CONNECT_API_CLIENT_ID');
        self::assertTrue(is_int(self::$client_id), self::ENV_VAR_CONNECT_API_CLIENT_ID);

        self::$agc_client_key = getenv('HUAWEI_CONNECT_API_CLIENT_KEY');
        self::assertTrue(is_string(self::$client_secret), self::ENV_VAR_CONNECT_API_CLIENT_KEY);

        self::$connect = new Connect( self::get_secret() );
        if ( self::$connect->is_ready() ) {
            self::$client = new AuthService( self::get_secret() );
        }
    }

    #[ArrayShape(['client_id' => "int", 'client_secret' => "string"])]
    protected static function get_secret(): array {
        return ['client_id' => self::$agc_client_id, 'client_secret' => self::$agc_client_key];
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
        self::assertTrue($result->code !== ResultCodes::SUCCESS );
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
