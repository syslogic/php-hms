<?php
namespace Tests;

use HMS\LocationKit\LocationKit;

/**
 * HMS LocationKit Test
 *
 * Note: It returns noting but HTTP 403.
 *
 * @author Martin Zeitler
 */
class LocationKitTest extends BaseTestCase {

    private static LocationKit|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new LocationKit( self::get_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: GeoLocation. */
    public function test_geo_location() {
        $api = self::$client->getGeoLocation( $_ENV['TEST_GEO_CODE'] );
        $result = $api->get_result();
        self::assertEquals(403, $result->code);
    }

    /** Test: IpLocation. */
    public function test_ip_location() {
        $api = self::$client->getIpLocation( $_ENV['TEST_IP_ADDRESS'] );
        $result = $api->get_result();
        self::assertEquals(403, $result->code);
    }
}
