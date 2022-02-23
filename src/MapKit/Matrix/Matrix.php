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
        $this->setWalkingUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_WALKING_MATRIX_URL . $api_key);
        $this->setCyclingUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_CYCLING_MATRIX_URL . $api_key);
        $this->setDrivingUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_DRIVING_MATRIX_URL . $api_key);
    }

    private function setWalkingUrl(string $value): void {
        $this->url_walking = $value;
    }

    private function setCyclingUrl(string $value): void {
        $this->url_cycling = $value;
    }

    private function setDrivingUrl(string $value): void {
        $this->url_driving = $value;
    }

    public function getWalkingUrl(): string {
        return $this->url_walking;
    }

    public function getCyclingUrl(): string {
        return $this->url_cycling;
    }

    public function getDrivingUrl(): string {
        return $this->url_driving;
    }
}
