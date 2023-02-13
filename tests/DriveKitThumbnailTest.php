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
    protected static ?string $file_name_01 = 'thumbnail_01.png';
    protected static ?string $file_name_02 = 'thumbnail_02.png';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new DriveKit( self::get_user_config() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Thumbnail:get */
    public function test_get_thumbnail_default() {
        $result = self::$client->getThumbnail()->get( self::$file_id );
        self::assertTrue( property_exists($result, 'code' ) && $result->code == 200 );
        self::assertTrue( property_exists($result, 'base64' ) );
        self::assertTrue( property_exists($result, 'raw' ) );
        self::save_file(self::$build_path . self::$file_name_01, $result->raw);
    }

    /** Test: Thumbnail:get */
    public function test_get_thumbnail_small() {
        $result = self::$client->getSmallThumbnail()->get( self::$file_id );
        self::assertTrue( property_exists($result, 'code' ) && $result->code == 200 );
        self::assertTrue( property_exists($result, 'base64' ) );
        self::assertTrue( property_exists($result, 'raw' ) );
        self::save_file(self::$build_path . self::$file_name_02, $result->raw);
    }

    /** TearDown After Class */
    public static function tearDownAfterClass(): void {
        parent::tearDownAfterClass();
    }
}
