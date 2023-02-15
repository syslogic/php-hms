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
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-Guides/agcapi-getstarted-0000001111845114">Getting Started</a>
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
    public function getAuthService( array|string $config ): AuthService {
        $base_url = isset($config['base_url']) ? $config['base_url'] : Constants::CONNECT_API_BASE_URL_EU;
        $debug_mode = $config['debug_mode'] ?? false;
        return new AuthService( [
            'project_id'        => $this->project_id,
            'agc_client_id'     => $this->agc_client_id,
            'agc_client_secret' => $this->agc_client_secret,
            'base_url'          => $base_url,
            'debug_mode'        => $debug_mode
        ] );
    }

    public function getProduct( array|string $config ): Product {
        $base_url = isset($config['base_url'])? $config['base_url'] : Constants::PRODUCT_API_BASE_URL;
        $debug_mode = $config['debug_mode'] ?? false;
        return new Product( [
            'project_id'        => $this->project_id,
            'agc_client_id'     => $this->agc_client_id,
            'agc_client_secret' => $this->agc_client_secret,
            'base_url'          => $base_url,
            'debug_mode'        => $debug_mode
        ] );
    }

    public function getProject( array|string $config ): Project {
        $base_url = isset($config['base_url'])? $config['base_url'] : Constants::PROJECT_API_BASE_URL;
        $debug_mode = $config['debug_mode'] ?? false;
        return new Project( [
            'project_id'        => $this->project_id,
            'agc_client_id'     => $this->agc_client_id,
            'agc_client_secret' => $this->agc_client_secret,
            'base_url'          => $base_url,
            'debug_mode'        => $debug_mode
        ] );
    }

    public function getPublishing( array|string $config ): Publishing {
        $base_url = isset($config['base_url'])? $config['base_url'] : Constants::PUBLISH_API_BASE_URL;
        return new Publishing( [
            'project_id'        => $this->project_id,
            'agc_client_id'     => $this->agc_client_id,
            'agc_client_secret' => $this->agc_client_secret,
            'base_url'          => $base_url,
            'debug_mode'        => true
        ] );
    }
}
