<?php /** @noinspection PhpUnused */
namespace HMS\LocationKit\GeoLocation;

use HMS\LocationKit\Constants;
use HMS\LocationKit\LocationKit;
use stdClass;

/**
 * Class HMS LocationKit GeoLocation API
 * Note: Not being implemented.
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/web-network-location-0000001051602603 GeoLocation (API)
 * @author Martin Zeitler
 */
class GeoLocation extends LocationKit {

    public function __construct( array $config ) {
        parent::__construct( $config );
        if ( isset($config['geocode']) ) {
            $this->get_geo_location( $config['geocode'] );
        }
        return $this;
    }

    private function get_geo_location( string $value ): GeoLocation {
        $payload = ['geocode' => $value ];
        $this->result = $this->request('POST', Constants::GEO_LOCATION_URL, $this->auth_headers(), $payload);
        return $this;
    }

    public function get_result(): stdClass {
        return $this->result;
    }
}
