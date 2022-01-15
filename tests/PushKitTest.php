<?php
namespace Tests;

use HMS\PushKit\Android\AndroidNotification;
use HMS\PushKit\Apns\ApnsNotification;
use HMS\PushKit\Notification;
use HMS\PushKit\PushKit;
use HMS\PushKit\QuickApp\QuickAppNotification;
use HMS\PushKit\ReceiptStatus;
use HMS\PushKit\ResultCodes;
use HMS\PushKit\UpstreamMessage;
use HMS\PushKit\WebPush\WebPushNotification;
use stdClass;

/**
 * HMS PushKit Test
 *
 * @author Martin Zeitler
 */
class PushKitTest extends BaseTestCase {

    private static PushKit|null $client;

    private string $test_package_name = 'io.syslogic.mobile';
    private string $test_token = 'IQAAAACy0pLcAAHXwe2KMhT8iio6kpkUzlZKY1tGEk3yYzIRwz1LHfSkT1c7erH4FxhgSd45qnKPwh8xJfsvZHfRd4J';
    private string $test_condition = "'TopicA' in topics && ('TopicB' in topics || 'TopicC' in topics)";
    private string $test_topic = 'test';

    /** This method is called before the first test of this test class is run. */
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$client = new PushKit( self::get_secret() );
        self::assertTrue( self::$client->is_ready(), self::CLIENT_NOT_READY );
    }

    /** Test: Topic subscriptions list. */
    public function test_topics_list() {
        $result =  self::$client->topics_list( $this->test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === 82000012); // token is invalid
    }

    /** Test: Topic subscribe. */
    public function test_topic_subscribe() {
        $result = self::$client->topic_subscribe( $this->test_topic, $this->test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === 82000010); // partial token processed fail
    }

    /** Test: Topic unsubscribe. */
    public function test_topic_unsubscribe() {
        $result = self::$client->topic_unsubscribe( $this->test_topic, $this->test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === 82000010); // partial token processed fail
    }

    /** Test: Send message to token. */
    public function test_send_message_to_token() {
        $result = self::$client->send_message_to_token( $this->test_token, 'Test Message', 'Test Body' );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        // self::assertTrue( $result->code === 80100003); // Illegal payload, No valid android notification payload when sending notification message to android users.
        self::assertTrue( $result->code === 80300007); // All the tokens are invalid
    }

    /** Test: Send message to topic. */
    public function test_send_message_to_topic() {
        $result = self::$client->send_message_to_topic( $this->test_topic, 'Test Message', 'Test Body');
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === 80100003); // Illegal payload, No valid android notification payload when sending notification message to android users.
        // self::assertTrue( $result->code === 80300007); // All the tokens are invalid
    }

    /** Test: Send message to condition. */
    public function test_send_message_to_condition() {
        $result = self::$client->send_message_to_condition( $this->test_condition, 'Test Message', 'Test Body');
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === 80100003); // Illegal payload, No valid android notification payload when sending notification message to android users.
        // self::assertTrue( $result->code === 80300007); // All the tokens are invalid
    }

    /** Test: Querying Data as a Data Controller. */
    public function test_token_data_query() {
        $result = self::$client->token_data_query( $this->test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === 82000012); // token is invalid
    }

    /** Test: Querying Data as a Data Controller. */
    public function test_token_data_delete() {
        $result = self::$client->token_data_delete( $this->test_token );
        self::assertTrue($result instanceof stdClass );
        self::assertObjectHasAttribute('code', $result);
        self::assertTrue( $result->code === 82000012); // token is invalid
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
        self::assertTrue( is_object($item) );
    }

    /** Test: Model Base Notification. */
    public function test_notification() {
        $item = new Notification('Test Title', 'Test Body');
        self::assertTrue( is_object($item->asObject()) );
        self::assertTrue( $item->validate() );
    }

    /** Test: Model AndroidNotification. */
    public function test_android_notification() {
        $item = new AndroidNotification('Test Title', 'Test Body');
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model ApnsNotification. */
    public function test_apns_notification() {
        $item = new ApnsNotification('Test Title', 'Test Body');
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model QuickAppNotification. */
    public function test_quick_app_notification() {
        $item = new QuickAppNotification('Test Title', 'Test Body');
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model WebPushNotification. */
    public function test_web_push_notification() {
        $item = new WebPushNotification('Test Title', 'Test Body');
        self::assertTrue( is_object($item->asObject()) );
    }

    /** Test: Model UpstreamMessage. */
    public function test_upstream_message() {

        $hmac_verification_key = getenv('HUAWEI_UPLINK_HMAC');
        $item = new UpstreamMessage( $hmac_verification_key );
        self::assertTrue( is_null( $item->getRawBody() ) );

        $data_str = '{"key": "value"}';
        $raw_body = '{"message_id": "1", "from": "'.$this->test_token.'", "category": "'.$this->test_package_name.'", "data": "'.base64_encode($data_str).'"}';
        $signature = 'timestamp=1563105451261; nonce=:; value=E4YeOsnMtHZ6592U8B9S37238E+Hwtjfrmpf8AQXF+c=';

        // TODO: instead test this with an actual upstream message $_POST.
        // self::assertTrue( $item->hmac_verify( $raw_body, $secret_key, $signature ) );
        self::assertFalse( $item->hmac_verify( $raw_body, $signature ) );
    }
}
