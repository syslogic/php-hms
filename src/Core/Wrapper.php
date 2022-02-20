<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace HMS\Core;

use stdClass;

/**
 * Class HMS Core Wrapper
 *
 * @author Martin Zeitler
 */
class Wrapper {

    /** oAuth2 Token related. */
    protected string|null $access_token = null;

    /** Default Result. */
    protected stdClass $result;

    /** These are now available through Core\Config. */
    private string|null $client_secret = null;
    protected string|null $app_secret = null;
    protected string|null $package_name = null;
    protected string|null $api_key = null;
    protected int $project_id = 0;
    protected int $product_id = 0;
    protected int $client_id = 0;
    protected int $app_id = 0;

    /** Constructor. */
    public function __construct( array|null $config = null ) {
        $this->init( $config );
    }

    /** Initialize the oAuth2 client; either by array or environmental variables. */
    private function init( array|null $config = null ): void {
        if ( is_array( $config ) ) {
            $this->init_by_array( $config );
        } else {
            $this->init_by_environment();
        }
    }

    /** Try to initialize the client from array. */
    private function init_by_array( array $config ) {
        if ( isset( $config['client_id'] ) && isset( $config['client_secret'] ) ) {
            $this->app_id     =    (int) $config['client_id'];
            $this->app_secret = (string) $config['client_secret'];
        }
    }

    /** Try to initialize the client from environmental variables. */
    private function init_by_environment() {
        if ( is_string( getenv('HUAWEI_APP_ID' ) ) && is_string( getenv('HUAWEI_APP_SECRET' ) ) ) {
            $this->app_id     =    (int) getenv( 'HUAWEI_APP_ID' );
            $this->app_secret = (string) getenv( 'HUAWEI_APP_SECRET' );
        }
    }

    /** Provide HTTP request headers as array. */
    protected function auth_header(): array {
        return [ "Content-Type: application/json", "Authorization: Bearer $this->access_token" ];
    }

    /** The expiry doesn't matter as this token is always being fetched */
    public function is_ready(): bool {
        return $this->access_token != null;
    }

    /** Perform cURL request. */
    protected function curl_request(string $method='POST', string $url=null, array|object $post_fields=[], array $headers=[], bool $build_query_string=true ): stdClass|bool {

        $curl = curl_init( $url );

        /* Apply headers. */
        if ( sizeof($headers) > 0) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        /* Apply JSON request-body. */
        if ( in_array($method, ['POST', 'PUT']) ) {

            if ( is_array( $post_fields ) && sizeof($post_fields) > 0) {
                if ( isset($post_fields['grant_type']) && $build_query_string ) {
                    $post_fields = http_build_query($post_fields);  /* It's a token request. */
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
        curl_close($curl);

        if ($result === false) {
            return false;
        }
        if ($result === '' && $info['http_code'] !== 200) {
            return false;
        }

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

        /** $data->ret */
        if (property_exists($data, 'ret')) {
            if (property_exists($data->ret, 'code')) {
                $data->code = (int) $data->ret->code;
            }
            if (property_exists($data->ret, 'msg')) {
                $data->message = (string) $data->ret->msg;
            }
            unset( $data->ret );
        }

        return $data;
    }
}
