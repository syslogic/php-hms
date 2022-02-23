<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\Directions;

use HMS\MapKit\Constants;

/**
 * Class HMS MapKit Directions API
 *
 * @author Martin Zeitler
 */
class Directions {

    private string $url_walking;
    private string $url_cycling;
    private string $url_driving;

    public function __construct(string $api_key ) {
        $this->url_walking = Constants::MAPKIT_BASE_URL . Constants::MAPKIT_WALKING_DIRECTIONS_URL . $api_key;
        $this->url_cycling = Constants::MAPKIT_BASE_URL . Constants::MAPKIT_CYCLING_DIRECTIONS_URL . $api_key;
        $this->url_driving = Constants::MAPKIT_BASE_URL . Constants::MAPKIT_DRIVING_DIRECTIONS_URL . $api_key;
    }
}
