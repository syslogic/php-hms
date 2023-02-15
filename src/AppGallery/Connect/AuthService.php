<?php
namespace HMS\AppGallery\Connect;

use stdClass;

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
        parent::post_init();

        $this->url_user_import  = Constants::CONNECT_API_BASE_URL.Constants::CONNECT_API_AUTH_SERVICE_USER_IMPORT;
        $this->url_user_export  = Constants::CONNECT_API_BASE_URL.Constants::CONNECT_API_AUTH_SERVICE_USER_EXPORT;
        $this->url_token_verify = Constants::CONNECT_API_BASE_URL.Constants::CONNECT_API_AUTH_SERVICE_VERIFY_TOKEN;
        $this->url_token_revoke = Constants::CONNECT_API_BASE_URL.Constants::CONNECT_API_AUTH_SERVICE_REVOKE_TOKEN;
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
        return $this->request('POST', $this->url_user_import, $this->auth_headers(), $payload);
    }

    /**
     * POST: Exporting Users.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892">Exporting Users</a>
     * @return bool|stdClass
     */
    public function export_users(): bool|stdClass {
        $payload = [];
        return $this->request('POST', $this->url_user_export, $this->auth_headers(), $payload);
    }

    /**
     * GET: Authenticating a User's Access Token.
     * TODO: being unsure about parameter name `token`.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-verify-0000001182300271">Authenticating a User's Access Token</a>
     * @param string $user_access_token
     * @return bool|stdClass
     */
    public function verify_access_token( string $user_access_token ): bool|stdClass {
        $payload = [ 'token' => $user_access_token ];
        return $this->request('POST', $this->url_token_verify, $this->auth_headers(), $payload);
    }

    /**
     * POST Revoking a User's Access Token.
     * TODO: being unsure about parameter name `token`.
     *
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-revoke-0000001182420193">Authenticating a User's Access Token</a>
     * @param string $user_access_token
     * @return bool|stdClass
     */
    public function revoke_access_token( string $user_access_token ): bool|stdClass {
        $payload = [ 'token' => $user_access_token ];
        return $this->request('POST', $this->url_token_revoke, $this->auth_headers(), $payload);
    }
}
