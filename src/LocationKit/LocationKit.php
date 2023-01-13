<?php
namespace HMS\LocationKit;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;
use HMS\LocationKit\GeoLocation\GeoLocation;
use HMS\LocationKit\IPLocation\IPLocation;

/**
 * Class HMS LocationKit Wrapper
 * Note: Not being implemented.
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/web-overview-0000001052619173">LocationKit</a>
 * @see <a href="https://developer.huawei.com/consumer/en/console#/myApi/">HMS API</a>
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

    public function getGeoLocation(string $geocode): GeoLocation {
        return new GeoLocation( [
            'access_token' => $this->access_token,
            'geocode' => $geocode
        ] );
    }

    public function getIPLocation(string $ip_address): IPLocation {
        return new IPLocation( [
            'access_token' => $this->access_token,
            'ip_address' => $ip_address
        ] );
    }
}
