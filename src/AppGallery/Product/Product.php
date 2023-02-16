<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery\Product;

use HMS\AppGallery\Connect;

/**
 * Class HMS AppGallery Connect Product Wrapper
 *
 * @author Martin Zeitler
 */
class Product extends Connect {

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
    }
}
