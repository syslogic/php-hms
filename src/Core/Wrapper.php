<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace HMS\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Http\Message\ResponseInterface;
use stdClass;

/**
 * Class HMS Core Wrapper
 *
 * @property int $client_id AGC client ID.
 * @property string|null $client_secret AGC client secret.
 * @property int $app_id OAuth2 client ID.
 * @property string|null $app_secret OAuth2 client secret
 * @property string|null $access_token OAuth2 (app) access token.
 * @property string|null $refresh_token OAuth2 refresh token.
 * @property int $token_expiry OAuth2 access token expiry.
 * @property string|null $api_key MapKit API key.
 * @property string|null $signature_key MapKit Static API signature key.
 * @property string|null $package_name AnalyticsKit related; for PushKit click_action?
 * @property int $product_id AnalyticsKit related.
 * @property int $project_id AnalyticsKit related.
 * @property int $agc_client_id  AGC API client ID.
 * @property string|null $agc_client_secret AGC API client secret.
 * @property ResponseInterface $response Default Response.
 * @property stdClass $result Default Result.
 * @author Martin Zeitler
 */
class Wrapper {

    protected int $client_id = 0;
    protected string|null $client_secret = null;
    protected int $app_id = 0;
    protected string|null $app_secret = null;
    protected string|null $api_key = null;
    protected static string|null $signature_key = null;
    protected string|null $access_token = null;
    protected string|null $refresh_token = null;
    protected int $token_expiry = 0;
    protected string|null $package_name = null;
    protected int $product_id = 0;
    protected int $project_id = 0;
    protected int $agc_client_id = 0;
    protected string|null $agc_client_secret = null;
    private ResponseInterface $response;
    protected stdClass $result;

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
        if ( isset( $config['app_id'] ) ) {
            $this->app_id = (int) $config['app_id'];
        }
        if ( isset( $config['app_secret'] ) ) {
            $this->app_secret = (string) $config['app_secret'];
        }
        if ( isset( $config['agc_client_id'] ) ) {
            $this->agc_client_id = (int) $config['agc_client_id'];
        }
        if ( isset( $config['agc_client_secret'] ) ) {
            $this->agc_client_secret = (string) $config['agc_client_secret'];
        }
        if ( isset( $config['api_key'] ) ) {
            $this->api_key = (string) $config['api_key'];
        }
        if ( isset($config['product_id']) && is_int($config['product_id'])) {
            $this->product_id = $config['product_id'];
        }
    }

    /** Try to initialize the client from environment. */
    private function init_by_environment() {
        if ( is_string( getenv('HUAWEI_OAUTH2_CLIENT_ID' ) ) ) {
            $this->app_id = (int) getenv( 'HUAWEI_OAUTH2_CLIENT_ID' );
        }
        if ( is_string( getenv('HUAWEI_OAUTH2_CLIENT_SECRET' ) ) ) {
            $this->app_secret = (string) getenv( 'HUAWEI_OAUTH2_CLIENT_SECRET' );
        }
        if ( is_string( getenv('HUAWEI_CONNECT_API_CLIENT_ID' ) ) ) {
            $this->agc_client_id = (int) getenv( 'HUAWEI_CONNECT_API_CLIENT_ID' );
        }
        if ( is_string( getenv('HUAWEI_CONNECT_API_CLIENT_SECRET' ) ) ) {
            $this->agc_client_secret = (string) getenv( 'HUAWEI_CONNECT_API_CLIENT_SECRET' );
        }
        if ( is_string( getenv('HUAWEI_MAPKIT_API_KEY' ) ) ) {
            $this->api_key = (string) getenv( 'HUAWEI_MAPKIT_API_KEY' );
        }
        if ( is_string( getenv('HUAWEI_CONNECT_PRODUCT_ID' ) ) ) {
            $this->product_id = (int) getenv( 'HUAWEI_CONNECT_PRODUCT_ID' );
        }
    }

    /** Provide HTTP request headers as array. */
    protected function auth_header(): array {
        return [
            "Content-Type: application/json",
            "Authorization: Bearer $this->access_token"
        ];
    }

    /** The expiry doesn't matter as this token is always being fetched */
    public function is_ready(): bool {
        return $this->access_token != null;
    }

    /** Perform cURL request. */
    protected function curl_request(string $method='POST', string $url=null, array $headers=[], array|object $post_fields=[], bool $build_query_string=true ): stdClass|bool {

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

        $body = curl_exec( $curl );
        $info = curl_getinfo( $curl );
        curl_close($curl);

        if ($body === false) {
            return false;
        }
        if ($body === '' && $info['http_code'] !== 200) {
            return false;
        }

        $data = json_decode( $body );
        return $this->sanitize( $data );
    }

    /** Perform GuzzleHttp request. */
    protected function guzzle_request(string $method='POST', string $url=null, array $headers=[], array $post_fields=[] ): stdClass|bool {
        $client = new Client( [ 'allow_redirects' => true, 'cookies' => true ] );
        try {
            switch( $method ) {

                case 'GET':
                    $this->response = $client->get( $url, [
                        'headers' => $headers
                    ] );
                    break;

                case 'POST':
                    $this->response = $client->post( $url, [
                        'headers' => $headers,
                        'json' => $post_fields
                    ] );
                    break;
            }
            if ($this->response->getStatusCode() == 200) {
                $body = $this->response->getBody();
                $this->result = json_decode( $body );
            }
        } catch (GuzzleException $e) {
            die($e->getMessage());
        }

        return $this->sanitize( $this->result );
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
