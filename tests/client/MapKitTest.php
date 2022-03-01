<?php
namespace Tests\client;

use HMS\MapKit\Coordinate;
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

    private static Coordinate $point_a;
    private static Coordinate $point_b;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        parent::setUpBeforeClass();

        self::$client = new MapKit( self::get_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );

        // 48.14291,11.57934
        self::$point_a = new Coordinate(['lat' => -4.66529, 'lng' => 54.216608]);
        self::$point_b = new Coordinate(['lat' => -4.66552, 'lng' => 54.2166]);
    }

    /** Test: Directions */
    public function test_directions_api() {

        $endpoint = self::$client->getDirections();
        self::assertTrue( is_string($endpoint->getWalkingUrl()) );
        self::assertTrue( is_string($endpoint->getCyclingUrl()) );
        self::assertTrue( is_string($endpoint->getDrivingUrl()) );

        $result_a = $endpoint->getWalkingDirections(self::$point_a, self::$point_b);
        $result_b = $endpoint->getCyclingDirections(self::$point_a, self::$point_b);
        $result_c = $endpoint->getDrivingDirections(self::$point_a, self::$point_b);
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
