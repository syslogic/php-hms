<?php
namespace HMS\AppGallery\Connect;

use HMS\Core\Wrapper;

/**
 * Class HMS AppGallery Connect Wrapper
 *
 * @author Martin Zeitler
 */
class Connect extends Wrapper {

    private string $url_token;

    /** Constructor. */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->url_token  = Constants::URL_OAUTH2_TOKEN;
    }

    /**
     * POST: Obtaining a Token.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-obtain_token-0000001158365043">Obtaining a Token</a>
     */
    public function get_token( ) {
        $payload =[];
        return $this->curl_request('POST', $this->url_token, $payload, $this->auth_header());
    }
}
