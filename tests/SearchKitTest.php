<?php
namespace Tests;

use HMS\SearchKit\SearchKit;

/**
 * HMS SearchKit Test
 *
 * @author Martin Zeitler
 */
class SearchKitTest extends BaseTestCase {

    private static SearchKit|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new SearchKit( self::get_secret() );
        self::assertTrue( self::$client->is_ready(), 'The client is not ready.' );
    }

    /** Test: Dummy. */
    public function test_dummy() {
        self::assertTrue( true );
    }
}
