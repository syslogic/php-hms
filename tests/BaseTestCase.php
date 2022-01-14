<?php /** @noinspection PhpUnusedPrivateFieldInspection */

namespace Tests;

use HMS\Core\Wrapper;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase {

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        self::assertTrue(getenv('HUAWEI_CLIENT_ID')     != false, 'Variable HUAWEI_CLIENT_ID is not set.');
        self::assertTrue(getenv('HUAWEI_CLIENT_SECRET') != false, 'Variable HUAWEI_CLIENT_SECRET is not set.');
        self::assertTrue( getenv('HUAWEI_UPLINK_HMAC')  != false, 'Variable HUAWEI_UPLINK_HMAC is not set.' );
    }
}
