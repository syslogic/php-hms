<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\Elevation;

use HMS\MapKit\Constants;

/**
 * Class HMS MapKit Elevation API
 *
 * @author Martin Zeitler
 */
class Elevation {

    private string $url_elevation;

    public function __construct(string $api_key ) {
        $this->setElevationUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_ELEVATION_URL . $api_key);
    }

    private function setElevationUrl(string $value): void {
        $this->url_elevation = $value;
    }

    public function getElevationUrl(): string {
        return $this->url_elevation;
    }
}
