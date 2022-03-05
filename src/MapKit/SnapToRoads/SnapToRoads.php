<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\SnapToRoads;

use HMS\MapKit\Constants;
use HMS\MapKit\MapKit;
use InvalidArgumentException;
use stdClass;

/**
 * Class HMS MapKit Snap To Roads API
 *
 * @author Martin Zeitler
 */
class SnapToRoads extends MapKit {

    private string $url_snap;

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setSnapUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_SNAP_TO_ROADS_URL . urlencode($this->api_key) );
    }

    private function setSnapUrl( string $value ): void {
        $this->url_snap = $value;
    }

    private function getSnapUrl(): string {
        return $this->url_snap;
    }

    /**
     * @param array $points  Coordinate points on the road.
     *                       The number of coordinate points cannot exceed 100 and
     *                       the distance between two adjacent points must be less than 500 meters.
     * @return bool|stdClass The result of the API call.
     */
    public function snapToRoad( array $points ): bool|stdClass {
        if (sizeof($points) == 0 || sizeof($points) > 100) {
            throw new InvalidArgumentException();
        }
        foreach ($points as $key => $value) {$points[$key] = $value->asObject();}
        return $this->guzzle_post($this->getSnapUrl(), $this->request_headers(), [
            'points' => $points
        ]);
    }
}
