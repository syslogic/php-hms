<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace Tests;

use HMS\SearchKit\SearchKit;

/**
 * HMS SearchKit Test: OK.
 *
 * @author Martin Zeitler
 */
class SearchKitTest extends BaseTestCase {

    /** @var SearchKit|null $client */
    private static ?SearchKit $client;

    private static string $web_search_term = 'test';
    private static string $image_search_term = 'test';
    private static string $video_search_term = 'test';
    private static string $news_search_term = 'test';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        if ( is_string( getenv('HUAWEI_APP_LEVEL_CLIENT_ID' ) ) ) {
            self::$oauth2_client_id = getenv('HUAWEI_APP_LEVEL_CLIENT_ID');
        }
        if ( is_string( getenv('HUAWEI_APP_LEVEL_CLIENT_SECRET' ) ) ) {
            self::$oauth2_client_secret = getenv('HUAWEI_APP_LEVEL_CLIENT_SECRET');
        }
        self::$client = new SearchKit( [
            'oauth2_client_id' => self::$oauth2_client_id,
            'oauth2_client_secret' => self::$oauth2_client_secret
        ] );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Web Search */
    public function test_web_search() {
        $result = self::$client->web_search( self::$web_search_term );
        self::assertTrue(property_exists($result, 'request_id') && is_string($result->request_id) );
        self::assertTrue(property_exists($result, 'data') && is_array($result->data) );
        echo print_r($result->data, true);
    }

    /** Test: Image Search */
    public function test_image_search() {
        $result = self::$client->image_search( self::$image_search_term );
        self::assertTrue(property_exists($result, 'request_id') && is_string($result->request_id) );
        self::assertTrue(property_exists($result, 'data') && is_array($result->data) );
        echo print_r($result->data, true);
    }

    /** Test: Video Search */
    public function test_video_search() {
        $result = self::$client->video_search( self::$video_search_term );
        self::assertTrue(property_exists($result, 'request_id') && is_string($result->request_id) );
        self::assertTrue(property_exists($result, 'data') && is_array($result->data) );
        echo print_r($result->data, true);
    }

    /** Test: News Search */
    public function test_news_search() {
        $result = self::$client->news_search( self::$news_search_term );
        self::assertTrue(property_exists($result, 'request_id') && is_string($result->request_id) );
        self::assertTrue(property_exists($result, 'data') && is_array($result->data) );
        echo print_r($result->data, true);
    }
}
