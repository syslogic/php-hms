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
    private static Coordinate $point_c;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        parent::setUpBeforeClass();

        self::$client = new MapKit( self::get_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );

        self::$point_a = new Coordinate(['lat' => 48.142910, 'lng' => 11.579340]); // Munich @ Dianatempel
        self::$point_b = new Coordinate(['lat' => 48.152463, 'lng' => 11.593503]); // Munich @ Chinesischer Turm
        self::$point_c = new Coordinate(['lat' => 48.153022, 'lng' => 11.582501]); // Munich @ Leopoldstraße
    }

    /** Test: Directions API */
    public function test_directions_api() {

        /* Endpoint */
        $endpoint = self::$client->getDirections();

        /* Walking Directions */
        $result = $endpoint->getWalkingDirections(self::$point_a, self::$point_b);
        self::assertTrue( property_exists($result, 'routes') && is_array($result->routes) );

        /* Cycling Directions */
        $result = $endpoint->getCyclingDirections(self::$point_a, self::$point_b);
        self::assertTrue( property_exists($result, 'routes') && is_array($result->routes) );

        /* Driving Directions */
        $result = $endpoint->getDrivingDirections(self::$point_a, self::$point_b);
        self::assertTrue( property_exists($result, 'routes') && is_array($result->routes) );
    }

    /** Test: Distance Matrix API */
    public function test_matrix_api() {

        /* Endpoint */
        $endpoint = self::$client->getMatrix();

        /* Walking Distance Matrix */
        $result = $endpoint->getWalkingMatrix([self::$point_a, self::$point_b], [self::$point_c]);
        self::assertTrue( property_exists($result, 'rows') && is_array($result->rows) );

        /* Cycling Distance Matrix */
        $result = $endpoint->getCyclingMatrix([self::$point_a, self::$point_b], [self::$point_c]);
        self::assertTrue( property_exists($result, 'rows') && is_array($result->rows) );

        /* Driving Distance Matrix */
        $result = $endpoint->getDrivingMatrix([self::$point_a, self::$point_b], [self::$point_c]);
        self::assertTrue( property_exists($result, 'rows') && is_array($result->rows) );
    }

    /** Test: Elevation API */
    public function test_elevation_api() {

        /* Endpoint */
        $endpoint = self::$client->getElevation();
        self::assertTrue( true );

        /* By Locations */
        $result = $endpoint->getElevationByLocations([self::$point_a, self::$point_b, self::$point_c]);
        self::assertTrue( property_exists($result, 'results') && is_array($result->results) );
        self::assertTrue( sizeof($result->results) > 0 );
        foreach ($result->results as $item) {
            // testing if we're still 500 meters above sea level.
            self::assertTrue( $item->elevation > 500 );
        }
    }

    /** Test: Snap To Roads API */
    public function test_snap_to_roads_api() {

        /* Endpoint */
        $endpoint = self::$client->getSnapToRoads();
        self::assertTrue( true );

        /* TODO: testing this endpoint would require sample data. */
    }

    /** Test: Static Map API */
    public function test_static_api() {

        /* Endpoint */
        $endpoint = self::$client->getStaticMap();
        self::assertTrue( true );

        $result = $endpoint->getMap(self::$point_a, 512, 512, 12, 2);
        self::assertTrue( property_exists($result, 'url') && is_string($result->url) );
    }

    /** Test: Tile API */
    public function test_tile_api() {

        /* Endpoint */
        $endpoint = self::$client->getTile();
        self::assertTrue( true );
    }
}
