<?php /** @noinspection PhpUnusedPrivateFieldInspection */
namespace Tests;

use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Framework\TestCase;

/**
 * HMS Abstract Base TestCase
 *
 * @author Martin Zeitler
 */
abstract class BaseTestCase extends TestCase {

    protected static int $oauth2_client_id = 0;                // OAuth2 client.
    protected static string|null $oauth2_client_secret = null; // OAuth2 client.

    protected static int $agc_client_id = 0;                   // AGConnect API.
    protected static string|null $agc_client_secret = null;    // AGConnect API.

    protected static string|null $api_key = null;              // MapKit in general.
    protected static string|null $signature_key = null;        // Maps Static API.
    protected static string|null $package_name = null;
    protected static int $project_id = 0;
    protected static int $product_id = 0;
    protected static int $cp_id = 0;

    /** AppGallery Connect Gateway URL */
    protected static string|null $agc_gateway         = 'https://connect-drcn.dbankcloud.cn/';
    private const ENV_VAR_OAUTH2_CLIENT_ID            = 'Variable HUAWEI_OAUTH2_CLIENT_ID is not set.';
    private const ENV_VAR_OAUTH2_CLIENT_SECRET        = 'Variable HUAWEI_OAUTH2_CLIENT_SECRET is not set.';
    protected const ENV_VAR_CONNECT_API_CLIENT_ID     = 'Variable HUAWEI_CONNECT_API_CLIENT_ID is not set.';
    protected const ENV_VAR_CONNECT_API_CLIENT_SECRET = 'Variable HUAWEI_CONNECT_API_CLIENT_SECRET is not set.';
    protected const ENV_VAR_CONNECT_PRODUCT_ID        = 'Variable HUAWEI_CONNECT_PRODUCT_ID is not set.';
    protected const ENV_VAR_MAPKIT_API_KEY            = 'Variable HUAWEI_MAPKIT_API_KEY is not set.';
    protected const ENV_VAR_HCM_TEST_DEVICE_TOKEN     = 'Variable PHPUNIT_HCM_TEST_DEVICE_TOKEN is not set.';
    protected const CLIENT_NOT_READY                  = 'The API client is not ready.';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        self::$oauth2_client_id = getenv('HUAWEI_OAUTH2_CLIENT_ID');
        self::assertTrue( is_int(self::$oauth2_client_id) && self::$oauth2_client_id > 0, self::ENV_VAR_OAUTH2_CLIENT_ID );

        self::$oauth2_client_secret = getenv('HUAWEI_OAUTH2_CLIENT_SECRET');
        self::assertNotEmpty( self::$oauth2_client_secret, self::ENV_VAR_OAUTH2_CLIENT_SECRET );

        self::$api_key = getenv('HUAWEI_MAPKIT_API_KEY');
        self::assertNotEmpty( self::$api_key, self::ENV_VAR_MAPKIT_API_KEY );

        self::$agc_client_id = (int) getenv('HUAWEI_CONNECT_API_CLIENT_ID');
        self::assertTrue( is_int(self::$agc_client_id) && self::$agc_client_id > 0, self::ENV_VAR_CONNECT_API_CLIENT_ID );

        self::$agc_client_secret = getenv('HUAWEI_CONNECT_API_CLIENT_SECRET');
        self::assertNotEmpty( self::$agc_client_secret, self::ENV_VAR_CONNECT_API_CLIENT_SECRET );

        self::$product_id = getenv('HUAWEI_CONNECT_PRODUCT_ID');
        self::assertTrue( is_int(self::$product_id) && self::$product_id > 0, self::ENV_VAR_CONNECT_PRODUCT_ID );
    }

    /** It provides the configuration array. */
    #[ArrayShape([
        'oauth2_client_id'     => 'integer',
        'oauth2_client_secret' => 'string',
        'api_key'              => 'string',
        'agc_client_id'        => 'integer',
        'agc_client_secret'    => 'string',
        'product_id'           => 'integer',
        'debug_mode'           => 'bool'
    ])]
    protected static function get_config(): array {
        return [
            'oauth2_client_id'     => self::$oauth2_client_id,
            'oauth2_client_secret' => self::$oauth2_client_secret,
            'api_key'              => self::$api_key,
            'agc_client_id'        => self::$agc_client_id,
            'agc_client_secret'    => self::$agc_client_secret,
            'product_id'           => self::$product_id,
            'debug_mode'           => true
        ];
    }
}
