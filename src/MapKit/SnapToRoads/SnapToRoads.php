<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\SnapToRoads;

use HMS\MapKit\Constants;
use HMS\MapKit\MapKit;

/**
 * Class HMS MapKit Snap To Roads API
 *
 * @author Martin Zeitler
 */
class SnapToRoads extends MapKit {

    private string $url_snap;

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setSnapUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_SNAP_TO_ROADS_URL . $config['api_key'] );
    }

    private function setSnapUrl(string $value): void {
        $this->url_snap = $value;
    }

    private function getSnapUrl(): string {
        return $this->url_snap;
    }
}
