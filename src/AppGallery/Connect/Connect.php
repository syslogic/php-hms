<?php
namespace HMS\AppGallery\Connect;

use HMS\Core\Wrapper;

/**
 * Class HMS AppGallery Connect Wrapper
 *
 * @property int $app_id
 * @property string|null $app_secret
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-Guides/agcapi-getstarted-0000001111845114">Getting Started</a>
 * @author Martin Zeitler
 */
class Connect extends Wrapper {

    private string $url_token;
    protected string|null $agc_client_id = null;
    protected string|null $agc_client_key = null;
    protected string|null $access_token = null;

    /** Constructor. */
    public function __construct( array|string $config ) {

        parent::__construct( $config );
        $this->url_token  = Constants::URL_OAUTH2_TOKEN;
        $this->agc_client_id = getenv('HUAWEI_CONNECT_API_CLIENT_ID');
        $this->agc_client_key = getenv('HUAWEI_CONNECT_API_CLIENT_KEY');
    }

    /**
     * POST: Obtaining a Token.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-obtain_token-0000001158365043">Obtaining a Token</a>
     */
    public function get_access_token(): string|null {
        $result = $this->curl_request('POST', $this->url_token, [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->agc_client_id,
            'client_secret' => $this->agc_client_key
        ], ['Content-Type: application/json;charset=utf-8'], false);
        if ( is_object( $result ) ) {
            if ( property_exists( $result, 'ret' ) && property_exists( $result->ret, 'code' )) {
                die( 'oAuth2 Error '.$result->ret->code.' -> '.$result->ret->msg);
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
