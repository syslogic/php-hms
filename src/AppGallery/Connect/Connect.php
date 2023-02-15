<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace HMS\AppGallery\Connect;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;

/**
 * Class HMS AppGallery Connect Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-Guides/agcapi-getstarted-0000001111845114">Getting Started</a>
 * @author Martin Zeitler
 */
class Connect extends Wrapper {

    /** Constructor */
    public function __construct( array|string $config ) {

        parent::__construct( $config );
        $this->post_init();

        /* Obtain an access-token. */
        $account_kit = new AccountKit( $config );
        $this->access_token = $account_kit->get_access_token();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->oauth2_client_id, $this->oauth2_client_secret, $this->client_id, $this->client_secret);
        unset($this->package_name, $this->project_id, $this->refresh_token);
        unset($this->api_key, $this->api_signature);
    }
}
