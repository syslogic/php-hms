<?php
namespace HMS\AppGallery\Connect;

use HMS\AppGallery\Constants;
use JetBrains\PhpStorm\ArrayShape;
use stdClass;

/**
 * Class HMS AppGallery AuthService Wrapper
 *
 * Callers of this API include administrators, app administrators, and development and operations personnel.
 *
 * @author Martin Zeitler
 */
class AuthService extends Connect {

    private string $url_user_import;
    private string $url_user_export;
    private string $url_token_verify;
    private string $url_token_revoke;

    /** Constructor. */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->url_user_import  = Constants::CONNECT_API_BASE_URL.Constants::CONNECT_API_AUTH_SERVICE_USER_IMPORT;
        $this->url_user_export  = Constants::CONNECT_API_BASE_URL.Constants::CONNECT_API_AUTH_SERVICE_USER_EXPORT;
        $this->url_token_verify = str_replace('{productId}', $this->product_id, Constants::CONNECT_API_BASE_URL.Constants::CONNECT_API_AUTH_SERVICE_VERIFY_TOKEN);
        $this->url_token_revoke = str_replace('{productId}', $this->product_id, Constants::CONNECT_API_BASE_URL.Constants::CONNECT_API_AUTH_SERVICE_REVOKE_TOKEN);
        $this->access_token = $this->get_access_token();
    }

    /**
     * Obtaining an Access Token.
     * @return string|null the token string only.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/account-obtain-token_hms_reference-0000001050048618">Obtaining Access Token</a>
     */
    private function get_access_token(): ?string {
        $result = $this->request( 'POST',Constants::CONNECT_API_OAUTH2_TOKEN_URL, $this->request_headers(), [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->agc_client_id,
            'client_secret' => $this->agc_client_secret
        ] );
        if (property_exists($result, 'access_token')) {
            return $result->access_token;
        }
        return null;
    }

    /** Provide HTTP request headers as array. */
    #[ArrayShape(['Content-Type' => 'string', 'Authorization' => 'string', 'client_id' => 'string'])]
    protected function auth_headers(): array {
        return [
            'Content-Type' => 'application/json;charset=utf-8',
            'Authorization' => ' Bearer ' . $this->access_token,
            'client_id' => $this->agc_client_id
        ];
    }

    /**
     * POST: Importing Users.
     *
     * @param array $users
     * @return bool|stdClass
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892">Importing Users</a>
     */
    public function import_users( array $users ): bool|stdClass {
        $payload = ['users' => $users];
        $headers = array_merge($this->auth_headers(), ['productId' => $this->product_id]);
        return $this->request('POST', $this->url_user_import, $headers, $payload);
    }

    /**
     * POST: Exporting Users.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892">Exporting Users</a>
     * @return bool|stdClass
     */
    public function export_users(): bool|stdClass {
        $headers = array_merge($this->auth_headers(), ['productId' => $this->product_id]);
        return $this->request('POST', $this->url_user_export, $headers);
    }

    /**
     * GET: Authenticating a User's Access Token.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-verify-0000001182300271">Authenticating a User's Access Token</a>
     * @param string $user_access_token
     * @return bool|stdClass
     */
    public function verify_access_token( string $user_access_token ): bool|stdClass {
        $headers = array_merge($this->auth_headers(), ['accessToken' => $user_access_token]);
        return $this->request('GET', $this->url_token_verify, $headers);
    }

    /**
     * POST Revoking a User's Access Token.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-revoke-0000001182420193">Authenticating a User's Access Token</a>
     * @param string $user_access_token
     * @return bool|stdClass
     */
    public function revoke_access_token( string $uid, string $user_access_token ): bool|stdClass {
        $headers = array_merge($this->auth_headers(), ['uid' => $uid]);
        return $this->request('POST', $this->url_token_revoke, $headers);
    }
}
