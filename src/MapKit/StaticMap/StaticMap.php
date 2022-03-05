<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\StaticMap;

use HMS\MapKit\Constants;
use HMS\MapKit\Coordinate;
use HMS\MapKit\MapKit;
use stdClass;

/**
 * Class HMS MapKit Static API
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/maps-static-api-0000001059461203">Maps Static API</a>
 * @author Martin Zeitler
 */
class StaticMap extends MapKit {

    private string $url_static;

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setStaticUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_STATIC_MAP_URL );
    }

    private function setStaticUrl(string $value): void {
        $this->url_static = $value;
    }

    private function getStaticUrl(): string {
        return $this->url_static;
    }

    /**
     *
     * @param Coordinate $center Address information.
     *                           The value can be a pair of latitude and longitude or a specific address.
     *                           The latitude and longitude are in the Latitude,Longitude format, for example, 41.43206,-81.38992.
     *                           If markers and path are not set, this parameter is mandatory.
     * @param int $width         Image width.
     *                           If scale is set to 1, the value ranges from 0 (excluded) to 1024.
     *                           If scale is set to 2, the value ranges from 0 (excluded) to 512.
     * @param int $height        Image height.
     *                           If scale is set to 1, the value ranges from 0 (excluded) to 1024.
     *                           If scale is set to 2, the value ranges from 0 (excluded) to 512.
     * @param int $zoom
     * @param int $scale
     * @return bool|stdClass The result of the API call.
     */
    public function getStaticMapByLocation( Coordinate $center, int $width, int $height, int $zoom=10, $scale=1 ): bool|stdClass {
        return $this->guzzle_get($this->getStaticUrl(), $this->request_headers(), [
            'key' => $this->api_key,
            'location' => $center->asString(),
            'width' => $width,
            'height' => $height,
            'zoom' => $zoom,
            'scale' => $scale,
        ]);
    }
}
