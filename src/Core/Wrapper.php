<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace HMS\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use GuzzleHttp\RequestOptions;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Http\Message\ResponseInterface;
use Monolog\Logger;
use stdClass;

/**
 * Class HMS Core Wrapper
 *
 * @property int $oauth2_client_id             OAuth2 client ID (app_id).
 * @property string|null $oauth2_client_secret OAuth2 client secret (app_secret).
 * @property string|null $oauth2_api_scope     OAuth2 client side flow
 * @property string|null $oauth2_redirect_url  OAuth2 client side flow
 * @property string|null $access_token         OAuth2 (app) access token.
 * @property string|null $refresh_token        OAuth2 refresh token.
 * @property string|null $id_token             OAuth2 ID token.
 * @property string|null $token_scope          OAuth2 token API scope.
 * @property int $token_expiry                 OAuth2 access token expiry.
 * @property string|null $api_key              MapKit API key.
 * @property string|null $api_signature        MapKit Static API signature key.
 * @property string|null $package_name         AnalyticsKit related; for PushKit click_action?
 * @property int $product_id                   AnalyticsKit related.
 * @property int $project_id                   AnalyticsKit related.
 * @property int $agc_client_id                AGConnect API client ID.
 * @property string|null $agc_client_secret    AGConnect API client secret.
 * @property ResponseInterface $response       Default response.
 * @property stdClass $result                  Default API result.
 * @property array $headers                    Default request headers.
 * @author Martin Zeitler
 */
abstract class Wrapper {

    protected string $base_url;
    protected int $oauth2_client_id = 0;
    protected string|null $oauth2_client_secret = null;

    /** client-side flow */
    protected string $oauth2_api_scope = 'openid profile';

    /** client-side flow */
    protected string|null $oauth2_redirect_url = null;

    protected string|null $api_key = null;
    protected string|null $api_signature = null;
    protected string|null $access_token = null;
    protected string|null $refresh_token = null;
    protected string|null $id_token = null;
    protected int $token_expiry = 0;

    protected string|null $package_name = null;
    protected int $developer_id = 0;
    protected int $product_id = 0;
    protected int $project_id = 0;
    protected int $agc_client_id = 0;
    protected string|null $agc_client_secret = null;

    protected Client $client;
    protected ResponseInterface $response;
    protected stdClass $result;
    protected bool $debug_mode = false;

    /** Constructor. */
    public function __construct( array|null $config = null ) {
        $this->init( $config );
    }

    /** Initialize the client; either by array or by environmental variables. */
    private function init( array|null $config = null): void {
        $this->result = new stdClass();
        if ( is_array( $config ) && isset( $config['debug_mode'] ) && is_bool($config['debug_mode']) ) {
            $this->debug_mode = $config['debug_mode'];
        }
        if ( $this->debug_mode ) {

            $templates = [
                '{code} >> {req_headers}',
                '{code} >> {req_body}',
                '{code} << {res_headers}',
                '{code} << {res_body}'
            ];
            $handlers = HandlerStack::create();
            $logger = new Logger('Logger');
            foreach ($templates as $template) {
                $handlers->unshift($this->getMiddleware($logger, $template));
            }
            $this->client = new Client( [
                RequestOptions::VERIFY => !$this->is_windows(),
                RequestOptions::DEBUG => false,
                'handler' => $handlers
            ] );
        } else {
            $this->client = new Client( [
                RequestOptions::VERIFY => !$this->is_windows(),
                RequestOptions::DEBUG => false
            ] );
        }

        if ( is_array( $config ) ) {
            $this->init_by_array( $config );
        } else {
            $this->init_by_environment();
        }
    }

    private function getMiddleware( Logger $logger, string $template ): callable {
        return Middleware::log($logger, new MessageFormatter($template));
    }

    /**
     * Not all class properties of Core\Wrapper are used by each particular child class.
     * Unset irrelevant properties per child class, in order to make debugging easier.
     */
    protected abstract function post_init(): void;

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

    public function withDebugEnabled(): Wrapper {
        $this->debug_mode = true;
        return $this;
    }

    public function withBaseUrl( string $base_url ): Wrapper {
        $this->base_url = $base_url;
        return $this;
    }

