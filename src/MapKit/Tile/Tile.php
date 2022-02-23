<?php /** @noinspection PhpUnused */
namespace HMS\MapKit\Tile;

use HMS\MapKit\Constants;

/**
 * Class HMS MapKit Tile API
 *
 * @author Martin Zeitler
 */
class Tile {

    private string $base_url;

    public function __construct( string $api_key ) {
        $this->base_url = Constants::MAPKIT_BASE_URL . Constants::MAPKIT_MAP_TILE_URL . $api_key;
    }
}
