<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace HMS\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
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
 * @property ResponseInterface $response Default response.
 * @property array $headers Default request headers.
 * @property stdClass $result Default API result.
 * @author Martin Zeitler
 */
abstract class Wrapper {

    protected int $client_id = 0;
    protected string|null $client_secret = null;
    protected int $app_id = 0;
    protected string|null $app_secret = null;
    protected string|null $api_key = null;
    protected string|null $api_signature = null;
    protected string|null $access_token = null;
    protected string|null $refresh_token = null;
    protected int $token_expiry = 0;
    protected string|null $package_name = null;
    protected int $product_id = 0;
    protected int $project_id = 0;
    protected int $agc_client_id = 0;
    protected string|null $agc_client_secret = null;

    protected Client $client;
    protected ResponseInterface $response;
    private array $headers = [ 'Content-Type' => 'application/json;charset=utf-8' ];
    protected stdClass $result;

    /** Constructor. */
    public function __construct( array|null $config = null ) {
        $this->init( $config );
        $this->post_init();
    }

    protected abstract function post_init();

    /** Initialize the client; either by array or by environmental variables. */
    private function init( array|null $config = null ): void {
        $this->result = new stdClass();
        $this->client = new Client( [
            RequestOptions::VERIFY => !$this->is_windows(),
            RequestOptions::DEBUG => true
        ] );
        if ( is_array( $config ) ) {
            $this->init_by_array( $config );
        } else {
            $this->init_by_environment();
        }
    }

    /** Determine if running on Windows. */
    private function is_windows(): bool {
        return DIRECTORY_SEPARATOR === '\\';
    }

    /**
     * Determine if an access token has already been fetched.
     * Implementations may check for the presence of other values.
     */
    public function is_ready(): bool {
        return $this->access_token != null;
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
        if ( isset( $config['api_signature'] ) ) {
            $this->api_signature = (string) $config['api_signature'];
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
    #[ArrayShape(['Content-Type' => 'string', 'Authorization' => 'string'])]
    protected function auth_headers(): array {
        return [
            'Content-Type' => 'application/json;charset=utf-8',
            'Authorization' => ' Bearer ' . $this->access_token
        ];
    }

    /** Provide HTTP request headers as array. */
    #[ArrayShape(['Content-Type' => 'string'])]
    protected function request_headers(): array {
        return [ 'Content-Type' => 'application/json;charset=utf-8' ];
    }

    /** Perform GuzzleHttp POST request. */
    protected function guzzle_post( string $url=null, array $headers=[], array|object $post_fields=[] ): stdClass|bool {
        try {
            $this->response = $this->client->post( $url, [
                RequestOptions::HEADERS => $headers,
                RequestOptions::JSON => $post_fields
            ] );
            if ($this->response->getStatusCode() == 200) {
                $this->result = json_decode( $this->response->getBody() );
            }
        } catch (GuzzleException $e) {
            $this->result->code = $e->getCode();
            $this->result->message = $e->getMessage();
        }
        return $this->sanitize( $this->result );
    }

    /** Perform GuzzleHttp POST request. */
    protected function guzzle_urlencoded( string $url=null, array $headers=[], array $form_params=[] ): stdClass|bool {
        try {
            $this->response = $this->client->post( $url, [
                RequestOptions::HEADERS => $headers,
                RequestOptions::FORM_PARAMS => $form_params
            ] );
            if ($this->response->getStatusCode() == 200) {
                $this->result = json_decode( $this->response->getBody() );
            }
        } catch (GuzzleException $e) {
            $this->result->code = $e->getCode();
            $this->result->message = $e->getMessage();
        }
        return $this->sanitize( $this->result );
    }

    /** Perform GuzzleHttp GET request. */
    protected function guzzle_get( string $url=null, array $headers=[], array $query=[] ): stdClass|bool {
        try {
            $this->response = $this->client->get( $url, [
                RequestOptions::HEADERS => $headers,
                RequestOptions::QUERY => $query
            ] );
            $content_type = $this->response->getHeader('Content-Type')[0];
            $status_code = $this->response->getStatusCode();
            if ($status_code == 200) {
                switch ($content_type) {
                    case 'application/json':
                        $this->result = json_decode( $this->response->getBody() );
                        break;
                    case 'image/png':
                        $binary = $this->response->getBody()->getContents();
                        $this->result->url = 'data:image/png;base64,'.base64_encode($binary);
                        $this->result->raw = $binary;
                        break;
                }
            }
        } catch (GuzzleException $e) {
            $this->result->code = $e->getCode();
            $this->result->message = $e->getMessage();
        }
        return $this->sanitize( $this->result );
    }

    /** Different kinds of field descriptors may be returned ... */
    protected function sanitize(object $data ): object {

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
