<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\SnapToRoads;

use HMS\MapKit\Constants;

/**
 * Class HMS MapKit Snap To Roads API
 *
 * @author Martin Zeitler
 */
class SnapToRoads {

    private string $url_snap;

    public function __construct(string $api_key ) {
        $this->setSnapUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_SNAP_TO_ROADS_URL . $api_key );
    }

    private function setSnapUrl(string $value): void {
        $this->url_snap = $value;
    }

    public function getSnapUrl(): string {
        return $this->url_snap;
    }
}
