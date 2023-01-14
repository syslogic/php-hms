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
    private static int $width = 512;
    private static int $height = 256;
    private static int $zoom = 12;
    private static int $scale = 2;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        parent::setUpBeforeClass();

        self::$client = new MapKit( self::get_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );

        self::$point_a = new Coordinate(['lat' => 48.142910, 'lng' => 11.579340]); // Munich @ Dianatempel
        self::$point_b = new Coordinate(['lat' => 48.152463, 'lng' => 11.593503]); // Munich @ Chinesischer Turm
        self::$point_c = new Coordinate(['lat' => 48.153022, 'lng' => 11.582501]); // Munich @ Leopoldstraße

        self::$point_x = new Coordinate(['lat' => 54.216608, 'lng' => -4.66529]);
        self::$point_y = new Coordinate(['lat' => 54.2166, 'lng' => -4.66552]);

        /* TODO: this would require better sample data; the coordinates must be at most 500m apart. */
        self::$coordinates_to_snap = [ self::$point_x ];

        self::$marker_desc = '{'.self::$point_a->asString().'}|{'.self::$point_b->asString().'}|{'.self::$point_c->asString().'}';
        self::$path_desc = '{'.self::$point_a->asString().'}|{'.self::$point_b->asString().'}|{'.self::$point_c->asString().'}';
    }

    private function saveFile(string $filename, string $raw_data) : void {
        $result = file_put_contents($filename, $raw_data);
        if (is_integer($result)) {
            echo "Saved ".$filename.", ".$result." bytes\n";
        }
    }

    /** Test: Directions API */
    public function test_directions_api() {

        /* Endpoint */
        $endpoint = self::$client->getDirections();

        /* Walking Directions */
        $result = $endpoint->getWalkingDirections(self::$point_x, self::$point_y);
        // self::assertTrue( property_exists($result, 'routes') && is_array($result->routes) );
        self::assertTrue( $result->code != 405 );

        /* Cycling Directions */
        $result = $endpoint->getCyclingDirections(self::$point_x, self::$point_y);
        // self::assertTrue( property_exists($result, 'routes') && is_array($result->routes) );
        self::assertTrue( $result->code != 405 );

        /* Driving Directions */
        $result = $endpoint->getDrivingDirections(self::$point_x, self::$point_y);
        // self::assertTrue( property_exists($result, 'routes') && is_array($result->routes) );
        self::assertTrue( $result->code != 405 );
    }

    /** Test: Distance Matrix API */
    public function test_matrix_api() {

        /* Endpoint */
        $endpoint = self::$client->getMatrix();

        /* Walking Distance Matrix */
        $result = $endpoint->getWalkingMatrix([self::$point_a, self::$point_b], [self::$point_c]);
        // self::assertTrue( property_exists($result, 'rows') && is_array($result->rows) );
        self::assertTrue( $result->code != 405 );

        /* Cycling Distance Matrix */
        $result = $endpoint->getCyclingMatrix([self::$point_a, self::$point_b], [self::$point_c]);
        // self::assertTrue( property_exists($result, 'rows') && is_array($result->rows) );
        self::assertTrue( $result->code != 405 );

        /* Driving Distance Matrix */
        $result = $endpoint->getDrivingMatrix([self::$point_a, self::$point_b], [self::$point_c]);
        // self::assertTrue( property_exists($result, 'rows') && is_array($result->rows) );
        self::assertTrue( $result->code != 405 );
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
        $result = $endpoint->snapToRoad(self::$coordinates_to_snap);
        self::assertTrue( $result->code != 405 );
    }

    /** Test: Static Map API */
    public function test_static_api() {

        /* Endpoint */
        $endpoint = self::$client->getStaticMap();
        $results_path = getcwd().DIRECTORY_SEPARATOR.'results'.DIRECTORY_SEPARATOR;
        self::assertTrue( is_dir( $results_path ) );

        /* By Location */
        $result = $endpoint->getStaticMapByLocation(self::$point_a, self::$width, self::$height, self::$zoom, self::$scale);
        self::assertTrue( property_exists($result, 'raw') && is_string($result->raw) && !empty($result->raw));
        self::saveFile($results_path.'mapkit_01.png', $result->raw);

        /* By Marker description */
        $result = $endpoint->getStaticMapByMarkers(self::$marker_desc, self::$marker_styles, self::$width, self::$height, self::$zoom, self::$scale);
        self::assertTrue( property_exists($result, 'raw') && is_string($result->raw) && !empty($result->raw));
        self::saveFile($results_path.'mapkit_02.png', $result->raw);

        /* By Path description */
        $result = $endpoint->getStaticMapByPath(self::$path_desc, self::$path_styles, self::$width, self::$height, self::$zoom, self::$scale);
        self::assertTrue( property_exists($result, 'raw') && is_string($result->raw) && !empty($result->raw));
        self::saveFile($results_path.'mapkit_03.png', $result->raw);
    }

    /** Test: Map Tile API */
    public function test_tile_api() {

        /* Endpoint */
        $endpoint = self::$client->getTile();
        $result = $endpoint->getMapTile(512, 512);
        self::assertTrue( property_exists($result, 'url') && is_string($result->url) );
    }
}
