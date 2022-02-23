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

    private const ENV_VAR_API_KEY     = 'Variable HUAWEI_API_KEY is not set.';

    #[ArrayShape(['api_key' => "string"])]
    protected static function get_secret(): array {
        return [ 'api_key' => self::$api_key ];
    }

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        parent::setUpBeforeClass();

        self::$api_key = getenv('HUAWEI_API_KEY');
        self::assertTrue(is_string(self::$api_key), self::ENV_VAR_API_KEY);

        self::$client = new MapKit( self::get_secret() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Directions API. */
    public function test_directions_api() {
        $endpoint = self::$client->getDirections();
        self::assertTrue( is_object($endpoint) );
    }

    /** Test: Matrix API. */
    public function test_matrix_api() {
        $endpoint = self::$client->getMatrix();
        self::assertTrue( is_object($endpoint) );
    }

    /** Test: Elevation API. */
    public function test_elevation_api() {
        $endpoint = self::$client->getElevation();
        self::assertTrue( is_object($endpoint) );
    }

    /** Test: SnapToRoads API. */
    public function test_snap_to_roads_api() {
        $endpoint = self::$client->getSnapToRoads();
        self::assertTrue( is_object($endpoint) );
    }

    /** Test: Static API. */
    public function test_static_api() {
        $endpoint = self::$client->getStaticMap();
        self::assertTrue( is_object($endpoint) );
    }

    /** Test: Tile API. */
    public function test_tile_api() {
        $endpoint = self::$client->getTile();
        self::assertTrue( is_object($endpoint) );
    }
}
