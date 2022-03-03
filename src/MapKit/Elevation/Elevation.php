<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\Elevation;

use HMS\MapKit\Constants;
use HMS\MapKit\MapKit;

/**
 * Class HMS MapKit Elevation API
 *
 * @author Martin Zeitler
 */
class Elevation extends MapKit {

    private string $url_elevation;

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setElevationUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_ELEVATION_URL . $config['api_key']);
    }

    private function setElevationUrl(string $value): void {
        $this->url_elevation = $value;
    }

    private function getElevationUrl(): string {
        return $this->url_elevation;
    }
}
