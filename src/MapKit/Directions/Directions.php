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

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setWalkingUrl(Constants::MAPKIT_WALKING_DIRECTIONS_URL . urlencode($this->api_key));
        $this->setCyclingUrl(Constants::MAPKIT_CYCLING_DIRECTIONS_URL . urlencode($this->api_key));
        $this->setDrivingUrl(Constants::MAPKIT_DRIVING_DIRECTIONS_URL . urlencode($this->api_key));
        unset($this->api_key);
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
     * Route Planning: Walking -> HTTP/1.1 405 Method Not Allowed.
     *
     * @param Coordinate $point_a Longitude and latitude of the departure place.
     * @param Coordinate $point_b Longitude and latitude of the destination.
     * @param string $language    Language of the returned result.
     *                            Currently, only zh_CN (Chinese) and en (English) are supported.
     * @param array $policies     Specified policy for calculating routes.
     *                            The options are as follows:
     *                            0: Take least time.
     *                            8: Avoid ferry.
     * @return bool|stdClass      The result of the API call.
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/directions-walking-0000001050161494 Route Planning: Walking
     */
    public function getWalkingDirections(Coordinate $point_a, Coordinate $point_b, string $language='en', array $policies=[0]): bool|stdClass {
        return $this->request('POST', $this->getWalkingUrl(), $this->request_headers(), [
            'origin' => $point_a->asObject(),
            'destination' => $point_b->asObject(),
            'language' => $language,
            'avoid' => $policies
        ]);
    }

    /**
     * Route Planning: Cycling -> HTTP/1.1 405 Method Not Allowed.
     *
     * @param Coordinate $point_a Longitude and latitude of the departure place.
     * @param Coordinate $point_b Longitude and latitude of the destination.
     * @param string $language    Language of the returned result.
     *                            Currently, only zh_CN (Chinese) and en (English) are supported.
     * @param array $policies     Specified policy for calculating routes.
     *                            The options are as follows:
     *                            0: Take least time.
     *                            8: Avoid ferry.
     * @return bool|stdClass      The result of the API call.
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/directions-bicycling-0000001050163449 Route Planning: Cycling
     */
    public function getCyclingDirections(Coordinate $point_a, Coordinate $point_b, string $language='en', array $policies=[0]): bool|stdClass {
        return $this->request('POST', $this->getCyclingUrl(), $this->request_headers(), [
            'origin' => $point_a->asObject(),
            'destination' => $point_b->asObject(),
            'language' => $language,
            'avoid' => $policies
        ]);
    }

    /**
     * Route Planning: Driving -> HTTP/1.1 405 Method Not Allowed.
     *
     * TODO: the driving endpoint has more options than the others.
     *
     * @param Coordinate $point_a Longitude and latitude of the departure place.
     * @param Coordinate $point_b Longitude and latitude of the destination.
     * @param string $language    Language of the returned result.
     *                            Currently, only zh_CN (Chinese) and en (English) are supported.
     * @param array $policies     Specified policy for calculating routes.
     *                            The options are as follows:
     *                            0: Take least time.
     *                            8: Avoid ferry.
     * @return bool|stdClass      The result of the API call.
     *
     * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/directions-driving-0000001050161496 Route Planning: Driving
     */
    public function getDrivingDirections(Coordinate $point_a, Coordinate $point_b, string $language='en', array $policies=[0]): bool|stdClass {
        return $this->request('POST', $this->getDrivingUrl(), $this->request_headers(), [
            'origin' => $point_a->asObject(),
            'destination' => $point_b->asObject(),
            'language' => $language,
            'avoid' => $policies
        ]);
    }
}
