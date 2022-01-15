<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace HMS\Core;

use InvalidArgumentException;
use stdClass;

/**
 * Class HMS Core Wrapper
 *
 * @author Martin Zeitler
 */
class Wrapper {

    private string|null $url_token_refresh = Constants::URL_OAUTH2_TOKEN_REFRESH_V3;

    private int $client_id = 0;
    private string|null $client_secret;
    private string|null $access_token = null;
    private int $token_expiry = 0;

    /** Further token related fields. */
    private string|null $id_token = null;
    private string|null $package_name;
    private string|null $token_scope;
    private string|null $union_id;
    private string|null $open_id;

    protected stdClass $result;

    /** Constructor. */
    public function __construct( array|string|null $config = null, int $token_endpoint_version = 3 ) {

        /** Try to get file-name from $HUAWEI_APPLICATION_CREDENTIALS. */
        if ( $config == null) {
            $config = getenv('HUAWEI_APPLICATION_CREDENTIALS');
            if (! $config) {$config = '../agconnect-services.json';}
        }

        if (! in_array( $token_endpoint_version, [2, 3] ) ) {
            $message = 'The token endpoint version must be either 1, 2, 3; provided: ' . $token_endpoint_version;
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
    private function init( array|string $config ): void {
        if (is_string( $config ) && file_exists( $config ) && is_readable( $config )) {
            $this->init_by_file( $config );
        } else if (is_array( $config )) {
            $this->init_by_array( $config );
        } else {
            $this->init_by_environment();
        }

        /* Refresh the access-token once. */
        $this->token_refresh();
    }

    /** Try to initialize from agconnect-services.json on string input. */
    private function init_by_file( string $config ) {
        $config = json_decode(file_get_contents( $config ));
        if ( is_object( $config )) {
            if ( property_exists( $config, 'client' )) {
                $this->client_id     = (int)    $config->client->client_id;
                $this->client_secret = (string) $config->client->client_secret;
                $this->package_name  = (string) $config->client->package_name;
            }
        }
    }

    /** Try to initialize from array, on array input. */
    private function init_by_array( array $config ) {
        if (
            isset($config['client_id']) && !empty($config['client_id']) &&
            isset($config['client_secret']) && !empty($config['client_secret'])
        ) {
            $this->client_id     =    (int) $config['client_id'];
            $this->client_secret = (string) $config['client_secret'];
        }
    }

    /** Try to initialize from environmental variables. */
    private function init_by_environment() {
        $this->client_id     = (int)    getenv('HUAWEI_CLIENT_ID');
        $this->client_secret = (string) getenv('HUAWEI_CLIENT_SECRET');
    }

    public function is_ready(): bool {
        return !$this->token_has_expired();
    }

    /** oAuth2 token refresh; $this->url_token_refresh either uses v2 or v3 endpoint. */
    private function token_refresh(): void {
        $result = $this->curl_request('POST', $this->url_token_refresh, [
            'grant_type' => 'client_credentials',
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
        ], [
            'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
        ]);
        if ( is_object( $result ) ) {
            if ( property_exists( $result, 'expires_in' ) ) {
                $this->token_expiry = time() + $result->expires_in;
            }
            if ( property_exists( $result, 'access_token' ) ) {
                $this->access_token = $result->access_token;
            }
            if ( property_exists( $result, 'scope' ) ) {
                $this->token_scope = $result->scope;
            }
            if ( property_exists( $result, 'id_token' ) ) {
                $this->id_token = $result->id_token;
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

    /** Expose $this->client_id. */
    protected function get_client_id(): int {
        return $this->client_id;
    }

    /** Perform cURL request. */
    protected function curl_request(string $method='POST', string $url=null, array|object $post_fields=[], array $headers=[] ): stdClass|bool {

        $curl = curl_init( $url );

        /* Apply headers. */
        if ( sizeof($headers) > 0) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        /* Apply JSON request-body. */
        if ( in_array($method, ['POST', 'PUT'])) {
            if ( is_array($post_fields) ) {
                if (isset($post_fields['grant_type']) && $post_fields['grant_type'] == 'client_credentials') {
                    /* Token refresh */
                    $post_fields = http_build_query($post_fields);
                } else {
                    /* JSON as request-body */
                    $post_fields = json_encode((object) $post_fields);
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

        $result = curl_exec($curl);
        if ($result === false) {
            return false;
        }
        $info = curl_getinfo($curl);
        curl_close($curl);
        $result = json_decode($result);

        if (property_exists( $result, 'code')) {
            $result->code = (int) $result->code;
        }
        return $result;
    }
}
