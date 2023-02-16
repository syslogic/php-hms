<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery\Product;

use HMS\AppGallery\Connect;
use HMS\AppGallery\Constants;

/**
 * Class HMS AppGallery Connect Product Wrapper
 *
 * @author Martin Zeitler
 */
class Product extends Connect {

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->base_url = Constants::PRODUCT_API_BASE_URL;
        if (isset($config['base_url'])) {$this->base_url = $config['base_url'];}
        $this->access_token = $this->get_access_token();
    }
}
