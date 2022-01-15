<?php /** @noinspection PhpUnusedPrivateFieldInspection */

namespace Tests;

use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase {

    protected static int $client_id = 0;
    protected static string|null $client_secret = null;
    protected const CLIENT_NOT_READY = 'The client is not ready.';
    #[ArrayShape(['client_id' => "int", 'client_secret' => "null|string"])]
    protected static function get_secret(): array {
        return [
            'client_id'     => self::$client_id,
            'client_secret' => self::$client_secret
        ];
    }

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        self::assertTrue(getenv('HUAWEI_CLIENT_ID')     != false, 'Variable HUAWEI_CLIENT_ID is not set.');
        self::assertTrue(getenv('HUAWEI_CLIENT_SECRET') != false, 'Variable HUAWEI_CLIENT_SECRET is not set.');
        self::assertTrue( getenv('HUAWEI_UPLINK_HMAC')  != false, 'Variable HUAWEI_UPLINK_HMAC is not set.' );
        self::$client_id     = (int)    getenv('HUAWEI_CLIENT_ID');
        self::$client_secret = (string) getenv('HUAWEI_CLIENT_SECRET');
    }
}
