<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\Elevation;

use HMS\MapKit\Constants;
use HMS\MapKit\MapKit;
use InvalidArgumentException;
use stdClass;

/**
 * Class HMS MapKit Elevation API
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/elevation-api-0000001158669981">Elevation API</a>
 * @author Martin Zeitler
 */
class Elevation extends MapKit {

    private string $url_elevation;

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setElevationUrl(Constants::MAPKIT_ELEVATION_URL . urlencode($this->api_key));
    }

    private function setElevationUrl(string $value): void {
        $this->url_elevation = $value;
    }

    private function getElevationUrl(): string {
        return $this->url_elevation;
    }

    /**
     * @param array $locations Collection of 1 to 512 longitude-latitude coordinates, which are used to calculate the altitude.
     * @return bool|stdClass   The result of the API call.
     */
    public function getElevationByLocations( array $locations ): bool|stdClass {
        if (sizeof($locations) == 0 || sizeof($locations) > 512) {throw new InvalidArgumentException();}
        foreach ($locations as $key => $value) {$locations[$key] = $value->asObject();}
        return $this->guzzle_post($this->getElevationUrl(),
            $this->request_headers(),
            [ 'locations' => $locations ]
        );
    }

    /**
     * @param string $encodedLocation Longitude-latitude coordinates encoded using the GeoHash algorithm.
     *                                The value can be an array of strings separated by semicolons (;).
     * @return bool|stdClass          The result of the API call.
     */
    public function getElevationByEncodedLocations( string $encodedLocation ): bool|stdClass {
        if (empty($encodedLocation)) {throw new InvalidArgumentException();}
        return $this->guzzle_post($this->getElevationUrl(),
            $this->request_headers(),
            [ 'encodedLocation' => $encodedLocation ]
        );
    }

    /**
     * @param array $path    Specified path for calculating the altitude.
     *                       The value is a collection of longitude-latitude coordinates along the path.
     * @return bool|stdClass The result of the API call.
     */
    public function getElevationByPath(array $path): bool|stdClass {
        if (sizeof($path) == 0) {throw new InvalidArgumentException();}
        foreach ($path as $key => $value) {$path[$key] = $value->asObject();}
        return $this->guzzle_post($this->getElevationUrl(),
            $this->request_headers(),
            [ 'path' => $path ]
        );
    }

    /**
     * @param string $encodedPath Longitude-latitude coordinates in the path, which are encoded using the GeoHash algorithm.
     *                            The value can be an array of strings separated by semicolons (;).
     * @param int $samples        Number of sampling points in the path. This parameter is used to generate the specified
     *                            number of equidistant sampling points in the path specified by path or encodedPath.
     *                            The path start and end points are also counted in the number of sampling points.
     *                            This parameter is mandatory if path or encodedPath is passed.
     * @return bool|stdClass      The result of the API call.
     */
    public function getElevationByEncodedPath(string $encodedPath, int $samples): bool|stdClass {
        if (empty($encodedPath)) {throw new InvalidArgumentException();}
        if ($samples < 1) {throw new InvalidArgumentException();}
        return $this->guzzle_post($this->getElevationUrl(),
            $this->request_headers(),
            [ 'encodedPath' => $encodedPath, 'samples' => $samples ]
        );
    }
}
