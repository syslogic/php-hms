<?php
namespace HMS\AccountKit;

use HMS\Core\Wrapper;
use stdClass;

/**
 * Class HMS AccountKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-obtain-token_hms_reference-0000001050048618">AccountKit</a>
 * @author Martin Zeitler
 */
class AccountKit extends Wrapper {

    /** oAuth2 Token related. */
    private string|null $url_token = Constants::URL_OAUTH2_TOKEN;
    private string|null $url_token_info = Constants::ACCOUNT_KIT_TOKEN_INFO;
    private string|null $url_user_info  = Constants::ACCOUNT_KIT_USER_INFO;

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
        parent::__construct( $config );
        $this->post_init();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->api_key, $this->api_signature);
    }

    /**
     * Obtaining an Access Token.
     *
     * @return string|null
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-obtain-token_hms_reference-0000001050048618">Obtaining Access Token</a>
     */
    public function get_access_token(): string|null {
        $result = $this->guzzle_urlencoded($this->url_token, [
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8'
        ], [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->app_id,
            'client_secret' => $this->app_secret
        ]);
        return $this->parse_result($result);
    }

    public function get_access_token_by_auth_code( string $authorization_code ) {
        $result = $this->guzzle_urlencoded($this->url_token, [
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8'
        ], [
            'grant_type'    => 'authorization_code',
            'client_id'     => $this->app_id,
            'client_secret' => $this->app_secret,
            'redirect_uri'  => $this->oauth2_redirect_url,
            'code'          => $authorization_code
        ]);
        return $this->parse_result($result);
    }

    /**
     * Parse an Access Token.
     *
     * TokenInfo Error 1500 / 15007 -> id_token is empty
     *
     * @param string|null $access_token
     * @return TokenInfo|null
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-gettokeninfo-0000001050050585">Parsing an Access Token</a>
     */
    public function parse_access_token( string|null $access_token ): TokenInfo|null {
        $result = $this->guzzle_urlencoded(Constants::ACCOUNT_KIT_TOKEN_INFO, [
            'Content-Type' => 'application/x-www-form-urlencoded;charset=utf-8',
            'Authorization' => 'Bearer '.$this->access_token
        ], [
            'access_token' => $access_token,
            'getNickName' => 1
        ]);
        if ( is_object( $result ) ) {
            if ( property_exists( $result, 'error' ) && property_exists( $result, 'sub_error' )) {
                die( 'TokenInfo Error '.$result->error.' / '.$result->sub_error.' -> '.$result->error_description );
            } else {
                return new TokenInfo( $result );
            }
        }
        return null;
    }

    /**
     * TODO: Obtain User Information.
     *
     * @param string|null $user_access_token
     * @return UserInfo|null
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/get-user-info-0000001060261938">Obtaining User Information</a>
     */
    public function get_user_info( string|null $user_access_token ): UserInfo|stdClass {
        $result = $this->guzzle_urlencoded($this->url_user_info, [
            'Content-Type: application/x-www-form-urlencoded;charset=utf-8',
            "Authorization: Bearer $this->access_token" // OK
        ], [
            'access_token' => $user_access_token,
            'getNickName' => 1
        ]);
        if (! is_object( $result ) ) {return new stdClass();}
        if ( property_exists( $result, 'error' ) && property_exists( $result, 'sub_error' )) {
            // die( 'oAuth2 Error '.$result->error.' / '.$result->sub_error.' -> '.$result->error_description );
            return $result;
        } else if ( property_exists( $result, 'error' ) ) {
            // die( 'oAuth2 Error -> '.$result->error );
            return $result;
        } else {
            return new UserInfo( $result );
        }
    }

    /**
     * TODO: Verify an ID Token URL_OAUTH2_TOKEN_INFO.
     *
     * @param string|null $id_token
     * @return IdTokenInfo|null
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-verify-id-token_hms_reference-0000001050050577">Verifying an ID Token</a>
     */
    public function verify_id_token( string|null $id_token ): IdTokenInfo|stdClass {
        $result = $this->guzzle_urlencoded($this->url_token_info, [
            'Content-Type: application/x-www-form-urlencoded;charset=utf-8',
            "Authorization: Bearer $this->access_token" // OK
        ], [
            'id_token' => $id_token
        ]);
        if (! is_object( $result ) ) {return new stdClass();}
        if ( property_exists( $result, 'error' ) && property_exists( $result, 'sub_error' )) {
            // die( 'oAuth2 Error '.$result->error.' / '.$result->sub_error.' -> '.$result->error_description );
            return $result;
        } else if ( property_exists( $result, 'error' ) ) {
            // die( 'oAuth2 Error -> '.$result->error );
            return $result;
        } else {
            return new IdTokenInfo( $result );
        }
    }

    /**
     * @param bool|stdClass $result
     * @return string|void|null
     */
    public function parse_result(bool|stdClass $result): string|null {
        if (is_object($result)) {
            if (property_exists($result, 'error') && property_exists($result, 'sub_error')) {
                die('oAuth2 Error ' . $result->error . ' / ' . $result->sub_error . ' -> ' . $result->error_description);
            } else {
                if (property_exists($result, 'access_token')) {
                    $this->access_token = $result->access_token;
                }
                if (property_exists($result, 'expires_in')) {
                    $this->token_expiry = time() + $result->expires_in;
                }
                if (property_exists($result, 'id_token')) {
                    $this->id_token = $result->id_token;
                }
                if (property_exists($result, 'scope')) {
                    $this->token_scope = $result->scope;
                }
            }
        }
        return $this->access_token;
    }
}
