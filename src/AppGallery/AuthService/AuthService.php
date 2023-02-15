<?php
namespace HMS\AppGallery\AuthService;

use HMS\AppGallery\Constants;
use HMS\Core\Wrapper;
use JetBrains\PhpStorm\ArrayShape;
use stdClass;

/**
 * Class HMS AppGallery AuthService Wrapper
 *
 * Callers of this API include administrators, app administrators, and development and operations personnel.
 *
 * @author Martin Zeitler
 */
class AuthService extends Wrapper {

    /** Constructor. */
    public function __construct( array|string $config ) {
        $this->base_url = Constants::CONNECT_API_BASE_URL;
        if (isset($config['base_url'])) {$this->base_url = $config['base_url'];}
        parent::__construct( $config );
        $this->access_token = $this->get_access_token();
        $this->post_init();
    }
    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        $urls = [Constants::CONNECT_API_BASE_URL, Constants::CONNECT_API_BASE_URL_EU, Constants::CONNECT_API_BASE_URL_AS, Constants::CONNECT_API_BASE_URL_RU];
        if (! in_array($this->base_url, $urls)) {
            throw new \InvalidArgumentException('AuthService permits these base_url values: '. implode(', ', $urls));
        }
    }

    /**
     * Obtaining a Token, the AgConnect Version.
     * @return string|null the token string only.
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-obtain_token-0000001158365043">Obtaining a Token</a>
     */
    private function get_access_token(): ?string {
        $url = $this->base_url.Constants::CONNECT_API_OAUTH2_TOKEN_URL;
        $result = $this->request( 'POST',$url, $this->request_headers(), [
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
            'Authorization' => "Bearer $this->access_token",
            'client_id' => $this->agc_client_id
        ];
    }

    /**
     * Importing Users.
     *
     * @param array $users
     * @return bool|stdClass
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892">Importing Users</a>
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
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-import-0000001136020892">Exporting Users</a>
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
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-verify-0000001182300271">Authenticating a User's Access Token</a>
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
     * @see <a href="https://developer.huawei.com/consumer/de/doc/development/AppGallery-connect-References/server-rest-revoke-0000001182420193">Authenticating a User's Access Token</a>
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
