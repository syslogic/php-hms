<?php
namespace Tests\server;

use HMS\PushKit\ReceiptStatus;
use HMS\PushKit\UpstreamMessage;
use Tests\BaseTestCase;

/**
 * HMS PushKit Test
 *
 * @author Martin Zeitler
 */
class PushKitTest extends BaseTestCase {

    private static string|null $test_token             = null;
    private static string|null $hmac_verification_key  = null;

    private const ENV_VAR_HUAWEI_HMAC_VERIFICATION_KEY = 'Variable ENV_VAR_HUAWEI_HMAC_VERIFICATION_KEY is not set.';
    private const ENV_VAR_HCM_TEST_DEVICE_TOKEN        = 'Variable PHPUNIT_HCM_TEST_DEVICE_TOKEN is not set.';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::assertTrue( getenv('HUAWEI_HMAC_VERIFICATION_KEY')  != false, self::ENV_VAR_HUAWEI_HMAC_VERIFICATION_KEY);
        self::$hmac_verification_key = getenv('HUAWEI_HMAC_VERIFICATION_KEY');
        self::assertTrue( getenv('PHPUNIT_HCM_TEST_DEVICE_TOKEN')  != false, self::ENV_VAR_HCM_TEST_DEVICE_TOKEN);
        self::$test_token = getenv('PHPUNIT_HCM_TEST_DEVICE_TOKEN');
    }

    /** Test: Model UpstreamMessage. */
    public function test_upstream_message() {

        $item = new UpstreamMessage( self::$hmac_verification_key );
        self::assertTrue( is_null( $item->getRawBody() ) );

        $data_str = '{"key": "value"}';
        $raw_body = '{"message_id": "1", "from": "'.self::$test_token.'", "category": "'.self::$package_name.'", "data": "'.base64_encode($data_str).'"}';
        $signature = 'timestamp=1563105451261; nonce=:; value=E4YeOsnMtHZ6592U8B9S37238E+Hwtjfrmpf8AQXF+c=';

        // TODO: instead test this with an actual upstream message $_POST.
        // self::assertTrue( $item->hmac_verify( $raw_body, $secret_key, $signature ) );
        self::assertFalse( $item->hmac_verify( $raw_body, $signature ) );
    }

    /** Test: Model ReceiptStatus. */
    public function test_receipt_status() {
        $item = new ReceiptStatus();
        foreach ( [0, 2, 5, 6, 10, 15, 27, 102, 144, 201] as $receipt_status_code) {
            $status_message = $item->get_receipt_state( $receipt_status_code );
            self::assertTrue( !empty( $status_message ));
        }
    }
}
