<?php
namespace Tests;

use HMS\AdsKit\AdsKit;

/**
 * HMS AdsKit Test
 *
 * @author Martin Zeitler
 */
class AdsKitTest extends BaseTestCase {

    private static AdsKit|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new AdsKit( self::get_secret() );
    }

    /** Test: oAuth2 Token Refresh. */
    public function test_ready() {
        self::assertTrue( self::$client->is_ready(), 'The client is not ready.');
    }
}
