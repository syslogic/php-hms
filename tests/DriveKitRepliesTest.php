<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace Tests;

use HMS\DriveKit\DriveKit;

/**
 * HMS DriveKit / Replies Test
 *
 * @author Martin Zeitler
 */
class DriveKitRepliesTest extends BaseTestCase {

    /** @var DriveKit|null $client */
    private static ?DriveKit $client;
    protected static string $file_id = 'BjDA_0bCctM1xH2A8-N5BcYVCH_afmLXN';
    protected static string $comment_id;
    protected static string $reply_id;
    protected static string $comment_text_original = 'Test comment.';
    protected static string $comment_text_updated = 'Updated test comment.';

    protected static string $reply_text_original = 'Test reply.';
    protected static string $reply_text_updated = 'Updated test reply.';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new DriveKit( self::get_user_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Replies:create */
    public function test_create() {

        // TODO: probably should just create a comment?
        $result = self::$client->getComments()->create( self::$file_id, self::$comment_text_original );
        self::$comment_id = $result->id;

        $result = self::$client->getReplies()->create( self::$file_id, self::$comment_id, self::$reply_text_original );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#reply' );
        echo print_r($result, true);
        self::$reply_id = $result->id;
    }

    /** Test: Replies:list */
    public function test_list() {
        $result = self::$client->getReplies()->list( self::$file_id, self::$comment_id );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#replyList' );
        echo print_r($result, true);
    }

    /** Test: Replies:get */
    public function test_get() {
        $result = self::$client->getReplies()->get( self::$file_id, self::$comment_id, self::$reply_id );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#reply' );
        self::assertTrue( property_exists($result, 'creator' ) && is_object($result->creator) );
        self::assertTrue( property_exists($result, 'id' ) );
        echo print_r($result, true);
    }

    /** Test: Replies:update */
    public function test_update() {
        $result = self::$client->getReplies()->update( self::$file_id, self::$comment_id, self::$reply_id, self::$comment_text_updated );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#reply' );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#reply' );
        self::assertTrue( property_exists($result, 'creator' ) && is_object($result->creator) );
        self::assertTrue( property_exists($result, 'id' ) );
        echo print_r($result, true);
    }

    /** Test: Replies:delete */
    public function test_delete() {
        $result = self::$client ->getReplies()->delete( self::$file_id, self::$comment_id, self::$reply_id );
        self::assertTrue( $result );
    }

    /** TearDown After Class */
    public static function tearDownAfterClass(): void {
        parent::tearDownAfterClass();
        $result = self::$client->getReplies()->list( self::$file_id, self::$comment_id );
        if (sizeof($result->replies) > 0) {
            foreach ($result->replies as $reply) {
                self::$client->getReplies()->delete( self::$file_id, self::$comment_id, $reply->id );
            }
        }
    }
}
