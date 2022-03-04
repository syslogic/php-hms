<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\Matrix;

use HMS\MapKit\Constants;
use HMS\MapKit\MapKit;
use stdClass;

/**
 * Class HMS MapKit Matrix API
 *
 * @author Martin Zeitler
 */
class Matrix extends MapKit {

    private string $url_walking;
    private string $url_cycling;
    private string $url_driving;

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setWalkingUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_WALKING_MATRIX_URL . urlencode($this->api_key));
        $this->setCyclingUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_CYCLING_MATRIX_URL . urlencode($this->api_key));
        $this->setDrivingUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_DRIVING_MATRIX_URL . urlencode($this->api_key));
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

    private function getWalkingUrl(): string {
        return $this->url_walking;
    }

    private function getCyclingUrl(): string {
        return $this->url_cycling;
    }

    private function getDrivingUrl(): string {
        return $this->url_driving;
    }

    /**
     * Batch Route Planning: Walking
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/matrix-walking-0000001050161506">Batch Route Planning: Walking</a>
     */
    public function getWalkingMatrix(array $origins, array $destinations, string $language='en', int $policy=0): bool|stdClass {
        foreach ($origins      as $key => $value) {$origins[$key]      = $value->asObject();}
        foreach ($destinations as $key => $value) {$destinations[$key] = $value->asObject();}
        return $this->guzzle_post($this->getWalkingUrl(), [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ], [
            'origin' => $origins,
            'destination' => $destinations,
            'language' => $language,
            'avoid' => $policy
        ]);
    }

    /**
     * Batch Route Planning: Cycling
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/matrix-bicycling-0000001050163459">Batch Route Planning: Cycling</a>
     */
    public function getCyclingMatrix(array $origins, array $destinations, string $language='en', int $policy=0): bool|stdClass {
        foreach ($origins      as $key => $value) {$origins[$key]      = $value->asObject();}
        foreach ($destinations as $key => $value) {$destinations[$key] = $value->asObject();}
        return $this->guzzle_post($this->getCyclingUrl(), [
            'Content-Type' => 'application/json'
        ], [
            'origin' => $origins,
            'destination' => $destinations,
            'language' => $language,
            'avoid' => $policy
        ]);
    }

    /**
     * Batch Route Planning: Driving
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/matrix-driving-0000001050161508">Batch Route Planning: Driving</a>
     */
    public function getDrivingMatrix(array $origins, array $destinations, string $language='en', int $policy=0): bool|stdClass {
        foreach ($origins      as $key => $value) {$origins[$key]      = $value->asObject();}
        foreach ($destinations as $key => $value) {$destinations[$key] = $value->asObject();}
        return $this->guzzle_post($this->getDrivingUrl(), [
            'Content-Type' => 'application/json'
        ], [
            'origins' => $origins,
            'destinations' => $destinations,
            'language' => $language,
            'avoid' => $policy
        ]);
    }
}
