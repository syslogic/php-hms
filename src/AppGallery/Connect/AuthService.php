<?php
namespace HMS\AppGallery\Connect;

use HMS\Core\Wrapper;

/**
 * Class HMS AppGallery AuthService Wrapper
 *
 * @author Martin Zeitler
 */
class AuthService extends Connect {

    private static Connect|null $connect;

    private string $url_user_import;
    private string $url_user_export;
    private string $url_token_verify;
    private string $url_token_revoke;

    /** Constructor. */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->url_user_import  = Constants::CONNECT_API_BASE_URL.Constants::CONNECT_API_AUTH_SERVICE_USER_IMPORT;
        $this->url_user_export  = Constants::CONNECT_API_BASE_URL.Constants::CONNECT_API_AUTH_SERVICE_USER_EXPORT;
        $this->url_token_verify = Constants::CONNECT_API_BASE_URL.Constants::CONNECT_API_AUTH_SERVICE_VERIFY_TOKEN;
        $this->url_token_revoke = Constants::CONNECT_API_BASE_URL.Constants::CONNECT_API_AUTH_SERVICE_REVOKE_TOKEN;
    }

    /**
     * POST: Importing Users.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892">Importing Users</a>
     */
    public function import_users( array $users ) {
        $payload = ['users' => $users];
        return $this->guzzle_post($this->url_user_import, $this->auth_header(), $payload);
    }

    /**
     * POST: Exporting Users.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892">Exporting Users</a>
     */
    public function export_users() {
        $payload = [];
        return $this->guzzle_post($this->url_user_export, $this->auth_header(), $payload);
    }

    /**
     * GET: Authenticating a User's Access Token.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-verify-0000001182300271">Authenticating a User's Access Token</a>
     */
    public function verify_access_token() {
        $payload = [];
        return $this->guzzle_post($this->url_token_verify, $this->auth_header(), $payload);
    }

    /**
     * POST Revoking a User's Access Token.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-revoke-0000001182420193">Authenticating a User's Access Token</a>
     */
    public function revoke_access_token() {
        $payload = [];
        return $this->guzzle_post($this->url_token_revoke, $this->auth_header(), $payload, false);
    }
}
