<?php /** @noinspection PhpUnusedPrivateFieldInspection */
namespace Tests;

use HMS\AccountKit\AccountKit;
use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Framework\TestCase;

/**
 * HMS Abstract Base TestCase
 *
 * @author Martin Zeitler
 */
abstract class BaseTestCase extends TestCase {
    protected static bool $debug_mode = false;

    protected static int $oauth2_client_id = 0;            // OAuth2 client.
    protected static ?string $oauth2_client_secret = null; // OAuth2 client.
    protected static ?string $oauth2_token_path = '../.credentials/huawei_token.json';
    protected static string $build_path;

    protected static string $file_id = 'BvxJfT7Kem5FYvkii109M6LZgf2idmpqR';

    protected static ?string $user_access_token = null;
    protected static int $agc_client_id = 0;               // AGConnect API.
    protected static ?string $agc_client_secret = null;    // AGConnect API.

    protected static ?string $api_key = null;              // MapKit in general.
    protected static ?string $signature_key = null;        // Maps Static API.
    protected static ?string $package_name = null;
    protected static int $project_id = 0;
    protected static int $product_id = 0;
    protected static int $cp_id = 0;

    /** AppGallery Connect Gateway URL */
    protected static ?string $agc_gateway             = 'https://connect-drcn.dbankcloud.cn/';
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

        self::$build_path = getcwd().DIRECTORY_SEPARATOR.'build'.DIRECTORY_SEPARATOR;
        if (! is_dir( self::$build_path )) {mkdir( self::$build_path );}
        self::assertTrue( is_dir( self::$build_path ) );
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
            'debug_mode'           => self::$debug_mode
        ];
    }

    /** It provides the user configuration array. */
    #[ArrayShape(['access_token' => 'string', 'debug_mode' => 'bool'])]
    protected static function get_user_config(): array {
        self::load_user_access_token();
        return [
            'access_token' => self::$user_access_token,
            'debug_mode' => self::$debug_mode
        ];
    }

    /** Load previously authorized token from a file. */
    protected static function load_user_access_token() {
        if (file_exists(self::$oauth2_token_path) && is_readable(self::$oauth2_token_path)) {
            $token_response = (object) json_decode(file_get_contents(self::$oauth2_token_path), true);
            if (property_exists($token_response, 'token_expiry')) {
                if (property_exists($token_response, 'refresh_token')) {
                    if ($token_response->token_expiry < time()) {
                        $api = new AccountKit( self::get_config() );
                        $token_response = $api->get_access_token_by_refresh_token( $token_response->refresh_token );
                        file_put_contents(self::$oauth2_token_path, json_encode($token_response));
                    }
                    $remaining = $token_response->token_expiry - time();
                    echo sprintf('The cached token expires in %02d:%02d:%02d.', ($remaining / 3600), ($remaining / 60 % 60), $remaining % 60);
                }
            }
            self::$user_access_token = $token_response->access_token;
        } else {
            self::markTestSkipped( "Cannot read cached token: " . self::$oauth2_token_path);
        }
    }
    protected static function format_filesize(int $bytes, int $decimals=2): string {
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    protected function save_file(string $filename, string $raw_data) : void {
        $result = file_put_contents($filename, $raw_data);
        if (is_integer($result)) {
            echo "Saved ".$filename.", ".$result." bytes\n";
        }
    }
}
