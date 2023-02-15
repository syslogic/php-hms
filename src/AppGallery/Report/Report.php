<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery\Report;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;

/**
 * Class HMS AppGallery Report Wrapper
 *
 * @author Martin Zeitler
 */
class Report extends Wrapper {

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
