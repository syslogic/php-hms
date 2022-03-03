<?php
namespace Tests;

use HMS\MapKit\Coordinate;
use HMS\MapKit\MapKit;

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

        self::$point_a = new Coordinate(['lat' => 48.14291, 'lng' => 11.57934]);
        self::$point_b = new Coordinate(['lat' => 48.14291, 'lng' => 11.57634]);
    }

    /** Test: Directions */
    public function test_directions_api() {

        /* Endpoint */
        $endpoint = self::$client->getDirections();

        /* Walking Directions */
        $result = $endpoint->getWalkingDirections(self::$point_a, self::$point_b);
        self::assertTrue( is_array($result->routes) && sizeof($result->routes) > 0 );

        /* Cycling Directions */
        $result = $endpoint->getCyclingDirections(self::$point_a, self::$point_b);
        self::assertTrue( is_array($result->routes) && sizeof($result->routes) > 0 );

        /* Driving Directions */
        $result = $endpoint->getDrivingDirections(self::$point_a, self::$point_b);
        self::assertTrue( is_array($result->routes));
    }

    /** Test: Distance Matrix */
    public function test_matrix_api() {

        /* Endpoint */
        $endpoint = self::$client->getMatrix();

        /* TODO: Walking Matrix */
        $result = $endpoint->getWalkingMatrix(self::$point_a, self::$point_b);
        self::assertTrue( is_array($result->routes) && sizeof($result->routes) > 0 );

        /* TODO: Cycling Matrix */
        $result = $endpoint->getCyclingMatrix(self::$point_a, self::$point_b);
        self::assertTrue( is_array($result->routes) && sizeof($result->routes) > 0 );

        /* TODO: Driving Matrix */
        $result = $endpoint->getDrivingMatrix(self::$point_a, self::$point_b);
        self::assertTrue( is_array($result->routes) && sizeof($result->routes) > 0 );
    }

    /** Test: Elevation */
    public function test_elevation_api() {

        /* Endpoint */
        $endpoint = self::$client->getElevation();
        self::assertTrue( true );
    }

    /** Test: Snap To Roads */
    public function test_snap_to_roads_api() {

        /* Endpoint */
        $endpoint = self::$client->getSnapToRoads();
        self::assertTrue( true );
    }

    /** Test: Static */
    public function test_static_api() {

        /* Endpoint */
        $endpoint = self::$client->getStaticMap();
        self::assertTrue( true );
    }

    /** Test: Tile */
    public function test_tile_api() {

        /* Endpoint */
        $endpoint = self::$client->getTile();
        self::assertTrue( true );
    }
}
