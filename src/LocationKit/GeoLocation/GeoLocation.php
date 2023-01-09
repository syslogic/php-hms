<?php /** @noinspection PhpUnused */
namespace HMS\LocationKit\GeoLocation;

use HMS\LocationKit\LocationKit;
use HMS\LocationKit\Constants;

/**
 * Class HMS LocationKit GeoLocation API
 *
 * @author Martin Zeitler
 */
class GeoLocation extends LocationKit {

    private string $url_geo_location;
    private string $geo_location;

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setGeoLocationUrl(Constants::GEO_LOCATION_BASE_URL );
        $this->setGeoLocation( $config['geo_location'] );
    }

    private function setGeoLocationUrl( string $value ): void {
        $this->url_geo_location = $value;
    }

    private function setGeoLocation( string $value ): void {
        $this->geo_location = $value;
    }

    private function getGeoLocationUrl(): string {
        return $this->url_geo_location;
    }
}
