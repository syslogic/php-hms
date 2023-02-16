<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace HMS\AppGallery;

use HMS\AppGallery\AuthService\AuthService;
use HMS\AppGallery\Product\Product;
use HMS\AppGallery\Project\Project;
use HMS\AppGallery\Publishing\Publishing;
use HMS\Core\Wrapper;

/**
 * Class HMS AppGallery Connect Wrapper
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-Guides/agcapi-getstarted-0000001111845114 Getting Started
 * @author Martin Zeitler
 */
class Connect extends Wrapper {

    /** Constructor */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $this->post_init();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->client_id, $this->client_secret);
        unset($this->package_name, $this->refresh_token);
        unset($this->api_key, $this->api_signature);
    }

    /**
     * The base URL must match the default data storage location.
     * This endpoint requires project-level access credentials.
     */
    public function getAuthService(): AuthService {
        return new AuthService( $this->config() );
    }

    public function getProduct(): Product {
        return new Product( $this->config() );
    }

    public function getProject(): Project {
        return new Project( $this->config() );
    }

    public function getPublishing(): Publishing {
        return new Publishing( $this->config() );
    }

    private function config(): array {
        return [
            'project_id'        => $this->project_id,
            'agc_client_id'     => $this->agc_client_id,
            'agc_client_secret' => $this->agc_client_secret,
            'debug_mode'        => $this->debug_mode
        ];
    }
}
