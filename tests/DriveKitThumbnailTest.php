<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace Tests;

use HMS\DriveKit\DriveKit;

/**
 * HMS DriveKit / Thumbnail Test
 *
 * @author Martin Zeitler
 */
class DriveKitThumbnailTest extends BaseTestCase {

    /** @var DriveKit|null $client */
    private static ?DriveKit $client;
    protected static string $file_id = 'BjDA_0bCctM1xH2A8-N5BcYVCH_afmLXN';
    protected static ?string $comment_id;
    protected static string $comment_text_original = 'Test comment.';
    protected static string $comment_text_updated = 'Updated test comment.';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new DriveKit( self::get_user_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Thumbnail:get */
    public function test_get_thumbnail() {
        $result = self::$client->getThumbnail()->get( self::$file_id );
        self::assertTrue( property_exists($result, 'code' ) && $result->code == 200 );
        self::assertTrue( property_exists($result, 'base64' ) );
        self::assertTrue( property_exists($result, 'raw' ) );
        self::saveFile(self::$build_path.'thumbnail_01.png', $result->raw);
        echo print_r($result, true);
    }

    /** Test: Thumbnail:get */
    public function test_get_small_thumbnail() {
        $result = self::$client->getSmallThumbnail()->get( self::$file_id );
        self::assertTrue( property_exists($result, 'code' ) && $result->code == 200 );
        self::assertTrue( property_exists($result, 'base64' ) );
        self::assertTrue( property_exists($result, 'raw' ) );
        self::saveFile(self::$build_path.'thumbnail_02.png', $result->raw);
        echo print_r($result, true);
    }

    /** TearDown After Class */
    public static function tearDownAfterClass(): void {
        parent::tearDownAfterClass();
    }
}
