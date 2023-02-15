<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery\Product;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;

/**
 * Class HMS AppGallery Product Wrapper
 *
 * @author Martin Zeitler
 */
class Product extends Wrapper {

    public function __construct( array|string $config ) {

        parent::__construct( $config );
        $this->post_init();

        /* Obtain an access-token. */
        $account_kit = new AccountKit( $config );
        $this->access_token = $account_kit->get_access_token();
    }

    protected function post_init(): void {

    }
}
