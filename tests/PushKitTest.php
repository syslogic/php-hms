<?php
namespace Tests;

use HMS\PushKit\Android\AndroidConfig;
use HMS\PushKit\Android\AndroidNotification;
use HMS\PushKit\Android\BadgeNotification;
use HMS\PushKit\Android\Button;
use HMS\PushKit\Android\ClickAction;
use HMS\PushKit\Apns\ApnsConfig;
use HMS\PushKit\Apns\ApnsNotification;
use HMS\PushKit\CloudMessage;
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

/**
 * HMS PushKit Test
 *
 * @author Martin Zeitler
 */
class PushKitTest extends BaseTestCase {

    private static ?PushKit $client;

    private static ?string $test_token         = null;
    private static ?string $test_topic         = null;
    private static ?string $test_condition     = null;
    private static ?string $test_message_title = null;
    private static ?string $test_message_body  = null;

    private const ENV_VAR_HUAWEI_HMAC_VERIFICATION_KEY = 'Variable ENV_VAR_HUAWEI_HMAC_VERIFICATION_KEY is not set.';
    private static ?string $hmac_verification_key  = null;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {

        parent::setUpBeforeClass();

        self::$client = new PushKit( self::get_config() );

        self::$test_topic         = 'TopicA';
        self::$test_condition     = "'TopicA' in topics && ('TopicB' in topics || 'TopicC' in topics)";
        self::$test_message_title = 'Test Message from PHP ' . phpversion();
        self::$test_message_body  = 'Test Body';

        self::assertTrue( getenv('HUAWEI_HMAC_VERIFICATION_KEY')  != false, self::ENV_VAR_HUAWEI_HMAC_VERIFICATION_KEY);
        self::$hmac_verification_key = getenv('HUAWEI_HMAC_VERIFICATION_KEY');

        self::assertTrue( getenv('PHPUNIT_HCM_TEST_DEVICE_TOKEN')  != false, self::ENV_VAR_HCM_TEST_DEVICE_TOKEN);
        self::$test_token = getenv('PHPUNIT_HCM_TEST_DEVICE_TOKEN');
    }

    /** Test: Topic subscriptions list. */
    public function test_topics_list() {
        $result = self::$client->topics_list( self::$test_token );
        self::assertTrue(property_exists($result, 'code'));
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
        self::assertTrue( is_array( $result->topics ) );
    }

    /** Test: Topic subscribe. */
    public function test_topic_subscribe() {
        $result = self::$client->topic_subscribe( self::$test_topic, self::$test_token );
        self::assertTrue(property_exists($result, 'code'));
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
        self::assertTrue(is_array( $result->errors ) && sizeof( $result->errors ) == 0 );
        self::assertTrue($result->failureCount == 0 );
        self::assertTrue($result->successCount == 1 );
    }

    /** Test: Topic unsubscribe. */
    public function test_topic_unsubscribe() {
        $result = self::$client->topic_unsubscribe( self::$test_topic, self::$test_token );
        self::assertTrue(property_exists($result, 'code'));
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
        self::assertTrue(is_array( $result->errors ) && sizeof( $result->errors ) == 0 );
        self::assertTrue($result->failureCount == 0 );
        self::assertTrue($result->successCount == 1 );
    }

    /** Test: Send message to token. */
    public function test_send_message_to_token() {
        $result = self::$client->send_message_to_token( self::$test_token, self::$test_message_title, self::$test_message_body );
        self::assertTrue(property_exists($result, 'code'));
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
    }

    /** Test: Send message to topic. */
    public function test_send_message_to_topic() {
        $result = self::$client->send_message_to_topic( self::$test_topic, self::$test_message_title, self::$test_message_body );
        self::assertTrue(property_exists($result, 'code'));
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
    }

    /** Test: Send message to condition. */
    public function test_send_message_to_condition() {
        $result = self::$client->send_message_to_condition( self::$test_condition, self::$test_message_title, self::$test_message_body );
        self::assertTrue(property_exists($result, 'code'));
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
    }

