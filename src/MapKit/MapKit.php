<?php
namespace HMS\MapKit;

use HMS\Core\Wrapper;

use HMS\MapKit\Directions\Directions;
use HMS\MapKit\Elevation\Elevation;
use HMS\MapKit\Matrix\Matrix;
use HMS\MapKit\SnapToRoads\SnapToRoads;
use HMS\MapKit\StaticMap\StaticMap;
use HMS\MapKit\Tile\Tile;

/**
 * Class HMS MapKit Wrapper
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/api-summary-desc-0000001073697904">MapKit</a>
 * @author Martin Zeitler
 */
class MapKit extends Wrapper {

    public function __construct( array|string $config ) {
        parent::__construct( $config );
    }

    /** For MapKit the API key matters. */
    public function is_ready(): bool {
        return $this->api_key != null;
    }

    public function getDirections(): Directions {
        return new Directions( $this->api_key );
    }

    public function getElevation(): Elevation {
        return new Elevation( $this->api_key );
    }

    public function getMatrix(): Matrix {
        return new Matrix( $this->api_key );
    }

    public function getSnapToRoads(): SnapToRoads {
        return new SnapToRoads( $this->api_key );
    }

    public function getStaticMap(): StaticMap {
        return new StaticMap( $this->api_key );
    }

    public function getTile(): Tile {
        return new Tile( $this->api_key );
    }
}
