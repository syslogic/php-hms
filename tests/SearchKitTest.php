<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace Tests;

use HMS\SearchKit\SearchKit;

/**
 * HMS SearchKit Test: Skipped.
 *
 * @author Martin Zeitler
 */
class SearchKitTest extends BaseTestCase {

    /** @var SearchKit|null $client */
    private static ?SearchKit $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        parent::load_user_access_token();
        self::$client = new SearchKit( [ 'access_token' => self::$user_access_token ] );
    }

    /** Test: Skipped. */
    public function test_skipped() {
        self::markTestSkipped( "SearchKit uses an interactive OAuth2 flow -> www/searchkit.php." );
    }
}
