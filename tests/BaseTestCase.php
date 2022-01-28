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

    private const ENV_VAR_APPLICATION_CREDENTIALS = 'Variable HUAWEI_APPLICATION_CREDENTIALS is not set.';
    private const ENV_VAR_APP_SECRET  = 'Variable HUAWEI_APP_SECRET is not set.';
    protected const CONFIG_NOT_LOADED = 'agconnect-services.json was not loaded.';
    protected const CLIENT_NOT_READY  = 'The REST API client is not ready.';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        self::$app_secret = getenv('HUAWEI_APP_SECRET'); // this value is not contained in the JSON.
        self::assertTrue(is_string(self::$app_secret), self::ENV_VAR_APP_SECRET);

        self::assertTrue(is_string(getenv('HUAWEI_APPLICATION_CREDENTIALS')), self::ENV_VAR_APPLICATION_CREDENTIALS);
        $config_file = getenv('HUAWEI_APPLICATION_CREDENTIALS');
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
                if ( property_exists( $config, 'agcgw' ) && is_object( $config->agcgw )) {
                    self::$agc_gateway   =     (string) 'https://'.$config->agcgw->url.'/';
                }
            }
        }
    }

    #[ArrayShape(['client_id' => "int", 'client_secret' => "string"])]
    protected static function get_secret_from_file(): array {
        $config_file = './oauth2-config.json';
        if ( file_exists( $config_file ) ) {
            $config = json_decode(file_get_contents( $config_file ));
                if (
                    is_object( $config ) &&
                    property_exists( $config, 'client_id' ) &&
                    property_exists( $config, 'client_secret' )
                ) {
                    self::$app_id     =    (int) $config->client_id;
                    self::$app_secret = (string) $config->client_secret;
                    return self::get_secret();
                }
        }
        return [];
    }


    #[ArrayShape(['client_id' => "int", 'client_secret' => "string"])]
    protected static function get_secret(): array {
        return ['client_id' => self::$app_id, 'client_secret' => self::$app_secret];
    }
}
