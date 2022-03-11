<?php
namespace HMS\LocationKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;
use HMS\LocationKit\GeoLocation\GeoLocation;
use HMS\LocationKit\IPLocation\IPLocation;

/**
 * Class HMS LocationKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/web-overview-0000001052619173">LocationKit</a>
 * @author Martin Zeitler
 */
class LocationKit extends Wrapper {

    public function __construct( array|string $config ) {

        parent::__construct( $config );
        $this->post_init();

        /* Obtain an access-token. */
        $account_kit = new AccountKit( $config );
        $this->access_token = $account_kit->get_access_token();
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->api_key, $this->api_signature, $this->client_id, $this->client_secret);
        unset($this->package_name, $this->product_id, $this->project_id);
        unset($this->agc_client_id, $this->agc_client_secret);
    }

    public function getGeoLocation(): GeoLocation {
        return new GeoLocation( ['app_id' => $this->app_id, 'app_secret' => $this->app_secret] );
    }

    public function getIPLocation(): IPLocation {
        return new IPLocation( ['app_id' => $this->app_id, 'app_secret' => $this->app_secret] );
    }
}
