<?php
namespace HMS\AppGallery\AuthService;

use HMS\AppGallery\Connect;
use HMS\AppGallery\Constants;
use stdClass;

/**
 * Class HMS AppGallery Connect AuthService Wrapper
 *
 * Callers of this API include administrators, app administrators, and development and operations personnel.
 *
 * @author Martin Zeitler
 */
class AuthService extends Connect {

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->base_url = Constants::CONNECT_API_BASE_URL;
        if (isset($config['base_url'])) {$this->base_url = $config['base_url'];}
        $this->access_token = $this->get_access_token();
    }

    /**
     * Importing Users.
     *
     * @link https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892 Importing Users
     * @param array $users
     * @return bool|stdClass
     */
    public function import_users( array $users ): bool|stdClass {
        $url = $this->base_url.Constants::CONNECT_API_AUTH_SERVICE_USER_IMPORT;
        $headers = array_merge($this->auth_headers(), ['productId' => $this->project_id]);
        $payload = ['users' => $users];
        return $this->request('POST', $url, $headers, $payload);
    }

    /**
     * Exporting Users.
     *
     * @link https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892 Exporting Users
     * @return bool|stdClass
     */
    public function export_users(): bool|stdClass {
        $url = $this->base_url.Constants::CONNECT_API_AUTH_SERVICE_USER_EXPORT;
        $headers = array_merge($this->auth_headers(), ['productId' => $this->project_id]);
        $payload = ['block' => 0];
        return $this->request('POST', $url, $headers, $payload);
    }

    /**
     * Authenticating a User's Access Token.
     *
     * @link https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-verify-0000001182300271 Authenticating a User's Access Token
     * @param string $user_access_token
     * @return bool|stdClass
     */
    public function verify_access_token( string $user_access_token ): bool|stdClass {
        $url = str_replace('{projectId}', $this->project_id, $this->base_url.Constants::CONNECT_API_AUTH_SERVICE_VERIFY_TOKEN);
        $headers = array_merge($this->auth_headers(), ['accessToken' => $user_access_token]);
        return $this->request('GET', $url, $headers);
    }

    /**
     * Revoking a User's Access Token.
     *
     * @link https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-revoke-0000001182420193 Authenticating a User's Access Token
     * @param string $uid
     * @param string $user_access_token
     * @return bool|stdClass
     */
    public function revoke_access_token( string $uid, string $user_access_token ): bool|stdClass {
        $url = str_replace('{projectId}', $this->project_id, $this->base_url.Constants::CONNECT_API_AUTH_SERVICE_REVOKE_TOKEN);
        $headers = array_merge($this->auth_headers(), ['uid' => $uid]);
        return $this->request('POST', $url, $headers);
    }
}
