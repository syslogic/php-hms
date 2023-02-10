<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
namespace Tests;

use HMS\Core\Wrapper;

/**
 * HMS\Core\Wrapper Test: Skipped.
 *
 * @author Martin Zeitler
 */
class WrapperTest extends BaseTestCase {

    private static ?Wrapper $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
    }

    /** Test: Skipped. */
    public function test_skipped() {
        self::markTestSkipped( "Wrapper is an abstract class." );
    }
}
