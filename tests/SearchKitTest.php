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

    private static string $web_search_term = 'test';
    private static string $image_search_term = 'test';
    private static string $video_search_term = 'test';
    private static string $news_search_term = 'test';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new SearchKit( array_merge(self::get_user_config(), [
            'oauth2_client_id' => self::$oauth2_client_id,
            'debug_mode' => false
        ] ));
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Web Search */
    public function test_web_search() {
        $result = self::$client->web_search( self::$web_search_term );
        self::assertTrue($result->code != 405, $result->message );
    }

    public function test_image_search() {
        $result = self::$client->image_search( self::$image_search_term );
        self::assertTrue($result->code != 405, $result->message );
    }

    public function test_video_search() {
        $result = self::$client->video_search( self::$video_search_term );
        self::assertTrue($result->code != 405, $result->message );
    }

    public function test_news_search() {
        $result = self::$client->news_search( self::$news_search_term );
        self::assertTrue($result->code != 405, $result->message );
    }
}
