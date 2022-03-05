<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\Tile;

use HMS\MapKit\Constants;
use HMS\MapKit\MapKit;
use stdClass;

/**
 * Class HMS MapKit Tile API
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/tile-api-0000001059859346">Tile API</a>
 * @author Martin Zeitler
 */
class Tile extends MapKit {

    private string $url_tile;

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setTileUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_MAP_TILE_URL );
    }

    private function setTileUrl(string $value): void {
        $this->url_tile = $value;
    }

    private function getTileUrl(): string {
        return $this->url_tile;
    }

    /**
     * @param int $x X coordinate. The value ranges from 0 to 1048576.
     * @param int $y Y coordinate. The value ranges from 0 to 1048576.
     * @param int $z Zoom level. The value is no less than 0.
     * @param string $language Map display language. The value is a language code complying with ISO 639-2 or BCP47. BCP47 is recommended.
     * @param int $scale       Map scale. The options are 1 and 2. The default value is 1.
     * @return bool|stdClass The result of the API call.
     */
    public function getMapTile( int $x, int $y, int $z=0, string $language='en', int $scale=1 ): bool|stdClass {
        return $this->guzzle_get($this->getTileUrl(), $this->request_headers(), [
            'key' => $this->api_key,
            'x' => $x,
            'y' => $y,
            'z' => $z,
            'language' => $language,
            'scale' => $scale
        ]);
    }
}
