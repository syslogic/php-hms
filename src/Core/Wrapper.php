<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace HMS\Core;

use InvalidArgumentException;
use JetBrains\PhpStorm\NoReturn;
use stdClass;

/**
 * Class HMS Core Wrapper
 *
 * @author Martin Zeitler
 */
class Wrapper {

    /** oAuth2 Token related. */
    private string|null $url_token_refresh = Constants::URL_OAUTH2_TOKEN_REFRESH_V3;
    protected string|null $access_token = null;
    protected string|null $refresh_token = null;
    private int $token_expiry = 0;

    /** ID Token related. */
    private string|null $id_token = null;
    private string|null $token_scope = null;
    private string|null $union_id = null;
    private string|null $open_id = null;

    /** Default Result. */
    protected stdClass $result;

    /** These are now available through Core\Config. */
    private string|null $client_secret = null;
    private string|null $app_secret = null;
    protected string|null $package_name = null;
    protected string|null $api_key = null;
    protected int $project_id = 0;
    protected int $product_id = 0;
    protected int $client_id = 0;
    protected int $app_id = 0;

    /** Constructor. */
    public function __construct( array|string|null $config = null, int $token_endpoint_version = 3 ) {
        if (! in_array( $token_endpoint_version, [2, 3] ) ) {
            $message = 'The token endpoint version must be either 2 or 3; provided: ' . $token_endpoint_version;
            throw new InvalidArgumentException( $message );
        }
        if ($token_endpoint_version == 2) {
            $this->url_token_refresh = Constants::URL_OAUTH2_TOKEN_REFRESH_V2;
        }
        $this->init( $config );
    }

    /**
     * Initialize the oAuth2 client.
     *
     * - from agconnect-services.json on string input.
     * - from array, on array input.
     * - from environmental variables.
     */
    private function init( array|string|null $config ): void {

        /** Try to get file-name from $HUAWEI_APPLICATION_CREDENTIALS. */
        $config_file = null;
        if ( is_string( getenv('HUAWEI_APPLICATION_CREDENTIALS') )) {
            $config_file = getenv('HUAWEI_APPLICATION_CREDENTIALS');
        }

        /** Then either initialize by filename, array or environmental variables. */
        if (is_string( $config_file ) && file_exists( $config_file ) && is_readable( $config_file )) {
            $this->init_by_file( $config_file );
        } else if (is_array( $config )) {
            $this->init_by_array( $config );
        } else {
            $this->init_by_environment();
        }

        /* Refresh the access-token once. */
        $this->token_refresh();
    }

    /** Try to initialize from agconnect-services.json on string input. */
    private function init_by_file( string $config_file ) {
        $config = json_decode(file_get_contents( $config_file ));
        if ( is_object( $config )) {
            if ( property_exists( $config, 'client' )) {
                $this->app_id        =    (int) $config->client->app_id;
                $this->app_secret    = (string) getenv('HUAWEI_APP_SECRET'); // not contained in the JSON.
                $this->package_name  = (string) $config->client->package_name;
                $this->project_id    =    (int) $config->client->project_id;
                $this->product_id    =    (int) $config->client->product_id;
                $this->client_id     =    (int) $config->client->client_id;
                $this->client_secret = (string) $config->client->client_secret;
                $this->api_key       = (string) $config->client->api_key;
            }
        }
    }

    /** Try to initialize from array, on array input. */
    private function init_by_array( array $config ) {
        if (
            isset($config['client_id']) && !empty($config['client_id']) &&
            isset($config['client_secret']) && !empty($config['client_secret'])
        ) {
            $this->client_id  =       (int) $config['client_id'];
            $this->client_secret = (string) $config['client_secret'];
        }
    }

    /** Try to initialize from environmental variables. */
    private function init_by_environment() {
        if (
            is_string( getenv('HUAWEI_APP_ID' ) ) &&
            is_string( getenv('HUAWEI_APP_SECRET' ) )
        ) {
            $this->client_id     =    (int) getenv( 'HUAWEI_APP_ID' );
            $this->client_secret = (string) getenv( 'HUAWEI_APP_SECRET' );
        }
    }

