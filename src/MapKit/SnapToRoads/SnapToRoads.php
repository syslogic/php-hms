<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\SnapToRoads;

use HMS\MapKit\Constants;

/**
 * Class HMS MapKit Snap To Roads API
 *
 * @author Martin Zeitler
 */
class SnapToRoads {

    private string $base_url;

    public function __construct(string $api_key ) {
        $this->base_url = Constants::MAPKIT_BASE_URL . Constants::MAPKIT_SNAP_TO_ROADS_URL . $api_key;
    }
}
