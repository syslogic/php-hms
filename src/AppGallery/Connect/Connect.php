<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace HMS\AppGallery\Connect;

use HMS\Core\Wrapper;

/**
 * Class HMS AppGallery Connect Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-Guides/agcapi-getstarted-0000001111845114">Getting Started</a>
 * @author Martin Zeitler
 */
class Connect extends Wrapper {

    private string $url_token;

    /** Constructor */
    public function __construct( array|string $config ) {

        parent::__construct( $config );
        $this->post_init();

        $this->url_token  = Constants::URL_OAUTH2_TOKEN;
        $this->access_token = $this->get_access_token();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->app_id, $this->app_secret, $this->client_id, $this->client_secret);
        unset($this->package_name, $this->project_id, $this->refresh_token);
        unset($this->api_key, $this->api_signature);
    }

    /**
     * POST: Obtaining a Token.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-obtain_token-0000001158365043">Obtaining a Token</a>
     */
    public function get_access_token(): string|null {
        $result = $this->guzzle_post($this->url_token,
            $this->request_headers(), [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->agc_client_id,
            'client_secret' => $this->agc_client_secret
        ]);
        if ( is_object( $result ) ) {
            if ( property_exists( $result, 'ret' ) && property_exists( $result->ret, 'code' )) {
                return $this->sanitize( $this->result );
            } else {
                if ( property_exists( $result, 'access_token' ) ) {
                    $this->access_token = $result->access_token;
                }
                if ( property_exists( $result, 'expires_in' ) ) {
                    $this->token_expiry = time() + $result->expires_in;
                }
            }
        }
        return $this->access_token;
    }
}
