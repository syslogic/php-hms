<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace Tests;

use HMS\DriveKit\DriveKit;

/**
 * HMS DriveKit / Comments Test
 *
 * @author Martin Zeitler
 */
class DriveKitCommentsTest extends BaseTestCase {

    /** @var DriveKit|null $client */
    private static ?DriveKit $client;
    protected static ?string $comment_id;
    protected static string $comment_text_original = 'Test comment.';
    protected static string $comment_text_updated = 'Updated test comment.';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new DriveKit( self::get_user_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Comments:create */
    public function test_create() {
        $result = self::$client->getComments()->create( self::$file_id, self::$comment_text_original );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#comment' );
        self::assertTrue( property_exists($result, 'creator' ) && is_object($result->creator) );
        self::assertTrue( property_exists($result, 'id' ) );
        self::$comment_id = $result->id;
        echo print_r($result, true);
    }

    /** Test: Comments:list */
    public function test_list() {
        $result = self::$client->getComments()->list( self::$file_id );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#commentList' );
        self::assertTrue( property_exists($result, 'comments' ) && is_array($result->comments) );
        echo print_r($result, true);
    }

    /** Test: Comments:get */
    public function test_get() {
        $result = self::$client->getComments()->get( self::$file_id, self::$comment_id );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#comment' );
        self::assertTrue( property_exists($result, 'creator' ) && is_object($result->creator) );
        self::assertTrue( property_exists($result, 'id' ) );
        echo print_r($result, true);
    }

    /** Test: Comments:update */
    public function test_update() {
        $result = self::$client->getComments()->update( self::$file_id, self::$comment_id, self::$comment_text_updated );
        self::assertTrue( property_exists($result, 'category' ) && $result->category == 'drive#comment' );
        self::assertTrue( property_exists($result, 'creator' ) && is_object($result->creator) );
        self::assertTrue( property_exists($result, 'id' ) );
        echo print_r($result, true);
    }

    /** Test: Comments:delete */
    public function test_delete() {
        $result = self::$client ->getComments()->delete( self::$file_id, self::$comment_id );
        self::assertTrue( $result );
    }

    /** TearDown After Class */
    public static function tearDownAfterClass(): void {
        parent::tearDownAfterClass();
        $result = self::$client->getComments()->list( self::$file_id );
        if (property_exists($result, 'comments') && sizeof($result->comments) > 0) {
            foreach ($result->comments as $comment) {
                self::$client->getComments()->delete( self::$file_id, $comment->id );
            }
        }
    }
}
