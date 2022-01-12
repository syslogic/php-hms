<?php
namespace HMS\Core;

use stdClass;

/**
 * Class HMS Core Wrapper
 *
 * @author Martin Zeitler
 */
class Wrapper {

    protected int $client_id = 0;
    private string|null $client_secret;
    private string|null $access_token = null;
    private int $token_expiry = 0;

    protected stdClass $result;

    /** Constructor. */
    public function __construct( array $config ) {
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

            // Try to initialize from agconnect-services.json on string input.
            $config = json_decode(file_get_contents( $config ));
            $this->client_id     = (int)    $config['client_id'];
            $this->client_secret = (string) $config['client_secret'];

        } else if (is_array( $config )) {

            // Try to initialize from array, on array input.
            if (
                isset($config['client_id']) && !empty($config['client_id']) &&
                isset($config['client_secret']) && !empty($config['client_secret'])
            ) {
                $this->client_id     = (int)    $config['client_id'];
                $this->client_secret = (string) $config['client_secret'];
            }
        } else {

            // Try to initialize from environmental variables.
            $this->client_id     = (int)    getenv('HUAWEI_CLIENT_ID');
            $this->client_secret = (string) getenv('HUAWEI_CLIENT_SECRET');
        }

        /* Refresh the access-token once. */
        $this->token_refresh();
    }

    public function is_ready(): bool {
        return !$this->token_has_expired();
    }

    /** Refresh token. */
    private function token_refresh(): void {
        $result = $this->curl_request('POST', Constants::URL_OAUTH2_TOKEN,
            [ 'grant_type' => 'client_credentials', 'client_id' => $this->client_id, 'client_secret' => $this->client_secret ],
            [ 'Content-Type: application/x-www-form-urlencoded;charset=utf-8' ]
        );
        if ( is_object( $result ) && property_exists( $result, 'access_token' ) ) {
            $this->token_expiry = time() + $result->expires_in;
            $this->access_token = $result->access_token;
        }
    }

    /** Determine if the token has expired. */
    private function token_has_expired(): bool {
        if (time() >= $this->token_expiry) {return true;}
        if ($this->access_token == null || empty($this->access_token)) {return true;}
        return false;
    }

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
