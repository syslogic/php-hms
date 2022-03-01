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
 * It only uses API key, not OAuth2 token.
 *
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/api-summary-desc-0000001073697904">MapKit</a>
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/error-code-0000001050161430">Error codes</a>
 *
 * HTTP 403 / 010027, OVER_QUERY_LIMIT:
 * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/about-charging-0000001051637068#section7921102111484">Subscribing to a Pay-As-You-Go Plan</a>
 * @author Martin Zeitler
 */
class MapKit extends Wrapper {

    public function __construct( array $config ) {
        parent::__construct( $config );
    }

    /** For MapKit the API key matters. */
    public function is_ready(): bool {
        return !empty( $this->api_key );
    }

    public function getDirections(): Directions {
        return new Directions( ['api_key' => $this->api_key] );
    }

    public function getElevation(): Elevation {
        return new Elevation( ['api_key' => $this->api_key] );
    }

    public function getMatrix(): Matrix {
        return new Matrix( ['api_key' => $this->api_key] );
    }

    public function getSnapToRoads(): SnapToRoads {
        return new SnapToRoads( ['api_key' => $this->api_key] );
    }

    public function getStaticMap(): StaticMap {
        return new StaticMap( ['api_key' => $this->api_key] );
    }

    public function getTile(): Tile {
        return new Tile( ['api_key' => $this->api_key] );
    }
}
