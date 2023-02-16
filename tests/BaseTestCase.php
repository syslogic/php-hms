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

    protected static string $build_path;
    protected static bool $debug_mode = false;

    protected static int $oauth2_client_id = 0;            // OAuth2 client ID.
    protected static ?string $oauth2_client_secret = null; // OAuth2 client Secret.
    protected static string $user_access_token_path = '../.credentials/huawei_token.json';
    protected static ?string $user_access_token = null;
    protected static string $file_id = 'BhrdFPv6j8QzM60pdSadNXY_FZRnRp_AM';

    protected static int $agc_project_client_id = 0;               // AGConnect API.
    protected static ?string $agc_project_client_secret = null;    // AGConnect API.

    protected static ?string $api_key = null;              // MapKit in general.
    protected static ?string $signature_key = null;        // Maps Static API.
    protected static ?string $package_name = null;

    protected static int $project_id = 0;
    protected static int $developer_id = 0;

    protected const CLIENT_NOT_READY = 'The API client is not ready.';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        self::$oauth2_client_id = getenv('HUAWEI_OAUTH2_CLIENT_ID');
        $message = 'Variable HUAWEI_OAUTH2_CLIENT_ID is not set.';
        self::assertTrue( is_int(self::$oauth2_client_id) && self::$oauth2_client_id > 0, $message );

        self::$oauth2_client_secret = getenv('HUAWEI_OAUTH2_CLIENT_SECRET');
        $message = 'Variable HUAWEI_OAUTH2_CLIENT_SECRET is not set.';
        self::assertNotEmpty( self::$oauth2_client_secret, $message );

        self::$api_key = getenv('HUAWEI_MAPKIT_API_KEY');
        $message = 'Variable HUAWEI_MAPKIT_API_KEY is not set.';
        self::assertNotEmpty( self::$api_key, $message );

        // must be type of project_client_id (project level API client).
        self::$agc_project_client_id = (int) getenv('HUAWEI_CONNECT_PROJECT_CLIENT_ID');
        $message = 'Variable HUAWEI_CONNECT_PROJECT_CLIENT_ID is not set.';
        self::assertTrue( is_int(self::$agc_project_client_id) && self::$agc_project_client_id > 0, $message );

        // must be type of project_client_id (project level API client).
        self::$agc_project_client_secret = getenv('HUAWEI_CONNECT_PROJECT_CLIENT_SECRET');
        $message = 'Variable HUAWEI_CONNECT_PROJECT_CLIENT_SECRET is not set.';
        self::assertNotEmpty( self::$agc_project_client_secret, $message );

        self::$package_name = getenv('HUAWEI_CONNECT_PACKAGE_NAME');
        $message = 'Variable HUAWEI_CONNECT_PACKAGE_NAME is not set.';
        self::assertNotEmpty( self::$package_name, $message );

        self::$project_id = getenv('HUAWEI_CONNECT_PROJECT_ID');
        $message = 'Variable HUAWEI_CONNECT_PROJECT_ID is not set.';
        self::assertTrue( is_int(self::$project_id) && self::$project_id > 0, $message );

        self::$developer_id = getenv('HUAWEI_CONNECT_DEVELOPER_ID');
        $message = 'Variable HUAWEI_CONNECT_DEVELOPER_ID is not set.';
        self::assertTrue( is_int(self::$developer_id) && self::$developer_id > 0, $message );

        self::$build_path = getcwd().DIRECTORY_SEPARATOR.'build'.DIRECTORY_SEPARATOR;
        if (! is_dir( self::$build_path )) {mkdir( self::$build_path );}
        self::assertTrue( is_dir( self::$build_path ) );
    }

    /** It provides the configuration array. */
    #[ArrayShape([
        'oauth2_client_id'          => 'integer',
        'oauth2_client_secret'      => 'string',
        'agc_project_client_id'     => 'integer',
        'agc_project_client_secret' => 'string',
        'package_name'              => 'string',
        'project_id'                => 'integer',
        'developer_id'              => 'integer',
        'api_key'                   => 'string',
        'debug_mode'                => 'bool'
    ])]
    protected static function get_config(): array {
        return [
            'oauth2_client_id'          => self::$oauth2_client_id,
            'oauth2_client_secret'      => self::$oauth2_client_secret,
            'agc_project_client_id'     => self::$agc_project_client_id,
            'agc_project_client_secret' => self::$agc_project_client_secret,
            'package_name'              => self::$package_name,
            'project_id'                => self::$project_id,
            'developer_id'              => self::$developer_id,
            'api_key'                   => self::$api_key,
            'debug_mode'                => self::$debug_mode
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
        if (file_exists(self::$user_access_token_path) && is_readable(self::$user_access_token_path)) {
            $token_response = (object) json_decode(file_get_contents(self::$user_access_token_path), true);
            if (property_exists($token_response, 'token_expiry')) {
                if (property_exists($token_response, 'refresh_token')) {
                    if ($token_response->token_expiry < time()) {
                        $api = new AccountKit( self::get_config() );
                        $token_response = $api->get_access_token_by_refresh_token( $token_response->refresh_token );
                        if (property_exists($token_response, 'access_token')) {
                            file_put_contents(self::$user_access_token_path, json_encode($token_response));
                        }
                    }
                    $remaining = $token_response->token_expiry - time();
                    echo sprintf('The cached access token expires in %02d:%02d:%02d.', ($remaining / 3600), ($remaining / 60 % 60), $remaining % 60);
                }
            }
            if (property_exists($token_response, 'access_token')) {
                self::$user_access_token = $token_response->access_token;
            } else if (property_exists($token_response, 'message')) {
                echo $token_response->message;
            }
        } else {
            self::markTestSkipped( "Cannot read cached access token: " . self::$user_access_token_path);
        }
    }

    protected static function format_filesize(int $bytes, int $decimals=2): string {
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
    }

    protected function save_file(string $filename, string $raw_data) : void {
        $result = file_put_contents($filename, $raw_data);
        if (is_integer($result)) {
            echo "Saved ".$filename.", ".$result." bytes\n";
        }
    }
}
