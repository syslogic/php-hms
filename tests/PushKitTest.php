<?php
namespace Tests;

use HMS\PushKit\Android\AndroidConfig;
use HMS\PushKit\Android\AndroidNotification;
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

    private string $test_token = 'IQAAAACy0pLcAAHqLqNHyp_Z8K3GiRKn10I4Hn7G31ueBBwpSD4ieytFy2vmn09hrA9xOTOYPVKqGyJKejLs6IQiooN-Q70XNrZ6jMwWOFnXXZte_g';
    private string $test_condition = "'TopicA' in topics && ('TopicB' in topics || 'TopicC' in topics)";
    private string $test_topic = 'test';

    private static string $test_message_title;
    private static string $test_message_body;

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new PushKit( self::get_secret() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
        self::$test_message_title = 'Test Message from PHP ' . phpversion();
        self::$test_message_body = 'Test Body';
    }

    /** Test: Topic subscriptions list. */
    public function test_topics_list() {
        $result =  self::$client->topics_list( $this->test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
        self::assertTrue( is_array( $result->topics ) );
    }

    /** Test: Topic subscribe. */
    public function test_topic_subscribe() {
        $result = self::$client->topic_subscribe( $this->test_topic, $this->test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
        self::assertTrue(is_array( $result->errors ) && sizeof( $result->errors ) == 0 );
        self::assertTrue($result->failureCount == 0 );
        self::assertTrue($result->successCount == 1 );
    }

    /** Test: Topic unsubscribe. */
    public function test_topic_unsubscribe() {
        $result = self::$client->topic_unsubscribe( $this->test_topic, $this->test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
        self::assertTrue(is_array( $result->errors ) && sizeof( $result->errors ) == 0 );
        self::assertTrue($result->failureCount == 0 );
        self::assertTrue($result->successCount == 1 );
    }

    /** Test: Send message to token. */
    public function test_send_message_to_token() {
        $result = self::$client->send_message_to_token( $this->test_token, self::$test_message_title, self::$test_message_body );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
    }

    /** Test: Send message to topic. */
    public function test_send_message_to_topic() {
        $result = self::$client->send_message_to_topic( $this->test_topic, self::$test_message_title, self::$test_message_body );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
    }

    /** Test: Send message to condition. */
    public function test_send_message_to_condition() {
        $result = self::$client->send_message_to_condition( $this->test_condition, self::$test_message_title, self::$test_message_body );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
    }

    /** Test: Querying Data as a Data Controller. */
    public function test_token_data_query() {
        $result = self::$client->token_data_query( $this->test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
        self::assertTrue( is_array( $result->topics ) );
    }

    /** Test: Deleting Data as a Data Controller. */
    public function test_token_data_delete() {
        $result = self::$client->token_data_delete( $this->test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === ResultCodes::SUBMISSION_SUCCESS, "Error $result->code: $result->message" );
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

    /** Test: Model AndroidConfig. */
    public function test_android_config() {
        $item = new AndroidConfig( [
            'notification' => new AndroidNotification( [

            ] )
        ] );
        self::assertTrue( is_object($item->asObject()) );
    }
    /** Test: Model AndroidNotification. */
    public function test_android_notification() {
        $item = new AndroidNotification( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model ApnsConfig. */
    public function test_apns_config() {
        $item = new ApnsConfig( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }
    /** Test: Model ApnsNotification. */
    public function test_apns_notification() {
        $item = new ApnsNotification( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model QuickAppConfig. */
    public function test_quick_app_config() {
        $item = new QuickAppConfig( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }
    /** Test: Model QuickAppNotification. */
    public function test_quick_app_notification() {
        $item = new QuickAppNotification( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model QuickAppConfig. */
    public function test_web_push_config() {
        $item = new WebPushConfig( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model WebPushNotification. */
    public function test_web_push_notification() {
        $item = new WebNotification( [

        ] );
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model UpstreamMessage. */
    public function test_upstream_message() {

        $hmac_verification_key = getenv('HUAWEI_UPSTREAM_HMAC_VERIFICATION_KEY');
        $item = new UpstreamMessage( $hmac_verification_key );
        self::assertTrue( is_null( $item->getRawBody() ) );

        $data_str = '{"key": "value"}';
        $raw_body = '{"message_id": "1", "from": "'.$this->test_token.'", "category": "'.self::$package_name.'", "data": "'.base64_encode($data_str).'"}';
        $signature = 'timestamp=1563105451261; nonce=:; value=E4YeOsnMtHZ6592U8B9S37238E+Hwtjfrmpf8AQXF+c=';

        // TODO: instead test this with an actual upstream message $_POST.
        // self::assertTrue( $item->hmac_verify( $raw_body, $secret_key, $signature ) );
        self::assertFalse( $item->hmac_verify( $raw_body, $signature ) );
    }
}
