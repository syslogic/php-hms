<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\Elevation;

use HMS\MapKit\Constants;
use HMS\MapKit\Coordinate;
use HMS\MapKit\MapKit;
use stdClass;

/**
 * Class HMS MapKit Elevation API
 *
 * @author Martin Zeitler
 */
class Elevation extends MapKit {

    private string $url_elevation;

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setElevationUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_ELEVATION_URL . urlencode($this->api_key));
    }

    private function setElevationUrl(string $value): void {
        $this->url_elevation = $value;
    }

    private function getElevationUrl(): string {
        return $this->url_elevation;
    }

    /**
     * Elevation API
     *
     * @param array $locations        Collection of 1 to 512 longitude-latitude coordinates, which are used to calculate the altitude.
     * @param string $encodedLocation Language of the returned result. Currently,
     *                            only zh_CN (Chinese) and en (English) are supported.
     * @param array $policies     Specified policy for calculating routes.
     *                            The options are as follows:
     *                            0: Take least time.
     *                            8: Avoid ferry.
     * @return bool|stdClass
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/elevation-api-0000001158669981">Elevation API</a>
     */
    public function getElevations(array $locations, string $encodedLocation=null, array $policies=[0]): bool|stdClass {
        foreach ($locations as $key => $value) {$locations[$key] = $value->asObject();}
        return $this->guzzle_post($this->getElevationUrl(), [
            'Content-Type' => 'application/json'
        ], [
            'locations' => $locations
        ]);
    }

}
