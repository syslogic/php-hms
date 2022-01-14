<?php
namespace Tests;

use HMS\HiAnalytics\HiAnalytics;
use PHPUnit\Framework\TestCase;

/**
 * HMS HiAnalytics Test
 *
 * @author Martin Zeitler
 */
class HiAnalyticsTest extends TestCase {

    private static HiAnalytics|null $client;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new HiAnalytics( [
            'client_id'     => (int)    getenv('HUAWEI_CLIENT_ID'),
            'client_secret' => (string) getenv('HUAWEI_CLIENT_SECRET')
        ] );
    }

    /** Test: oAuth2 Token Refresh. */
    public function test_ready() {
        self::assertTrue( self::$client->is_ready(), 'The client is not ready.');
    }
}
