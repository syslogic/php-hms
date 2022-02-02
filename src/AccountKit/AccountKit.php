<?php
namespace HMS\AccountKit;

use HMS\Core\Wrapper;

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
        parent::__construct( $config );
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
        return $this->access_token;
    }

    /**
     * TODO: Parse an Access Token.
     *
     * @param string|null $access_token
     * @return bool
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-gettokeninfo-0000001050050585">Parsing an Access Token</a>
     */
    public function parse_access_token( string|null $access_token ): bool {
        $result = $this->curl_request('POST', $this->url_token_info, [
            'access_token' => $access_token,
            'getNickName' => 1
        ], [
            'Content-Type: application/x-www-form-urlencoded;charset=utf-8',
            "Authorization: Bearer $this->access_token"
        ]);
        if ( is_object( $result ) ) {

        }
        return true;
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
     * TODO: Obtain User Information.
     *
     * @param string|null $user_access_token
     * @return UserInfo|null
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/get-user-info-0000001060261938">Obtaining User Information</a>
     */
    public function get_user_info( string|null $user_access_token ): UserInfo|null {
        $result = $this->curl_request('POST', $this->url_user_info, [
            'access_token' => $user_access_token,
            'getNickName' => 1
        ], [
            'Content-Type: application/x-www-form-urlencoded;charset=utf-8',
            "Authorization: Bearer $this->access_token" // OK
        ]);
        if ( is_object( $result ) ) {
            if ( property_exists( $result, 'error' ) && property_exists( $result, 'sub_error' )) {
                die( 'oAuth2 Error '.$result->error.' / '.$result->sub_error.' -> '.$result->error_description );
            } else if ( property_exists( $result, 'error' ) ) {
                die( 'oAuth2 Error -> '.$result->error );
            } else {
                return new UserInfo( $result );
            }
        }
        return null;
    }
}
