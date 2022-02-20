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

    protected static string|null $package_name = null;
    protected static string|null $client_secret = null;
    protected static string|null $app_secret = null;
    protected static string|null $api_key = null;
    protected static int $project_id = 0;
    protected static int $product_id = 0;
    protected static int $client_id = 0;
    protected static int $app_id = 0;
    protected static int $cp_id = 0;

    /** AppGallery Connect Gateway URL */
    protected static string|null $agc_gateway = 'https://connect-drcn.dbankcloud.cn/';

    private const ENV_VAR_APP_ID      = 'Variable HUAWEI_APP_ID is not set.';
    private const ENV_VAR_APP_SECRET  = 'Variable HUAWEI_APP_SECRET is not set.';
    protected const CLIENT_NOT_READY  = 'The REST API client is not ready.';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        self::$app_id =  getenv('HUAWEI_APP_ID');
        self::assertTrue(is_int(self::$app_id), self::ENV_VAR_APP_ID);

        self::$app_secret = getenv('HUAWEI_APP_SECRET'); // this value is not contained in the JSON.
        self::assertTrue(is_string(self::$app_secret), self::ENV_VAR_APP_SECRET);
    }

    #[ArrayShape(['client_id' => "int", 'client_secret' => "string"])]
    protected static function get_secret(): array {
        return [
            'client_id' => self::$app_id,
            'client_secret' => self::$app_secret
        ];
    }
}
