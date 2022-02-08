<?php
namespace Tests\client;

use HMS\SmsService\SmsService;
use JetBrains\PhpStorm\ArrayShape;
use Tests\BaseTestCase;

/**
 * HMS SmsService Test
 *
 * @author Martin Zeitler
 */
class SmsServiceTest extends BaseTestCase {

    private static SmsService|null $client;

    protected static string|null $business_sms_account = null;
    protected static string|null $business_sms_password = null;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new SmsService( self::get_secret() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    #[ArrayShape(['account' => 'string', 'password' => 'string'])]
    protected static function get_secret(): array {
        return ['account' => self::$business_sms_account, 'password' => self::$business_sms_password];
    }

    /** Test: Dummy. */
    public function test_dummy() {
        self::assertTrue( true );
    }
}