    /** Test: Querying Data as a Data Controller. */
    public function test_token_data_query() {
        $result = self::$client->token_data_query( self::$test_token );
        self::assertTrue(property_exists($result, 'code'));
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
        self::assertTrue( is_array( $result->topics ) );
    }

    /** Test: Deleting Data as a Data Controller. */
    public function test_token_data_delete() {
        $result = self::$client->token_data_delete( self::$test_token );
        self::assertTrue(property_exists($result, 'code'));
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
    }

    /** Test: Model ResultCodes. */
    public function test_model_result_codes() {
        $item = new ResultCodes();
        self::assertTrue( is_object( $item ) );
    }

    /** Test: Model CloudMessage. */
    public function test_model_cloud_message() {
        $item = new CloudMessage([
            'notification' => new Notification( [
                'title' => 'PHPUnit',
                'body' => 'test body'
            ] ),
            'token' => [
                self::$test_token
            ]
        ]);
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model Notification. */
    public function test_model_notification() {
        $item = new Notification(self::$test_message_title, self::$test_message_body );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }


    /** Test: Model Android\AndroidConfig. */
    public function test_model_android_config() {
        $item = new AndroidConfig( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model Android\AndroidNotification. */
    public function test_model_android_notification() {
        $item = AndroidNotification::fromArray([
            'title' => self::$test_message_title,
            'body' => self::$test_message_body,
            'click_action' => [
                'type' => 2,
                'url' => 'https://syslogic.io'
            ]
        ]);
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model Android\BadgeNotification. */
    public function test_model_badge_notification() {
        $item = new BadgeNotification( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model Android\ClickAction. */
    public function test_model_click_action() {
        $item = new ClickAction( [
            'type' => 2,
            'url' => 'https://syslogic.io'
        ] );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model Android\Button. */
    public function test_model_button() {
        $item = new Button( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }


    /** Test: Model Apns\ApnsConfig. */
    public function test_model_apns_config() {
        $item = new ApnsConfig( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model Apns\ApnsNotification. */
    public function test_model_apns_notification() {
        $item = new ApnsNotification( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model ApnsConfig.HmsOptions. */
    public function test_model_apns_hms_options() {
        $item = new \HMS\PushKit\Apns\HmsOptions( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }


    /** Test: Model QuickApp\QuickAppConfig. */
    public function test_model_quick_app_config() {
        $item = new QuickAppConfig( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model QuickApp\QuickAppNotification. */
    public function test_model_quick_app_notification() {
        $item = new QuickAppNotification( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }


    /** Test: Model WebPush\WebPushConfig. */
    public function test_model_web_push_config() {
        $item = new WebPushConfig( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model WebPush\WebNotification. */
    public function test_model_web_notification() {
        $item = new WebNotification( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model WebPush\WebAction. */
    public function test_model_web_action() {
        $item = new WebAction( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model WebPush\Headers. */
    public function test_model_web_headers() {
        $item = new Headers( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model WebPushConfig.HmsOptions. */
    public function test_model_web_hms_options() {
        $item = new \HMS\PushKit\WebPush\HmsOptions( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model UpstreamMessage. */
    public function test_upstream_message() {
        $item = new UpstreamMessage( self::$hmac_verification_key );
        $data_str = '{"key": "value"}';
        $raw_body = '{"message_id": "1", "from": "'.self::$test_token.'", "category": "'.self::$package_name.'", "data": "'.base64_encode($data_str).'"}';
        $signature = 'timestamp=1563105451261; nonce=:; value=NzliODAzYTAxNWE2NjA2ZGFmMGNkZWIyY2E0ZTQzYWQ4YWI1ZmI4NjgxNzA1ODY0NzBmMmQ4MTZhNTEyNDY3Ng==';
        self::assertTrue( $item->hmac_verify( $raw_body, $signature ) );
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
