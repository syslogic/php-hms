<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\Matrix;

use HMS\MapKit\Constants;

/**
 * Class HMS MapKit Matrix API
 *
 * @author Martin Zeitler
 */
class Matrix {

    private string $url_walking;
    private string $url_cycling;
    private string $url_driving;

    public function __construct( string $api_key ) {
        $this->url_walking = Constants::MAPKIT_BASE_URL . Constants::MAPKIT_WALKING_MATRIX_URL . $api_key;
        $this->url_cycling = Constants::MAPKIT_BASE_URL . Constants::MAPKIT_CYCLING_MATRIX_URL . $api_key;
        $this->url_driving = Constants::MAPKIT_BASE_URL . Constants::MAPKIT_DRIVING_MATRIX_URL . $api_key;
    }
}
