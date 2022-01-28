<?php
namespace Tests;

use HMS\PushKit\Android\AndroidConfig;
use HMS\PushKit\Android\AndroidNotification;
use HMS\PushKit\Android\BadgeNotification;
use HMS\PushKit\Android\Button;
use HMS\PushKit\Android\ClickAction;
use HMS\PushKit\Apns\ApnsConfig;
use HMS\PushKit\Apns\ApnsNotification;
use HMS\PushKit\Message;
use HMS\PushKit\Notification;
use HMS\PushKit\PushKit;
use HMS\PushKit\QuickApp\QuickAppConfig;
use HMS\PushKit\QuickApp\QuickAppNotification;
use HMS\PushKit\ReceiptStatus;
use HMS\PushKit\ResultCodes;
use HMS\PushKit\UpstreamMessage;
use HMS\PushKit\WebPush\Headers;
use HMS\PushKit\WebPush\WebAction;
use HMS\PushKit\WebPush\WebNotification;
use HMS\PushKit\WebPush\WebPushConfig;
use stdClass;

/**
 * HMS PushKit Test
 *
 * @author Martin Zeitler
 */
class PushKitTest extends BaseTestCase {

    private static PushKit|null $client;

    private static string|null $test_token            = null;
    private static string|null $test_topic            = null;
    private static string|null $test_condition        = null;
    private static string|null $hmac_verification_key = null;
    private static string|null $test_message_title    = null;
    private static string|null $test_message_body     = null;

    private const ENV_VAR_HUAWEI_HMAC_VERIFICATION_KEY = 'Variable ENV_VAR_HUAWEI_HMAC_VERIFICATION_KEY is not set.';
    private const ENV_VAR_HCM_TEST_DEVICE_TOKEN        = 'Variable PHPUNIT_HCM_TEST_DEVICE_TOKEN is not set.';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        if ( getenv('GITHUB_RUN_NUMBER') !== false) {
            self::$client = new PushKit( self::get_secret_from_file() );
        } else {
            self::$client = new PushKit( self::get_secret() );
        }

        self::$test_topic = 'test';
        self::$test_condition = "'TopicA' in topics && ('TopicB' in topics || 'TopicC' in topics)";
        self::$test_message_title = 'Test Message from PHP ' . phpversion();
        self::$test_message_body = 'Test Body';

        self::assertTrue( getenv('HUAWEI_HMAC_VERIFICATION_KEY')  != false, self::ENV_VAR_HUAWEI_HMAC_VERIFICATION_KEY);
        self::$hmac_verification_key = getenv('HUAWEI_HMAC_VERIFICATION_KEY');

        self::assertTrue( getenv('PHPUNIT_HCM_TEST_DEVICE_TOKEN')  != false, self::ENV_VAR_HCM_TEST_DEVICE_TOKEN);
        self::$test_token = getenv('PHPUNIT_HCM_TEST_DEVICE_TOKEN');
    }

    /** Test: Topic subscriptions list. */
    public function test_topics_list() {
        $result = self::$client->topics_list( self::$test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
        self::assertTrue( is_array( $result->topics ) );
    }

    /** Test: Topic subscribe. */
    public function test_topic_subscribe() {
        $result = self::$client->topic_subscribe( self::$test_topic, self::$test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
        self::assertTrue(is_array( $result->errors ) && sizeof( $result->errors ) == 0 );
        self::assertTrue($result->failureCount == 0 );
        self::assertTrue($result->successCount == 1 );
    }

    /** Test: Topic unsubscribe. */
    public function test_topic_unsubscribe() {
        $result = self::$client->topic_unsubscribe( self::$test_topic, self::$test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
        self::assertTrue(is_array( $result->errors ) && sizeof( $result->errors ) == 0 );
        self::assertTrue($result->failureCount == 0 );
        self::assertTrue($result->successCount == 1 );
    }

    /** Test: Send message to token. */
    public function test_send_message_to_token() {
        $result = self::$client->send_message_to_token( self::$test_token, self::$test_message_title, self::$test_message_body );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
    }

    /** Test: Send message to topic. */
    public function test_send_message_to_topic() {
        $result = self::$client->send_message_to_topic( self::$test_topic, self::$test_message_title, self::$test_message_body );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
    }

    /** Test: Send message to condition. */
    public function test_send_message_to_condition() {
        $result = self::$client->send_message_to_condition( self::$test_condition, self::$test_message_title, self::$test_message_body );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
    }

    /** Test: Querying Data as a Data Controller. */
    public function test_token_data_query() {
        $result = self::$client->token_data_query( self::$test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
        self::assertTrue( is_array( $result->topics ) );
    }

    /** Test: Deleting Data as a Data Controller. */
    public function test_token_data_delete() {
        $result = self::$client->token_data_delete( self::$test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
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
            self::assertTrue( is_string( $status_message ) );
        }
    }

    /** Test: Model ResultCodes. */
    public function test_result_codes() {
        $item = new ResultCodes();
        self::assertTrue( is_object( $item ) );
    }

    /** Test: Model Message. */
    public function test_message() {
        $item = new Message([

        ]);
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model Notification. */
    public function test_notification() {
        $item = new Notification(self::$test_message_title, self::$test_message_body );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }


    /** Test: Model Android\AndroidConfig. */
    public function test_android_config() {
        $item = new AndroidConfig( [
            'notification' => new AndroidNotification( [

            ] )
        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model Android\AndroidNotification. */
    public function test_android_notification() {
        $item = new AndroidNotification( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model Android\BadgeNotification. */
    public function test_badge_notification() {
        $item = new BadgeNotification( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model Android\ClickAction. */
    public function test_click_action() {
        $item = new ClickAction( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model Android\Button. */
    public function test_button() {
        $item = new Button( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }


    /** Test: Model Apns\ApnsConfig. */
    public function test_apns_config() {
        $item = new ApnsConfig( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model Apns\ApnsNotification. */
    public function test_apns_notification() {
        $item = new ApnsNotification( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model ApnsConfig.HmsOptions. */
    public function test_apns_hms_options() {
        $item = new \HMS\PushKit\Apns\HmsOptions( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }


    /** Test: Model QuickApp\QuickAppConfig. */
    public function test_quick_app_config() {
        $item = new QuickAppConfig( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model QuickApp\QuickAppNotification. */
    public function test_quick_app_notification() {
        $item = new QuickAppNotification( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }


    /** Test: Model WebPush\WebPushConfig. */
    public function test_web_push_config() {
        $item = new WebPushConfig( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model WebPush\WebNotification. */
    public function test_web_notification() {
        $item = new WebNotification( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model WebPush\WebAction. */
    public function test_web_action() {
        $item = new WebAction( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model WebPush\Headers. */
    public function test_web_headers() {
        $item = new Headers( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model WebPushConfig.HmsOptions. */
    public function test_web_hms_options() {
        $item = new \HMS\PushKit\WebPush\HmsOptions( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }
}
