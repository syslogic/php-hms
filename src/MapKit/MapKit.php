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
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/api-summary-desc-0000001073697904 MapKit
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/error-code-0000001050161430 Error codes
 *
 * HTTP 403 / 010027, OVER_QUERY_LIMIT:
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/about-charging-0000001051637068#section7921102111484 Subscribing to a Pay-As-You-Go Plan
 *
 * HTTP 405 / 403, REQUEST_DENIED:
 * @link https://stackoverflow.com/questions/75114598/huawei-map-kit-api-the-app-id-does-not-have-the-service-call-permission Cause Unknown
 *
 * @author Martin Zeitler
 */
class MapKit extends Wrapper {

    public function __construct( array $config ) {
        parent::__construct( $config );
        $this->post_init();
    }

    /** For MapKit only the API key matters. */
    public function is_ready(): bool {
        return !empty( $this->api_key );
    }

    /** Unset properties irrelevant to the child class. */
    protected function post_init(): void {
        unset($this->oauth2_client_id, $this->oauth2_client_secret, $this->client_id, $this->client_secret);
        unset($this->access_token, $this->refresh_token, $this->token_expiry);
        unset($this->agc_project_client_id, $this->agc_project_client_secret);
        unset($this->package_name, $this->product_id, $this->project_id);
    }

    public function getDirections(): Directions {
        return new Directions( [ 'api_key' => $this->api_key, 'debug_mode' => $this->debug_mode ] );
    }

    /** Works. */
    public function getElevation(): Elevation {
        return new Elevation( [ 'api_key' => $this->api_key, 'debug_mode' => $this->debug_mode ] );
    }

    public function getMatrix(): Matrix {
        return new Matrix( [ 'api_key' => $this->api_key, 'debug_mode' => $this->debug_mode ] );
    }

    public function getSnapToRoads(): SnapToRoads {
        return new SnapToRoads( [ 'api_key' => $this->api_key, 'debug_mode' => $this->debug_mode ] );
    }

    /** Works. Debug must be disabled, else one cannot save the PNG image data. */
    public function getStaticMap(): StaticMap {
        return new StaticMap( [ 'api_key' => $this->api_key, 'debug_mode' => false ] );
    }

    /** Works. Debug must be disabled, else one cannot save the PNG image data. */
    public function getTile(): Tile {
        return new Tile( [ 'api_key' => $this->api_key, 'debug_mode' => false ] );
    }
}
