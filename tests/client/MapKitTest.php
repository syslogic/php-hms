<?php
namespace Tests\client;

use HMS\MapKit\MapKit;
use JetBrains\PhpStorm\ArrayShape;
use Tests\BaseTestCase;

/**
 * HMS MapKit Test
 *
 * @author Martin Zeitler
 */
class MapKitTest extends BaseTestCase {

    private static MapKit|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        parent::setUpBeforeClass();

        self::$api_key = getenv('HUAWEI_MAPKIT_API_KEY');
        self::assertTrue( is_string(self::$api_key), self::ENV_VAR_MAPKIT_API_KEY );

        // self::$signature_key = getenv('HUAWEI_MAPKIT_SIGNATURE_KEY');
        // self::assertTrue( is_string(self::$signature_key),self::ENV_VAR_MAPKIT_SIGNATURE_KEY );

        self::$client = new MapKit( [ 'api_key' => self::$api_key ] );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Directions */
    public function test_directions_api() {
        $endpoint = self::$client->getDirections();
        self::assertTrue( is_string($endpoint->getWalkingUrl()) );
        self::assertTrue( is_string($endpoint->getCyclingUrl()) );
        self::assertTrue( is_string($endpoint->getDrivingUrl()) );
    }

    /** Test: Distance Matrix */
    public function test_matrix_api() {
        $endpoint = self::$client->getMatrix();
        self::assertTrue( is_string($endpoint->getWalkingUrl()) );
        self::assertTrue( is_string($endpoint->getCyclingUrl()) );
        self::assertTrue( is_string($endpoint->getDrivingUrl()) );
    }

    /** Test: Elevation */
    public function test_elevation_api() {
        $endpoint = self::$client->getElevation();
        self::assertTrue( is_string($endpoint->getElevationUrl()) );
    }

    /** Test: Snap To Roads */
    public function test_snap_to_roads_api() {
        $endpoint = self::$client->getSnapToRoads();
        self::assertTrue( is_string($endpoint->getSnapUrl()) );
    }

    /** Test: Static */
    public function test_static_api() {
        $endpoint = self::$client->getStaticMap();
        self::assertTrue( is_string($endpoint->getStaticUrl()) );
    }

    /** Test: Tile */
    public function test_tile_api() {
        $endpoint = self::$client->getTile();
        self::assertTrue( is_string($endpoint->getTileUrl()) );
    }
}
