<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\StaticMap;

use HMS\MapKit\Constants;
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
        $this->setStaticUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_STATIC_MAP_URL . urlencode($this->api_key) );
    }

    private function setStaticUrl(string $value): void {
        $this->url_static = $value;
    }

    private function getStaticUrl(): string {
        return $this->url_static;
    }

    /**
     *
     * @return bool|stdClass The result of the API call.
     */
    public function getMap( array $points ): bool|stdClass {
        return $this->guzzle_get($this->getStaticUrl(), $this->request_headers(), [
            'points' => $points
        ]);
    }
}