    /** Try to initialize the client from array. */
    private function init_by_array( array $config ): void {
        if ( isset( $config['oauth2_client_id'] ) ) {
            $this->oauth2_client_id = (int) $config['oauth2_client_id'];
        }
        if ( isset( $config['oauth2_client_secret'] ) ) {
            $this->oauth2_client_secret = (string) $config['oauth2_client_secret'];
        }
        if ( isset( $config['oauth2_api_scope'] ) ) {
            $this->oauth2_api_scope = (string) $config['oauth2_api_scope'];
        }
        if ( isset( $config['oauth2_redirect_url'] ) ) {
            $this->oauth2_redirect_url = (string) $config['oauth2_redirect_url'];
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
        if ( isset($config['developer_id']) && is_int($config['developer_id'])) {
            $this->developer_id = $config['developer_id'];
        }
        if ( isset($config['project_id']) && is_int($config['project_id'])) {
            $this->project_id = $config['project_id'];
        }
        if ( isset($config['product_id']) && is_int($config['product_id'])) {
            $this->product_id = $config['product_id'];
        }
        if ( isset($config['package_name']) && is_int($config['package_name'])) {
            $this->package_name = $config['package_name'];
        }
    }

    /** Try to initialize the client from environment. */
    private function init_by_environment(): void {
        if ( is_string( getenv('HUAWEI_OAUTH2_CLIENT_ID' ) ) ) {
            $this->oauth2_client_id = (int) getenv( 'HUAWEI_OAUTH2_CLIENT_ID' );
        }
        if ( is_string( getenv('HUAWEI_OAUTH2_CLIENT_SECRET' ) ) ) {
            $this->oauth2_client_secret = (string) getenv( 'HUAWEI_OAUTH2_CLIENT_SECRET' );
        }
        if ( is_string( getenv('HUAWEI_OAUTH2_API_SCOPE' ) ) ) {
            $this->oauth2_api_scope = (string) getenv( 'HUAWEI_OAUTH2_API_SCOPE' );
        }
        if ( is_string( getenv('HUAWEI_OAUTH2_REDIRECT_URL' ) ) ) {
            $this->oauth2_redirect_url = (string) getenv( 'HUAWEI_OAUTH2_REDIRECT_URL' );
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
        if ( is_string( getenv('HUAWEI_CONNECT_DEVELOPER_ID' ) ) ) {
            $this->developer_id = (int) getenv( 'HUAWEI_CONNECT_DEVELOPER_ID' );
        }
        if ( is_string( getenv('HUAWEI_CONNECT_PROJECT_ID' ) ) ) {
            $this->project_id = (int) getenv( 'HUAWEI_CONNECT_PROJECT_ID' );
        }
        if ( is_string( getenv('HUAWEI_CONNECT_PRODUCT_ID' ) ) ) {
            $this->product_id = (int) getenv( 'HUAWEI_CONNECT_PRODUCT_ID' );
        }
        if ( is_string( getenv('HUAWEI_CONNECT_PACKAGE_NAME' ) ) ) {
            $this->package_name = (int) getenv( 'HUAWEI_CONNECT_PACKAGE_NAME' );
        }
    }

    /** Provide HTTP request headers as array. */
    #[ArrayShape(['Content-Type' => 'string'])]
    protected function request_headers(): array {
        return [ 'Content-Type' => 'application/json;charset=utf-8' ];
    }

    /** Provide HTTP request headers as array. */
    #[ArrayShape(['Content-Type' => 'string', 'Authorization' => 'string'])]
    protected function auth_headers(): array {
        return [
            'Content-Type' => 'application/json;charset=utf-8',
            'Authorization' => ' Bearer ' . $this->access_token
        ];
    }

    /** Perform GuzzleHttp GET/POST/PATCH/PUT/DELETE request. */
    protected function request( string $method='POST', ?string $url=null, array $headers=[], array|object|string $post_data=[], $urlencoded=false ): stdClass|bool {
        $request = [ RequestOptions::HEADERS => $headers, RequestOptions::DEBUG => $this->debug_mode ];
        try {
            switch ($method) {
                case 'GET':
                    $request[RequestOptions::QUERY] = $post_data; // as query string.
                    $this->response = $this->client->get( $url, $request );
                    break;
                case 'POST':
                    if ($urlencoded) {
                        $request[RequestOptions::FORM_PARAMS] = $post_data; // as form.
                    } else {
                        if (is_array($post_data)) {
                            $request[RequestOptions::JSON] = $post_data; // as JSON.
                        } else if (is_string($post_data)) {
                            $request[RequestOptions::BODY] = $post_data; // as raw string.
                        }
                    }
                    $this->response = $this->client->post( $url, $request );
                    break;
                case 'PATCH':
                    $request[RequestOptions::JSON] = $post_data;
                    $this->response = $this->client->patch( $url, $request );
                    break;
                case 'PUT':
                    $request[RequestOptions::JSON] = $post_data;
                    $this->response = $this->client->put( $url, $request );
                    break;
                case 'DELETE':
                    $request[RequestOptions::JSON] = $post_data;
                    $this->response = $this->client->delete( $url, $request );
                    break;
            }

            $this->result->code = $this->response->getStatusCode();
            if ($this->result->code == 200) {
                $content_type = strtolower($this->response->getHeader('Content-Type')[0]);
                switch ($content_type) {
                    case 'application/json':
                    case 'application/json;charset=utf-8':
                    case 'application/json; charset=utf-8':
                        $this->result = json_decode( $this->response->getBody() );
                        break;
                    case 'application/octet-stream': // DriveKit download
                        $binary = $this->response->getBody()->getContents();
                        $this->result->base64 = base64_encode($binary);
                        $this->result->raw = $binary;
                        break;
                    case 'image/png': // MapKit download
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
