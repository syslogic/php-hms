<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\Directions;

use HMS\MapKit\Constants;
use HMS\MapKit\Coordinate;
use HMS\MapKit\MapKit;
use stdClass;

/**
 * Class HMS MapKit Directions API
 *
 * @author Martin Zeitler
 */
class Directions extends MapKit {

    private string $url_walking;
    private string $url_cycling;
    private string $url_driving;

    private string $language = 'en';

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setWalkingUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_WALKING_DIRECTIONS_URL . rawurlencode($config['api_key']));
        $this->setCyclingUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_CYCLING_DIRECTIONS_URL . rawurlencode($config['api_key']));
        $this->setDrivingUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_DRIVING_DIRECTIONS_URL . rawurlencode($config['api_key']));
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

    public function getWalkingDirections(Coordinate $point_a, Coordinate $point_b): bool|stdClass {
        return $this->guzzle_request('POST', $this->getWalkingUrl(), [
            'Content-Type' => 'application/json; charset=utf-8'
        ], [
            'origin' => $point_a->asObject(),
            'destination' => $point_b->asObject(),
            'language' => $this->language
        ]);
    }

    public function getCyclingDirections(Coordinate $point_a, Coordinate $point_b): bool|stdClass {
        return $this->guzzle_request('POST', $this->getCyclingUrl(), [
            'Content-Type' => 'application/json; charset=utf-8'
        ], [
            'origin' => $point_a->asObject(),
            'destination' => $point_b->asObject(),
            'language' => $this->language
        ]);
    }

    public function getDrivingDirections(Coordinate $point_a, Coordinate $point_b): bool|stdClass {
        return $this->guzzle_request('POST', $this->getDrivingUrl(), [
            'Content-Type' => 'application/json; charset=utf-8'
        ], [
            'origin' => $point_a->asObject(),
            'destination' => $point_b->asObject(),
            'language' => $this->language
        ]);
    }
}