    public function is_ready(): bool {
        return !$this->token_has_expired();
    }

    /**
     * oAuth2 token refresh; $this->url_token_refresh either uses v2 or v3 endpoint.
     * TODO: should better be be moved to AccountKit; grant_type must be variable.
     */
    private function token_refresh(): void {
        $result = $this->curl_request('POST', $this->url_token_refresh, [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->app_id,
            'client_secret' => $this->app_secret
        ], [
            'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
        ]);
        if ( is_object( $result ) ) {
            if ( property_exists( $result, 'error' ) && property_exists( $result, 'sub_error' )) {
                die( 'oAuth2 Error '.$result->error.' / '.$result->sub_error.' -> '.$result->error_description );
            } else {
                if ( property_exists( $result, 'access_token' ) ) {
                    $this->access_token = $result->access_token;
                }
                if ( property_exists( $result, 'expires_in' ) ) {
                    $this->token_expiry = time() + $result->expires_in;
                }
                if ( property_exists( $result, 'id_token' ) ) {
                    $this->id_token = $result->id_token;
                }
                if ( property_exists( $result, 'scope' ) ) {
                    $this->token_scope = $result->scope;
                }
            }
        }
    }

    /** Determine if the token has expired. */
    private function token_has_expired(): bool {
        if (time() >= $this->token_expiry) {return true;}
        if ($this->access_token == null || empty($this->access_token)) {return true;}
        return false;
    }

    /** Provide HTTP request headers as array. */
    protected function auth_header(): array {
        return [ "Content-Type: application/json", "Authorization: Bearer $this->access_token" ];
    }

    /** Perform cURL request. */
    protected function curl_request(string $method='POST', string $url=null, array|object $post_fields=[], array $headers=[] ): stdClass|bool {

        $curl = curl_init( $url );

        /* Apply headers. */
        if ( sizeof($headers) > 0) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        /* Apply JSON request-body. */
        if ( in_array($method, ['POST', 'PUT']) ) {
            if ( is_array( $post_fields ) && sizeof($post_fields) > 0) {
                if (isset($post_fields['grant_type']) && $post_fields['grant_type'] == 'client_credentials') {
                    $post_fields = http_build_query($post_fields);     /* It's a token refresh. */
                } else {
                    $post_fields = json_encode((object) $post_fields); /* Post request incl. token as JSON request-body. */
                }
            } else if ( is_object($post_fields) ) {
                $post_fields = json_encode($post_fields);
            }
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
            curl_setopt($curl, CURLOPT_POST, 1);
        }

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT,        5);

        $result = curl_exec( $curl );
        $info = curl_getinfo( $curl );
        if ($result === false) {
            return false;
        }
        curl_close($curl);
        $data = json_decode( $result );
        return $this->sanitize( $data );
    }

    /** Different kinds of field descriptors may be returned ... */
    private function sanitize( object $data ): object {

        /** $data->code */
        if ( property_exists( $data, 'code') ) {
            $data->code = (int) $data->code;
        }
        if (property_exists($data, 'result_code')) {
            $data->code = (int) $data->result_code;
            unset( $data->result_code );
        }
        if (property_exists($data, 'resultCode')) {
            $data->code = (int) $data->resultCode;
            unset( $data->resultCode );
        }

        /** $data->message */
        if (property_exists($data, 'msg')) {
            $data->message = (string) $data->msg;
            unset( $data->msg );
        }
        if (property_exists($data, 'result_msg')) {
            $data->message = (string) $data->result_msg;
            unset( $data->result_msg );
        }
        if (property_exists($data, 'resultMsg')) {
            $data->message = (string) $data->resultMsg;
            unset( $data->resultMsg );
        }

        /** $data->sub_error */
        if (property_exists($data, 'sub_error')) {
            $data->sub_error = (int) $data->sub_error;
        }

        return $data;
    }
}
