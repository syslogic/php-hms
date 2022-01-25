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

    private const PHP_FPM_CLEAR_ENV = 'PHP configuration clear_env does what it says.';
    private const ENV_VAR_APPLICATION_CREDENTIALS = 'Variable HUAWEI_APPLICATION_CREDENTIALS is not set.';
    private const ENV_VAR_APP_SECRET  = 'Variable HUAWEI_APP_SECRET is not set.';
    protected const CONFIG_NOT_LOADED = 'agconnect-services.json was not loaded.';
    protected const CLIENT_NOT_READY  = 'The client is not ready.';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        self::assertFalse(ini_get('clear_env'), self::PHP_FPM_CLEAR_ENV);

        self::assertTrue(is_string(getenv('HUAWEI_APPLICATION_CREDENTIALS')), self::ENV_VAR_APPLICATION_CREDENTIALS);
        $config_file = getenv('HUAWEI_APPLICATION_CREDENTIALS');

        self::assertTrue(is_string(getenv('HUAWEI_APP_SECRET')), self::ENV_VAR_APP_SECRET);
        self::$app_secret = getenv('HUAWEI_APP_SECRET'); // this value is not contained in the JSON.

        if ( file_exists( $config_file ) ) {
            $config = json_decode(file_get_contents( $config_file ));
            if ( is_object( $config )) {
                if ( property_exists( $config, 'client' ) && is_object( $config->client )) {
                    self::$cp_id         =     (int) $config->client->cp_id;
                    self::$app_id        =    (int) $config->client->app_id;
                    self::$package_name  = (string) $config->client->package_name;
                    self::$project_id    =    (int) $config->client->project_id;
                    self::$product_id    =    (int) $config->client->product_id;
                    self::$client_id     =    (int) $config->client->client_id;
                    self::$client_secret = (string) $config->client->client_secret;
                    self::$api_key       = (string) $config->client->api_key;
                }
            }
        }
    }

    #[ArrayShape(['client_id' => "int", 'client_secret' => "string"])]
    protected static function get_secret(): array {
        return ['client_id' => self::$app_id, 'client_secret' => self::$app_secret];
    }
}
