<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\Tile;

use HMS\MapKit\Constants;
use HMS\MapKit\MapKit;

/**
 * Class HMS MapKit Tile API
 *
 * @author Martin Zeitler
 */
class Tile extends MapKit {

    private string $url_tile;

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->setTileUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_MAP_TILE_URL . $config['api_key'] );
    }

    private function setTileUrl(string $value): void {
        $this->url_tile = $value;
    }

    private function getTileUrl(): string {
        return $this->url_tile;
    }
}
