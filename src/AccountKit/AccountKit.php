<?php
namespace HMS\AccountKit;

use stdClass;

/**
 * Class HMS AccountKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-obtain-token_hms_reference-0000001050048618">AccountKit</a>
 * @author Martin Zeitler
 */
class AccountKit {

    /** oAuth2 Token related. */
    private string|null $url_token = Constants::URL_OAUTH2_TOKEN;

    private string|null $url_token_info = Constants::ACCOUNT_KIT_TOKEN_INFO;
    private string|null $url_user_info  = Constants::ACCOUNT_KIT_USER_INFO;

    /** oAuth2 Token related. */
    protected int $client_id = 0;
    private string|null $client_secret;

    protected string|null $access_token = null;
    protected string|null $refresh_token = null;
    private int $token_expiry = 0;

    /** ID Token related. */
    private string|null $id_token = null;
    private string|null $token_scope = null;
    private string|null $union_id = null;
    private string|null $open_id = null;

    /** value `client_credentials` isn't documented, but it's working. */
    private array $grant_types = [
        'authorization_code', 'client_credentials', 'refresh_token'
    ];

    public function __construct( array $config ) {
        $this->client_id     =    (int) $config['client_id'];
        $this->client_secret = (string) $config['client_secret'];
    }

    public function is_ready(): bool {
        return !$this->token_has_expired();
    }

    /** Determine if the token has expired. */
    private function token_has_expired(): bool {
        if (time() >= $this->token_expiry) {return true;}
        if ($this->access_token == null || empty($this->access_token)) {return true;}
        return false;
    }

    /**
     * Obtaining Access Token
     *
     * @return string|null
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-obtain-token_hms_reference-0000001050048618">Obtaining Access Token</a>
     */
    public function get_access_token(): string|null {
        $result = $this->curl_request('POST', $this->url_token, [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret
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
        return $this->access_token;
    }

    /**
     * TODO: Verify an ID Token.
     *
     * @param string|null $id_token
     * @return bool
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-verify-id-token_hms_reference-0000001050050577">Verifying an ID Token</a>
     */
    public function verify_id_token( string|null $id_token ): bool {
        return true;
    }

    /**
     * TODO: Parse an Access Token.
     *
     * @param string|null $access_token
     * @return bool
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-gettokeninfo-0000001050050585">Parsing an Access Token</a>
     */
    public function parse_access_token( string|null $access_token ): bool {
        return true;
    }

    /**
     * TODO: Obtain User Information.
     *
     * @param string|null $access_token
     * @return UserInfo|null
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/get-user-info-0000001060261938">Obtaining User Information</a>
     */
    public function get_user_info( string|null $access_token ): UserInfo|null {

        $result = $this->curl_request('POST', $this->url_token_info, [
            'access_token' => $access_token,
            'getNickName' => 1
        ], [
            'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
        ]);

        if ( is_object( $result ) ) {
            if ( property_exists( $result, 'error' ) && property_exists( $result, 'sub_error' )) {
                die( 'oAuth2 Error '.$result->error.' / '.$result->sub_error.' -> '.$result->error_description );
            } else if ( property_exists( $result, 'error' ) ) {
                die( 'oAuth2 Error -> '.$result->error );
            } else {
                if ( property_exists( $result, 'openID' ) ) {

                }
                if ( property_exists( $result, 'displayName' ) ) {

                }
                if ( property_exists( $result, 'headPictureURL' ) ) {

                }
                if ( property_exists( $result, 'email' ) ) {

                }
            }
        }
        return null;
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
                if ( isset($post_fields['grant_type']) ) {
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
        if ($result === false) {
            return false;
        }
        curl_close($curl);
        return json_decode( $result );
    }
}
