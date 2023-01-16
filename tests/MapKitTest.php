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
    private static Coordinate $point_x;
    private static Coordinate $point_y;
    private static array $coordinates_to_snap;
    private static string $marker_desc;
    private static string $path_desc;
    private static string $marker_styles = 'size:tiny|color:blue|label:p';
    private static string $path_styles = 'weight:1|color:0x0000ff80|fillcolor:0x0000ff80';
    private static string $results_path;
    private static int $map_width = 512;
    private static int $map_height = 256;
    private static int $map_zoom = 12;
    private static int $map_scale = 2;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        parent::setUpBeforeClass();

        self::$client = new MapKit( self::get_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );

        self::$results_path = getcwd().DIRECTORY_SEPARATOR.'results'.DIRECTORY_SEPARATOR;
        if (! is_dir( self::$results_path )) {mkdir( self::$results_path );}
        self::assertTrue( is_dir( self::$results_path ) );

        self::$point_a = new Coordinate(['lat' => 48.142910, 'lng' => 11.579340]); // Munich @ Dianatempel
        self::$point_b = new Coordinate(['lat' => 48.152463, 'lng' => 11.593503]); // Munich @ Chinesischer Turm
        self::$point_c = new Coordinate(['lat' => 48.153022, 'lng' => 11.582501]); // Munich @ Leopoldstraße

        self::$point_x = new Coordinate(['lat' => 54.216608, 'lng' => -4.66529]);
        self::$point_y = new Coordinate(['lat' => 54.2166, 'lng' => -4.66552]);

        self::$marker_desc = '{'.self::$point_a->asString().'}|{'.self::$point_b->asString().'}|{'.self::$point_c->asString().'}';
        self::$path_desc = '{'.self::$point_a->asString().'}|{'.self::$point_b->asString().'}|{'.self::$point_c->asString().'}';

        /* TODO: this would require better sample data; the coordinates must be at most 500m apart. */
        self::$coordinates_to_snap = [ new Coordinate(['lat' => 52.88005648589605, 'lng' => 9.056670927077944]) ];
    }

    private function saveFile(string $filename, string $raw_data) : void {
        $result = file_put_contents($filename, $raw_data);
        if (is_integer($result)) {
            echo "Saved ".$filename.", ".$result." bytes\n";
        }
    }

    /** Test: Directions API: Walking Directions */
    public function test_directions_api_walking() {
        $endpoint = self::$client->getDirections();
        $result = $endpoint->getWalkingDirections(self::$point_x, self::$point_y);
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
        self::assertTrue( property_exists($result, 'routes') && is_array($result->routes) );
    }

    /** Test: Directions API: Cycling Directions */
    public function test_directions_api_cycling() {
        $endpoint = self::$client->getDirections();
        $result = $endpoint->getCyclingDirections(self::$point_x, self::$point_y);
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
        self::assertTrue( property_exists($result, 'routes') && is_array($result->routes) );
    }

    /** Test: Directions API: Driving Directions */
    public function test_directions_api_driving() {
        $endpoint = self::$client->getDirections();
        $result = $endpoint->getDrivingDirections(self::$point_x, self::$point_y);
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
        self::assertTrue( property_exists($result, 'routes') && is_array($result->routes) );
    }

    /** Test: Distance Matrix API: Walking Distance Matrix */
    public function test_matrix_api_walking() {
        $endpoint = self::$client->getMatrix();
        $result = $endpoint->getWalkingMatrix([self::$point_a, self::$point_b], [self::$point_c]);
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
        self::assertTrue( property_exists($result, 'rows') && is_array($result->rows) );
    }

    /** Test: Distance Matrix API: Cycling Distance Matrix */
    public function test_matrix_api_cycling() {
        $endpoint = self::$client->getMatrix();
        $result = $endpoint->getCyclingMatrix([self::$point_a, self::$point_b], [self::$point_c]);
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
        self::assertTrue( property_exists($result, 'rows') && is_array($result->rows) );
    }

    /** Test: Distance Matrix API: Driving Distance Matrix */
    public function test_matrix_api_driving() {
        $endpoint = self::$client->getMatrix();
        $result = $endpoint->getDrivingMatrix([self::$point_a, self::$point_b], [self::$point_c]);
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
        self::assertTrue( property_exists($result, 'rows') && is_array($result->rows) );
    }

    /** Test: Elevation API; works */
    public function test_elevation_api() {
        $endpoint = self::$client->getElevation();
        $result = $endpoint->getElevationByLocations([self::$point_a, self::$point_b, self::$point_c]);
        self::assertTrue( property_exists($result, 'returnCode') && $result->returnCode == 0 );
        self::assertTrue( property_exists($result, 'results') && is_array($result->results) );
        self::assertTrue( sizeof($result->results) > 0 );
        // testing if we're still 500 meters above sea level.
        foreach ($result->results as $item) {
            self::assertTrue( $item->elevation > 500 );
        }
    }

    /** Test: Snap To Roads API */
    public function test_snap_to_roads_api() {
        $endpoint = self::$client->getSnapToRoads();
        $result = $endpoint->snapToRoad(self::$coordinates_to_snap);
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
        self::assertTrue( property_exists($result, 'returnCode') && $result->returnCode == 0 );
        self::assertTrue( property_exists($result, 'snappedPoints') && is_array($result->snappedPoints) );
    }

    /** Test: Static Map API; works */
    public function test_static_map_api() {

        /* Endpoint */
        $endpoint = self::$client->getStaticMap();

        /* By Location */
        $result = $endpoint->getStaticMapByLocation(self::$point_a, self::$map_width, self::$map_height, self::$map_zoom, self::$map_scale);
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
        self::assertTrue( property_exists($result, 'raw') && is_string($result->raw) && !empty($result->raw));
        self::saveFile(self::$results_path.'mapkit_01.png', $result->raw);

        /* By Marker description */
        $result = $endpoint->getStaticMapByMarkers(self::$marker_desc, self::$marker_styles, self::$map_width, self::$map_height, self::$map_zoom, self::$map_scale);
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
        self::assertTrue( property_exists($result, 'raw') && is_string($result->raw) && !empty($result->raw));
        self::saveFile(self::$results_path.'mapkit_02.png', $result->raw);

        /* By Path description */
        $result = $endpoint->getStaticMapByPath(self::$path_desc, self::$path_styles, self::$map_width, self::$map_height, self::$map_zoom, self::$map_scale);
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
        self::assertTrue( property_exists($result, 'raw') && is_string($result->raw) && !empty($result->raw));
        self::saveFile(self::$results_path.'mapkit_03.png', $result->raw);
    }

    /** Test: Map Tile API; works */
    public function test_map_tile_api() {
        $endpoint = self::$client->getTile();
        $result = $endpoint->getMapTile(5, 1, 3, 'en', 2);
        self::assertTrue( $result->code == 200, 'Not HTTP 200 OK' );
        self::assertTrue( property_exists($result, 'raw') && is_string($result->raw) && !empty($result->raw));
        self::saveFile(self::$results_path.'mapkit_tile.png', $result->raw);
    }
}
