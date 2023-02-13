<?php
namespace HMS\AccountKit;

use HMS\Core\Wrapper;
use JetBrains\PhpStorm\ArrayShape;
use stdClass;

/**
 * Class HMS AccountKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-obtain-token_hms_reference-0000001050048618">AccountKit</a>
 * @author Martin Zeitler
 */
class AccountKit extends Wrapper {

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->post_init();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        if (property_exists($this, 'api_key') && property_exists($this, 'api_signature')) {
            unset($this->api_key, $this->api_signature);
        }
    }

    /** Provide HTTP request headers as array. */
    #[ArrayShape(['Content-Type' => 'string'])]
    protected function request_headers(): array {
        return [ 'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8' ];
    }

    /** Provide HTTP request headers as array. */
    #[ArrayShape(['Content-Type' => 'string', 'Authorization' => 'string'])]
    protected function auth_headers(): array {
        return [
            "Content-Type" => "application/x-www-form-urlencoded;charset=utf-8",
            "Authorization" => "Bearer $this->access_token"
        ];
    }

    /**
     * Obtaining an Access Token.
     * @return string|null the token string only.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-obtain-token_hms_reference-0000001050048618">Obtaining Access Token</a>
     */
    public function get_access_token(): ?string {
        $result = $this->request( 'POST',Constants::URL_OAUTH2_TOKEN, $this->request_headers(), [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->oauth2_client_id,
            'client_secret' => $this->oauth2_client_secret
        ], true);
        return $this->parse_result($result);
    }

    /**
     * Obtaining an access token by trading an authorization code.
     * Intentionally returning the raw response, because the expiry timestamp is relevant.
     * @param string $authorization_code
     * @param string|null $oauth2_redirect_url
     * @return stdClass|null the retrieved token object.
     */
    public function get_access_token_by_auth_code( string $authorization_code, ?string $oauth2_redirect_url=null ): stdClass|bool {
        $redirect_uri = is_string($oauth2_redirect_url) ? $oauth2_redirect_url : $this->oauth2_redirect_url;
        $result = $this->request( 'POST', Constants::URL_OAUTH2_TOKEN, $this->request_headers(), [
            'grant_type'    => 'authorization_code',
            'client_id'     => $this->oauth2_client_id,
            'client_secret' => $this->oauth2_client_secret,
            'redirect_uri'  => $redirect_uri,
            'code'          => $authorization_code
        ], true);

        /* provide an absolute value as token expiry timestamp. */
        if (property_exists($result, 'expires_in')) {
            $result->token_expiry = time() + $result->expires_in;
            unset($result->expires_in);
        }
        return $result;
    }

    /**
     * Obtaining an access token by trading a refresh token.
     * Intentionally returning the raw response, because the expiry timestamp is relevant.
     * @param string $refresh_token
     * @return stdClass|null the retrieved token object.
     */
    public function get_access_token_by_refresh_token( string $refresh_token ): stdClass|bool {
        $result = $this->request( 'POST', Constants::URL_OAUTH2_TOKEN, $this->request_headers(), [
            'grant_type'    => 'refresh_token',
            'client_id'     => $this->oauth2_client_id,
            'client_secret' => $this->oauth2_client_secret,
            'refresh_token' => $refresh_token
        ], true);

        /* provide an absolute value as token expiry timestamp. */
        if (property_exists($result, 'expires_in')) {
            $result->token_expiry = time() + $result->expires_in;
            unset($result->expires_in);
        }
        return $result;
    }

    /**
     * Revoke an access or refresh token.
     * @param string $access_or_refresh_token
     * @return stdClass|bool an empty response.
     */
    public function revoke_token( string $access_or_refresh_token ): stdClass|bool {
        return $this->request( 'POST', Constants::URL_OAUTH2_TOKEN_REVOCATION, $this->request_headers(), [
            'token' => $access_or_refresh_token
        ], true);
    }

    /**
     * Parse an Access Token.
     * @param string $access_token
     * @return TokenInfo|null
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-gettokeninfo-0000001050050585">Parsing an Access Token</a>
     */
    public function parse_access_token( string $access_token ): stdClass|null {
        $result = $this->request( 'POST', Constants::URL_ACCOUNT_KIT_TOKEN_INFO, $this->auth_headers(), [
            'access_token' => $access_token,
            'getNickName' => 1
        ], true);
        if ( is_object( $result ) ) {
            if ( property_exists( $result, 'error' ) && property_exists( $result, 'sub_error' )) {
                die( 'TokenInfo Error '.$result->error.' / '.$result->sub_error.' -> '.$result->error_description );
            } else {
                return $result;
            }
        }
        return null;
    }

    /**
     * Obtain User Information.
     * @param string $user_access_token
     * @return UserInfo|null
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/get-user-info-0000001060261938">Obtaining User Information</a>
     */
    public function get_user_info( string $user_access_token ): UserInfo|stdClass {
        return $this->request( 'POST', Constants::URL_ACCOUNT_KIT_USER_INFO, $this->auth_headers(), [
            'access_token' => $user_access_token
        ], true);
    }

    /**
     * Verify an ID Token.
     * @param string $id_token
     * @return IdTokenInfo|null
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-verify-id-token_hms_reference-0000001050050577">Verifying an ID Token</a>
     */
    public function verify_id_token( string $id_token ): stdClass|IdTokenInfo {
        $result = $this->request( 'POST', Constants::URL_OAUTH2_TOKEN_INFO, $this->auth_headers(), [
            'id_token' => $id_token
        ], true);

        if ( property_exists( $result, 'error' ) && property_exists( $result, 'sub_error' )) {
            // die( 'oAuth2 Error '.$result->error.' / '.$result->sub_error.' -> '.$result->error_description );
            return $result;
        } else if ( property_exists( $result, 'error' ) ) {
            // die( 'oAuth2 Error -> '.$result->error );
            return $result;
        } else if ( property_exists( $result, 'code' ) && $result->code != 200 ) {
            return $result;
        } else {
            return new IdTokenInfo( $result );
        }
    }

    /**
     * @param bool|stdClass $result
     * @return string|null
     */
    public function parse_result(bool|stdClass $result): string|null {
        if (is_object($result)) {
            if (property_exists($result, 'error') && property_exists($result, 'sub_error')) {
                die('oAuth2 Error ' . $result->error . ' / ' . $result->sub_error . ' -> ' . $result->error_description);
            } else {
                if (property_exists($result, 'access_token')) {
                    $this->access_token = $result->access_token;
                }
                if (property_exists($result, 'refresh_token')) {
                    $this->refresh_token = $result->refresh_token;
                }
                if (property_exists($result, 'id_token')) {
                    $this->id_token = $result->id_token;
                }
                if (property_exists($result, 'expires_in')) {
                    $this->token_expiry = time() + $result->expires_in;
                    unset($result->expires_in);
                }
                if (property_exists($result, 'scope')) {
                    $this->oauth2_api_scope = $result->scope;
                }
            }
        }
        return $this->access_token;
    }

    /**
     * @return string the URL to redirect the browser to.
     */
    public function get_login_url( ?string $redirect_url=null ): string {
        $redirect_uri = is_string($redirect_url) ? $redirect_url : $this->oauth2_redirect_url;
        return Constants::URL_OAUTH2_TOKEN_AUTHORIZATION . '?' .
            http_build_query([
                'response_type' => 'code',
                'access_type' => 'offline',
                'state' => 'state_parameter_passthrough_value',
                'redirect_uri' => $redirect_uri,
                'client_id' => $this->oauth2_client_id,
                'scope' => $this->oauth2_api_scope
            ]);
    }
}
