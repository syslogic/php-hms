<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\Tile;

use HMS\MapKit\Constants;

/**
 * Class HMS MapKit Tile API
 *
 * @author Martin Zeitler
 */
class Tile {

    private string $url_tile;

    public function __construct( string $api_key ) {
        $this->setTileUrl(Constants::MAPKIT_BASE_URL . Constants::MAPKIT_MAP_TILE_URL . $api_key );
    }

    private function setTileUrl(string $value): void {
        $this->url_tile = $value;
    }

    public function getTileUrl(): string {
        return $this->url_tile;
    }
}
