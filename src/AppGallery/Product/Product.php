<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery\Product;

use HMS\AppGallery\Connect;
use HMS\AppGallery\Constants;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class HMS AppGallery Connect Product Wrapper
 *
 * @author Martin Zeitler
 */
class Product extends Connect {

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->base_url = Constants::CONNECT_API_BASE_URL;
        if (isset($config['base_url'])) {$this->base_url = $config['base_url'];}
        $this->access_token = $this->get_access_token(true);
    }

    /**
     * Provide HTTP request headers as array.
     *@param bool $team_admin It determines which client_id to send.
     */
    #[ArrayShape(['Content-Type' => 'string', 'Authorization' => 'string', 'client_id' => 'string', 'appId' => 'string'])]
    protected function auth_headers( bool $team_admin=false ): array {
        return [
            'Content-Type' => 'application/json;charset=utf-8',
            'Authorization' => "Bearer $this->access_token",
            'client_id' => $team_admin ? $this->agc_team_client_id : $this->agc_project_client_id,
            'appId' => $this->oauth2_client_id
        ];
    }

    /** @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-addproduct-0000001115868346 Creating a Product */
    public function add_product( array $item=[] ): \stdClass {
        $url = $this->base_url.Constants::PMS_API_PRODUCT_URL;
        $headers = $this->auth_headers(true);
        return $this->request('POST', $url, $headers, [
            'requestId' => uniqid('hms_'),
            'product' => $item
        ]);
    }
}
